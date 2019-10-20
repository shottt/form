<?php 

//HTTPリスポンス
//http://localhost:8888/dist/form/index.php/%0d%0aSet-Cookie:%20PHPSESSID=ASYOULIKE;max-age=10000000;path=/?dopost=1
//header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
//echo "<pre>";
//外部コマンド攻撃

/*
$value = $_GET['dir'];
echo "ls -al".str_replace('..', '', ' ./'.$_GET['dir']);
system("ls -al".str_replace('..', '', ' ./'.$_GET['dir']));
*/
//http://localhost:8888/attack.php?dir=| cat /etc/passwd
//http://localhost:8888/attack.php?dir=\00../../

//外部コマンド攻撃2
/*
echo "ls -al ".strtr($_GET['dir'], array('..'=>'', '|'=> ''));//→中身は見られない
echo "<pre>";
system("ls -al ".strtr($_GET['dir'], array('..'=>'', '|'=> '')));

echo "ls -al ".escapeshellarg(str_replace("..", ",", "./".$_GET['dir']));
system("ls -al ".escapeshellarg(str_replace("..", ",", "./".$_GET['dir'])));
*/
/*

if (empty($_GET)) {
  return;
}

//ホワイトリスト法
//まずフォルダ名だけとる
$dir = basename($_GET['dir']);

//①ファイルのうむ判定
if (!is_dir($dir)) exit;

//②ファイルを限定
$array = array("folder1", "folder2", "folder3");

if (!in_array($dir, $array))  exit; 


echo 'ls -al '.$dir;
system('ls -al '.$dir);

*/

//インクルード攻撃　ファイルを読み込ませる
/*
$aa = basename($_GET["skin_file"]);
var_dump($aa);

include $aa;*/
//変数汚染攻撃
//var_dump(ini_get_all());
/*
//php.iniでregister_globals = Offが前提→PHP5.4からなくなった

$aa = ini_get('register_globals');
var_dump($aa);
*/
/*
//http://localhost:8888/attack.php?my_root=http://localhost:8001/index.php
$my_root = $_GET["my_root"];
include $my_root;
//exit;
*/
//nullバイト攻撃
/*
$file = basename($_GET['file']); // ここで "../../etc/passwd\0" が渡されたとします
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
}*/


//localhost:8888/attack.php?redirect_uri=%00%0d%0aSet-Cookie:%20PHPSESSID=ASYOULIKE;max-age=100000;path=/

?>