<?php
 // PHPにエラーコードを公開しない

ini_set('display_errors', 'Off');
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

// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える（セッションハイジャック対策）
session_regenerate_id();
//global $csrfToken;

//Nullバイト攻撃 →検出したら、後続処理停止
//スクリプトインジェクション→エスケープ系の関数で処理
//ディレクトリートラバーサル→basename() （編集済み）

$csrfToken;

if (empty($_POST)) {
  //安全安心なトークンを作成(32桁数)
  $TOKEN_LENGTH = 16;
  $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
  //global $csrfToken;
  $csrfToken = bin2hex($tokenByte);
  //セッションにtokenを設定
  $_SESSION['csrfToken'] = $csrfToken;
}

if (!empty($_POST)) {

  //Nullバイト攻撃対策
  preg_match("/¥0/", $_POST['csrfToken'], $result);
  if ($result === 1 ) return; 
  //スクリプトインジェクション対策
  $csrfToken = htmlspecialchars($_POST['csrfToken'], ENT_QUOTES);

  // postされたtokenがセッションに保存された値と同じか確認
  if((isset($_SESSION['csrfToken'])) &&  $csrfToken === $_SESSION['csrfToken']){

    //Nullバイト攻撃対策
    preg_match("/¥0/", $_POST["email"], $result);
    if ($result === 1 ) return; 
    preg_match("/¥0/", $_POST["detail"], $result);
    if ($result === 1 ) return; 

    //スクリプトインジェクション対策
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES);

    //画像判定
    if (! empty($_FILES['userfile']['tmp_name'])) {
      //イメージ判定
      if (getimagesize($_FILES["data_file"]['tmp_name']) === false ) return;//中身が画像ならarray,ではないならfalse※拡張子は関係ない
      //拡張子判定
      if (basename($_FILES["data_file"]["type"]) !== "jpeg") return;
      
      $dir = dirname(__FILE__);
      $fpt = '/dist/images'.$_FILES['userfile']['tmp_name'];
      move_uploaded_file(
        $_FILES['userfile']['tmp_name'], 
        dirname(__FILE__).'/dist/images/'.$_FILES['userfile']['name']);
    
    }
    //全部OKでcsrfTokenを作り直す
    
    //安全安心なトークンを作成(32桁数)
    $TOKEN_LENGTH = 16;
    $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    //global $csrfToken;
    $csrfToken = bin2hex($tokenByte);
    //セッションにtokenを設定
    $_SESSION['csrfToken'] = $csrfToken;

    $_SESSION["sent"] = true;
  // バリデーション処理
   // DB接続処理（ここにプリペアードステートメントを入れることでSQLインジェクション対策になる？）
   //なります。仲林
   //require('./form.php');
   //exit;

  } else{
    // 不正な処理
    echo '不正なリクエストです';
  }
}

if (!empty($_POST)) {

  $TOKEN_LENGTH = 16;
  $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
  //global $csrfToken;
  $csrfToken = bin2hex($tokenByte);
  //セッションにtokenを設定
  $_SESSION['csrfToken'] = $csrfToken;

}
require('./form.php');
exit;

