<?php
// お問い合わせフォーム共通の初期化処理
require('commonContactInit.php');

// 前ページが確認ページでなければセッションを削除
// 確認ページでバリデートエラーの場合はリダイレクトで遷移するため確認ページのリファラが残らないので、
// セッションに ['form']['isConfirm'] = true を設定し、empty()で判定出来るようにしている。
if (empty($_SESSION['form']['isConfirm'])) {
// emptyの場合はリファラを確認する
if (strpos($_SERVER['HTTP_REFERER'], URL_CONFIRM) === false) {
// 前ページが確認ページでなければセッションを削除
session_destroy();
session_start();
}
}

// 前ページが確認ページかのフラグを破棄
unset($_SESSION['form']['isConfirm']);
// メール送信可能な状態かのフラグを破棄
unset($_SESSION['form']['isSend']);

// CSRFトークンを生成し、セッションに格納
// PHP 5.3 ～ 5.x ※OPENSSL導入済
if (!isset($_SESSION['form']['token'])) {
$_SESSION['form']['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// 画面表示時にJavaScriptのバリデートを実行するかのフラグ
// 戻り遷移時に初期表示
$isInitValidate = isset($_SESSION['form']['isInitValidate']) ? $_SESSION['form']['isInitValidate'] : false;

// 他画面からお問い合わせへ遷移するボタン押下時に渡される値を取得
// セッションに存在しない場合はPOST値から取得しセッションに格納
if (!isset($_SESSION['form']['contactTitle'])) {
// 存在しない場合は空文字となる
$contactTitle = mbTrim((string)filter_input(INPUT_POST, 'contactTitle', FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW));
$_SESSION['form']['contactTitle'] = $contactTitle;
}

// selectBoxのoptionタグのHTMLを生成
function generateSelectOptions($const, $selectValue)
{
$options = '';
foreach ($const as $val) {
if ($val === $selectValue) {
$options .= '<option value="' . $val . '" selected=selected>' . $val . '</option>';
} else {
$options .= '<option value="' . $val . '">' . $val . '</option>';
};
}
return $options;
}

// 都道府県 のoptionタグのHTMLを生成
$addressOptions = generateSelectOptions(SELECT_ADDRESS, s('address'));

// PHP化したhtmlの読み込み
require('index.html');