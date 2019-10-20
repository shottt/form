<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel='stylesheet' href='/dist/css/flocss.css'>
  
</head>
<body class="bg-dark">
  <header>
    <nav class="navbar navbar-expand-lg text-center">
      <a class="navbar-brand text-light" href="#">Navbar</a>

      <button class="navbar-toggler js-display" type="button" data-toggle="collapse" data-tarPOST="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
    
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav js-none">
          <li class="nav-item active cp_link">
            <a class="nav-link text-light" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item cp_link">
            <a class="nav-link text-light" href="#">Link</a>
          </li>
          <li class="nav-item dropdown cp_link">
            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main class="py-5" style='background:  url("/dist/images/form.jpg") no-repeat; background-size: cover;'>

    <section >
      <div class="conainer">
        <h1 class="text-center text-light">お問い合わせフォーム</h1>
      </div>
    </section>
    <div class="container" id="vue-form">
      <form action="" class="w-50 mx-auto" method="POST" enctype='multipart/form-data'>
        <div class="form-group">
          <label class="text-light" for="mail">Eメールアドレス</label>
          <input name="email" type="text" class="form-control" id="mail" placeholder="Eメールアドレス"　required v-model="email">
          <input name="email_re" type="text" class="form-control mt-2" id="mailCheck" placeholder="確認のためもう一度Eメールアドレスの入力をお願いします。" required v-model="emailCheck">
          <small class="text-light">あなたのメールは他の誰とも共有しません。</small>
          <p class="text-danger">{{ error_Message }} </p>
        </div>
        <div class="form-group">
          <label class="text-light" for="detail">問い合わせ内容</label>
          <p class="text-danger">{{ error_message2 }} </p>
          <textarea name="detail" v-on:keyup="key_up__textarea" v-model="detail_message" name="detail" id="detail" cols="30" class="w-100 text-dark" required placeholder="問い合わせ内容を記入してください"></textarea>
        </div>
        <div class="form-grop py-4">
          <input type="file" name="data_file" value="data_file">
        </div>

        <input type="hidden" name="csrfToken" value="<?php echo htmlspecialchars($csrfToken); ?>">

        <button :disabled="buttonFlag" type="submit" class="btn btn-primary">送信する</button>
      </form>
    </div>
  </main>
  <div><?php echo $_POST["detail"];?></div>
  <script src='/dist/js/jquery-3.3.1.slim.min.js'></script>
  <script src="/dist/js/bundle.js"></script>

</body>
</html>