<?php
// このページではJavaScriptからCookieへのアクセスは必要ないので、アクセス出来ないようPHP側でも指定
ini_set('session.cookie_httponly', 1);
// Web ブラウザのXSS防止機能を有効にする
header('X-XSS-Protection: 1; mode=block');
// XSS対策、ブラウザ(IE)によってはContent-Typeの指定を無視することがあるので変更を防止
header('X-Content-Type-Options: nosniff');
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');
// 文字化け対策でPHPでも文字コードを指定
header("Content-type: text/html; charset=utf-8");

// セッション開始
session_start();

// ■共通関数
// HTML特殊文字をエスケープする関数
function h($str)
{
return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
// セッションに指定のキー名が無ければ空文字を返す
function s($key, $isHtmlEscape = true)
{
$val = isset($_SESSION['form'][$key]) ? $_SESSION['form'][$key] : '';
return $isHtmlEscape ? h($val) : $val;
}
// 全角に対応した左右トリム
function mbTrim($str)
{
static $chars = "[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]";
return preg_replace("/\A{$chars}++|{$chars}++\z/u", '', $str);
}

// ■各種定数
// URLの定数
const URL_CONTACT= '/contact/';
const URL_CONFIRM = '/contact/confirm.html';
const URL_COMPLETE = '/contact/complete.html';

// 都道府県
const SELECT_ADDRESS = [
'北海道' => '北海道',
'青森県' => '青森県',
'岩手県' => '岩手県',
'宮城県' => '宮城県',
'秋田県' => '秋田県',
'山形県' => '山形県',
'福島県' => '福島県',
'茨城県' => '茨城県',
'栃木県' => '栃木県',
'群馬県' => '群馬県',
'埼玉県' => '埼玉県',
'千葉県' => '千葉県',
'東京都' => '東京都',
'神奈川県' => '神奈川県',
'新潟県' => '新潟県',
'富山県' => '富山県',
'石川県' => '石川県',
'福井県' => '福井県',
'山梨県' => '山梨県',
'長野県' => '長野県',
'岐阜県' => '岐阜県',
'静岡県' => '静岡県',
'愛知県' => '愛知県',
'三重県' => '三重県',
'滋賀県' => '滋賀県',
'京都府' => '京都府',
'大阪府' => '大阪府',
'兵庫県' => '兵庫県',
'奈良県' => '奈良県',
'和歌山県' => '和歌山県',
'鳥取県' => '鳥取県',
'島根県' => '島根県',
'岡山県' => '岡山県',
'広島県' => '広島県',
'山口県' => '山口県',
'徳島県' => '徳島県',
'香川県' => '香川県',
'愛媛県' => '愛媛県',
'高知県' => '高知県',
'福岡県' => '福岡県',
'佐賀県' => '佐賀県',
'長崎県' => '長崎県',
'熊本県' => '熊本県',
'大分県' => '大分県',
'宮崎県' => '宮崎県',
'鹿児島県' => '鹿児島県',
'沖縄県' => '沖縄県',
];

