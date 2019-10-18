<?php
 // PHPにエラーコードを公開しない

ini_set('display_errors', 'Off');
// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える（セッションハイジャック対策）
session_regenerate_id();
//global $csrfToken;


if (empty($_GET)) {
  //安全安心なトークンを作成(32桁数)
  $TOKEN_LENGTH = 16;
  $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
  //global $csrfToken;
  $csrfToken = bin2hex($tokenByte);
  //セッションにtokenを設定
  $_SESSION['csrfToken'] = $csrfToken;
}
//Axios通信
// 送信ボタンで POST送信されていた場合
if (!empty($_GET)) {
  $csrfToken = $_GET["csrfToken"];
  // postされたtokenがセッションに保存された値と同じか確認
  if((isset($_SESSION['csrfToken'])) &&  $_GET["csrfToken"] === $_SESSION['csrfToken']){

    // 変数にユーザー情報を格納（htmlspecialcharでXSS対策）
    $email = htmlspecialchars($_GET['email'], ENT_QUOTES);
    $detail = htmlspecialchars($_GET['detail'], ENT_QUOTES);


    $_SESSION["sent"] = true;
  // バリデーション処理
   // DB接続処理（ここにプリペアードステートメントを入れることでSQLインジェクション対策になる？）
   //なります。仲林
   //require('./form.php');
   //exit;

  } else{
    // 不正な処理
    echo '不正なリクエストです';
    require('/dist/form/form.php');
    exit;
  }
  
  //JavScriptに返す
  /*
  echo json_encode(array(
    'code' => 111,
    'name' => 'name' 
  ));*/

  
}


//Html　読み込み
require('./form.php');
exit;
