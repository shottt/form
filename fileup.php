<?php 

//ファイルアップロード攻撃
//拡張子無視してアップロードできる・
//ホワイトリスト法でhthmlに限定しても<script>
if (! empty($_FILES['userfile']['tmp_name'])) {

  $dir = dirname(__FILE__);
  $fpt = '/dist/images'.$_FILES['userfile']['tmp_name'];
  move_uploaded_file(
    $_FILES['userfile']['tmp_name'], 
    dirname(__FILE__).'/dist/images/'.$_FILES['userfile']['name']);

  header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <form action='' method='POST' enctype='multipart/form-data'>
    <input type='file' name='userfile'/>
    <input type='submit' value='upload'/>
  </form>
</body>
</html>
