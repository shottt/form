<?php
// お問い合わせフォーム共通の初期化処理
require('commonContactInit.php');

// 送信を行える状態かを確認する
function canComplete()
{
// CSRFトークンがセッション上に存在するか
if (!isset($_SESSION['form']['token'])) {
return false;
}
// POST値のCSRFトークンとセッション上のトークンが一致するか
$token = (string)filter_input(INPUT_POST, 'token', FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW);
if ($_SESSION['form']['token'] !== $token) {
return false;
}
// 送信に必要な情報がセッション上に存在するか
if (empty($_SESSION['form']['isSend'])) {
return false;
}
return true;
}
// CSRFトークンの確認とPOST値のトークンと合致するか、またメール送信可能な状態か
if (!canComplete()) {
// 確認できなければ入力画面にリダイレクト
header('Location: ' . URL_CONTACT, true, 301);
exit;
}

// メール文面用パラメータの作成
function createMailBodyParams()
{
// お問い合わせ内容
$params['contactContent'] = '';
// お問い合わせ内容のタイトルが空文字でなければ文章に含める
$contactTitle = s('contactTitle');
if ($contactTitle !== '') {
$contactTitle = $contactTitle . 'について' . "\n";
}
// お名前
$params['name'] = s('name', false);
// お名前（カナ）
$params['name_yomi'] = s('name_yomi', false);
// 電話番号
$params['tel'] = s('tel', false);
// メールアドレス
$params['email'] = s('email', false);
// 都道府県
$params['address'] = s('address', false);
// お問い合わせ内容
$params['content'] = s('content', false);
return $params;
}

// 入力値の受け取り
$params = createMailBodyParams();

// ユーザー宛
$subject = '【グッドライフビジネスサポート】お問い合わせありがとうございます。';
$body = getUserBody($params);
userSendMail($params, $subject, $body);

// 管理者宛
$subject = 'お問い合わせがありました';
$body = getAdminBody($params);

adminSendMail($params, $subject, $body);

session_destroy();

function getUserBody($params)
{
$body = <<< EOM
{$params['name']}　様

この度は、お問い合わせいただきありがとうございます。
後ほど弊社担当者よりご連絡させていただきます。
（※日曜、祝日は休みのため、翌営業日に改めてご返信させていただきます。）

お名前：
{$params['name']}

お名前（カナ）：
{$params['name_yomi']}

電話番号：
{$params['tel']}

メールアドレス：
{$params['email']}

都道府県：
{$params['address']}

お問い合わせ内容：
{$params['content']}

#ERROR!
株式会社グッドライフビジネスサポート https://glbs.co.jp

※このメールは自動応答メールです。
ご返信はしないようお願いいたします。
#ERROR!
EOM;

return $body;
}

function userSendMail($params, $subject, $body)
{
mb_language("uni");
mb_internal_encoding("UTF-8");
$to      = $params['email'];
$headers = 'From: ' . mb_encode_mimeheader('グッドライフビジネスサポート') . '<info@glbs.co.jp>' . "\r\n";
// メール送信
mb_send_mail($to, $subject, $body, $headers);
}

function getAdminBody($params)
{
$body = <<< EOM
管理者　様

WEBに以下のお問い合わせがありました。

お名前：
{$params['name']}

お名前（カナ）：
{$params['name_yomi']}

電話番号：
{$params['tel']}

メールアドレス：
{$params['email']}

都道府県：
{$params['address']}

お問い合わせ内容：
{$params['content']}
EOM;

return $body;
}

function adminSendMail($params, $subject, $body)
{
mb_language("uni");
mb_internal_encoding("UTF-8");
// $to      = $params['email'];//動作確認用
$to      = 'info@glbs.co.jp';//本番用メールアドレス
$headers = 'From: info@glbs.co.jp' . "\r\n";
// メール送信
mb_send_mail($to, $subject, $body, $headers);

// バックス向け
$to      = 'n-itano@backs.co.jp';
$headers = 'From: info@glbs.co.jp' . "\r\n";
// メール送信
mb_send_mail($to, $subject, $body, $headers);
}

require('complete.html');