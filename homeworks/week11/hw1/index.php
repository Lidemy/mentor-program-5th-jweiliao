<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  
  $username = NULL;
  $user = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }
  
  $page = 1;
  if(!empty($_GET['page'])) {
    $page = (int)$_GET['page'];
  }
  $item_per_pages = 5;
  $offset = ($page - 1) * $item_per_pages;

  $sql = "SELECT
  C.id AS id, C.content AS content,
  C.created_at AS created_at, U.nickname AS nickname, U.username AS username,
  U.user_group_id
  FROM wei_comments AS C
  LEFT JOIN wei_users AS U ON C.username = U.username
  WHERE C.is_deleted IS NULL
  ORDER BY C.id DESC
  LIMIT ? OFFSET ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $item_per_pages, $offset);
  $result = $stmt->execute();

  if(!$result) {
    die("Error: " . $conn->error);
  }
  $result = $stmt->get_result();

  $user_group_id = isset($user['user_group_id']) ? (int)$user['user_group_id'] : 0;
  $enable_add = isset($user['enable_add']) ? (int)$user['enable_add'] : 0;
  $enable_edit = isset($user['enable_edit']) ? (int)$user['enable_edit'] : 0;
  $enable_delete = isset($user['enable_delete']) ? (int)$user['enable_delete'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>留言板</title>
  <link rel="stylesheet" href="style.css">
  <script src="//cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
</head>

<body>
  <header class="warning">
    <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class="board">
    <?php if(!$username) { ?>
      <div>
        <a class="board__btn" href="register.php">註冊</a>
        <a class="board__btn status__btn" href="login.php">登入</a>
      </div>
    <?php } else { ?>
      <a class="board__btn logout__btn" href="logout.php">登出</a>
      <h3><strong><?php echo escape($user['nickname']); ?></strong> 您好！</h3>
      <form class="board__new-comment-form" method="POST" action="update_nickname.php">
      <div class="board__filed">
          <input type="text" name="nickname" />
          <label>修改暱稱</label>
          <input class="board__submit-btn submit__btn" type="submit" />
        </div>
      </form>
    <?php } ?>
      </div>
      <h1 class="board__title">Comments</h1>
        <?php
          if(!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = "Error";
            if($code === "1") {
              $msg = "請確認資料是否填妥";
            }
            echo '<h2 class="error">' . $msg . '</h2>';
          }  
        ?>
        <form class="board__new-comment-form" method="POST" action="handle_add_comment.php">
          <textarea name="content" rows="5" id="CKEditor_4"></textarea>
          <script>
            CKEDITOR.replace('CKEditor_4', {
              on: {
                instanceReady: function(ev) {
                  // Output paragraphs as <p>Text</p>.
                  this.dataProcessor.writer.setRules( 'p', {
                      indent: false,
                      breakBeforeOpen: false,
                      breakAfterOpen: false,
                      breakBeforeClose: false,
                      breakAfterClose: false
                  });
                }
              },
              // Remove the redundant buttons from toolbar groups defined above.
              removeButtons: 'Source,Save,NewPage,DocProps,document,Templates,Scayt,Subscript,Superscript,RemoveFormat,Preview,PasteFromWord,Form,Checkbox,Radio,Flash,Textarea,Button,Table,Image,ShowBlocks,Format',
              allowedContent: 'h1 h2 h3 p blockquote strong em;' +
              'a[!href];' +
              'img(left,right)[!src,alt,width,height];' +
              'table tr th td caption;' +
              'span{!font-family};' +
              'span{!color};' +
              'span(!marker);' +
              'del ins'
            });
          </script>
          <?php if($username) { ?>
            <?php if($user_group_id === 4 || !$user['enable_add']) { ?>
              <h3>您已被停權</h3>
              <?php } else { ?>
              <input class="board__submit-btn submit__btn" type="submit" />
            <?php } ?>
          <?php } else { ?>
            <h3>請登入發布留言</h3>
          <?php } ?>
        </form>
      <div class="board__hr"></div>
      <section>
        <?php
          while($row = $result->fetch_assoc()) {
            $date = new DateTime($row['created_at']);
        ?>
        <div class="card">
          <div class="card__avatar"></div>
          <div class="card__body">
              <div class="card__info">
                <span class="card__author">
                  <?php echo escape($row['nickname']) ?>
                  @(<?php echo escape($row['username']) ?>)
                </span>
                <span class="card__time">
                  <?php echo $date->format('Y/m/d H:i:s A'); ?>
                </span>
                <?php if($user_group_id === 1 && $enable_edit && $enable_delete) { ?>
                  <a href="update_comment.php?id=<?php echo $row['id'] ?>">編輯</a>
                  <a href="delete_comment.php?id=<?php echo $row['id'] ?>">刪除</a>
                <?php } else if($row['username'] === $username) { ?>
                  <?php if($enable_edit === 1) { ?>
                    <a href="update_comment.php?id=<?php echo $row['id'] ?>">編輯</a>
                  <?php } ?>  
                  <?php if($enable_delete === 1) { ?>
                    <a href="delete_comment.php?id=<?php echo $row['id'] ?>">刪除</a>
                  <?php } ?>
                <?php } ?>
              </div>
              <p class="card__content"><?php echo $row['content'] ?></p>
          </div>
        </div>
        <?php 
        }
          mysqli_free_result($result);
        ?>
      </section>
      <?php
        $stmt = $conn->prepare(
          'SELECT count(id) as count from wei_comments where is_deleted IS NULL'
        );
        $result = $stmt->execute();
        if(!$result) {
          die("Error: " . $conn->error);
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $total_page = (int)ceil($count / $item_per_pages);
      ?>
      <?php if($total_page && $page <= $total_page) { ?>
      <div>
        <span>總共有 <?php echo $count ?> 筆</span>
        <span>第 <?php echo $page ?> / <?php echo $total_page ?> 頁</span>
      </div>
      <ul class="pagination">
        <?php if($page !== 1) { ?>
          <li><a href="index.php?page=1">第一頁</a></li>
          <li><a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a></li>
        <?php } ?>
        <?php if($page !== $total_page) { ?>
          <li><a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a></li>
          <li><a href="index.php?page=<?php echo $total_page ?>">最末頁</a></li>
        <?php } ?> 
      </ul>
      <?php } ?>
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