<?php 

//変数汚染攻撃
//$aa = ini_get('register_globals');
//echo 'register_globals = ' . ini_get('register_globals') . "\n";
var_dump(ini_get_all());

//nullバイト攻撃
/*
$file = $_GET['file']; // ここで "../../etc/passwd\0" が渡されたとします
$test = './dist/form/'.$file;//.'.php';
if (file_exists($file)) {
   
    // file_exists は true を返します。これは、ファイル /home/wwwrun/../../etc/passwd が存在するからです
    include './dist/form/'.$file.'.php';
    // ファイル /etc/passwd がインクルードされてしまいます
}*/

/*
if (substr($_GET["data_file"], -3) === "txt") {
  $rs = basename($_GET["data_file"]);
  readfile($rs);
  exit;
}*/

/*
$redirect_uri = $_GET["redirect_uri"];
if (!preg_match('[[:ctrl:]]', $redirect_uri)) {
  header('Location:'.$_GET['redirect_uri']);
  exit;
}*?

`
localhost:8888/attack.php?redirect_uri=%00%0d%0aSet-Cookie:%20PHPSESSID=ASYOULIKE;max-age=100000;path=/
`
?>