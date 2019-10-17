<?php
// お問い合わせフォーム共通の初期化処理
require('commonContactInit.php');

// POST値のCSRFトークンを取得
$token = (string)filter_input(INPUT_POST, 'token', FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW);
// CSRFトークンの存在確認とPOST値のトークンと合致しなければエラー
if (!isset($_SESSION['form']['token']) || $_SESSION['form']['token'] !== $token) {
// 確認できなければ入力画面にリダイレクト
header('Location: ' . URL_CONTACT, true, 301);
exit;
}

// メール送信可能な状態かのフラグを破棄
unset($_SESSION['form']['isSend']);

// 入力画面への戻り遷移時のJavaScriptバリデーション実行フラグをセット
$_SESSION['form']['isInitValidate'] = true;

// ■POST値を変数とセッションに格納
// 改行無しの文字列を想定している入力値のホワイトリスト
$noBrInputsKey = ['name', 'name_yomi', 'tel', 'email', 'address'];

// POSTされた文字列を想定しているデータを変数とセッションに代入（magic_quotes_gpc = On ＋ NULLバイト 対策 + 全角トリム）

foreach ($noBrInputsKey as $v) {
// なんらかの文字列になるようstringでキャスト
$$v = mbTrim((string)filter_input(INPUT_POST, $v, FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW));
$_SESSION['form'][$v] = $$v;
}
// 改行有りの文字列を想定している入力値のホワイトリスト
$hasBrInputsKey = ['content'];
foreach ($hasBrInputsKey as $v2) {
// なんらかの文字列になるようstringでキャスト
$$v2 = mbTrim((string)filter_input(INPUT_POST, $v2));
// NULLバイトを置換
$$v2 = str_replace("\0", "", $$v2);
// バリデートの文字数カウント(mb_strlen)は改行コード(\r\n)を2文字にカウントするので \n に統一
$$v2 = preg_replace("/\r\n/u", "\n", $$v2);
$_SESSION['form'][$v2] = $$v2;
}
// 配列を想定しているもの
/*$checkConsultation = filter_input(INPUT_POST, 'checkConsultation', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$_SESSION['form']['checkConsultation'] = is_array($checkConsultation) ? $checkConsultation : [];
*/
// ■入力値のバリデート処理
$isError = false;
$errorItems = [];//確認用
// 下記のvalid系関数は条件に合致しない場合にtrueを返す
// 例：必須項目で空の場合の戻り値はtrue
// 空文字でないかを判定
function validStrRequired($v)
{
return $v === '';
}
// ひらがなかを判定
function validHiragana($v)
{
return !preg_match('/^[ぁ-ん]+$/u', $v);
}
// カタカナを判定
function validKatakana($v)
{
return !preg_match('/^[ァ-ヶー]+$/u', $v);
}
// 整数（数値文字列含む）かを判定
function validDecimal($v)
{
return !preg_match('/^[0-9]+$/u', $v);
}
// メールアドレス（英数字@ドット英数字）かを判定
function validEmail($v)
{
return !preg_match('/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+$/u', $v);
}
// 指定文字数以下かを判定
function validMaxStrLen($v, $len)
{
return mb_strlen($v, 'UTF-8') > $len;
}

// お名前
// required
if (validStrRequired($name)) {
$isError = true;
$errorItems[] = 'お名前';
}
// お名前（カナ）
// required custom[onlyKatakana]
if (validStrRequired($name_yomi) || validKatakana($name_yomi)) {
$isError = true;
$errorItems[] = 'お名前（カナ）';
}
// TEL
// custom[decimal], maxSize[15]
if ($tel !== '') {
if (validDecimal($tel) || validMaxStrLen($tel, 15)) {
$isError = true;
$errorItems[] = 'TEL';
}
}
// メールアドレス
// required, custom[email], maxSize[256]
if (validStrRequired($email) || validEmail($email) || validMaxStrLen($email, 256)) {
$isError = true;
$errorItems[] = 'メールアドレス';
}
// 都道府県
// selectBoxでrequired
if (!isset(SELECT_ADDRESS[$address])) {
$isError = true;
$errorItems[] = '都道府県';
}
// お問い合わせ内容
// maxSize[1000]
if (validMaxStrLen($content, 1000)) {
$isError = true;
$errorItems[] = 'お問い合わせ内容';
}

// エラーがあれば入力画面に戻す
if ($isError) {
// リダイレクトだと確認ページのリファラが残らないため、一時的にセッションをセット
$_SESSION['form']['isConfirm'] = true;
header('Location: ' . URL_CONTACT, true, 301);
exit;
}
$_SESSION['form']['isInitValidate'] = false;

// お問い合わせ内容
$content = nl2br(h($content));

// メール送信可能な状態かのフラグをセット
$_SESSION['form']['isSend'] = true;

require('confirm.html');
