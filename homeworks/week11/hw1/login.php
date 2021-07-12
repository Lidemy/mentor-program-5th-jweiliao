<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>留言板</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header class="warning">
    <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class="board">
      <div>
        <a class="board__btn" href="index.php">回留言板</a>
        <a class="board__btn status__btn" href="register.php">註冊</a>
      </div>
      <h1 class="board__title">Login</h1>
      <?php
        if(!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $msg = "Error";
          if($code === "1") {
            $msg = "請確認資料是否填妥";
          } else if($code === "2") {
            $msg = "帳號或密碼輸入錯誤";
          }
          echo '<h2 class="err">錯誤: ' . $msg . '</h2>';
        }
      ?>
      <form class="board__new-comment-form" method="POST" action="handle_login.php">
        <div class="board__filed">
          <input type="text" name="username" />
          <label>帳號：</label>
        </div>
        <div class="board__filed">
          <input type="password" name="password" />
          <label>密碼：</label>
        </div>
        <input class="board__submit-btn submit__btn" type="submit" />
      </form>
  </main>
</body>
  <script>
    let form = document.querySelector('.board__new-comment-form');
    form.addEventListener('input', (e) => {
      if(e.target.value !== '') {
        e.target.classList.add('animate_label')
      } else {
        e.target.classList.remove('animate_label')
      }
    });
  </script>
</html>