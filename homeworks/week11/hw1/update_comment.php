<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  
  $id = $_GET['id'];
  $username = NULL;
  $user = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  $sql = "SELECT * FROM wei_comments WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();

  if(!$result) {
    die("Error: " . $conn->error);
  }

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $user_group_id = isset($user['user_group_id']) ? (int)$user['user_group_id'] : 0;
  $enable_edit = isset($user['enable_edit']) ? (int)$user['enable_edit'] : 0;
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
      <h1 class="board__title">編輯留言</h1>
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
        <form class="board__new-comment-form" method="POST" action="handle_update_comment.php">
          <textarea name="content" rows="5" id="CKEditor_4"><?php echo escape($row['content']) ?></textarea>

          <?php if($username) { ?>
            <?php if(!$user['enable_edit']) { ?>
              <h3>您已被停權</h3>
              <?php } else { ?>
              <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
              <input class="board__submit-btn submit__btn" type="submit" />
            <?php } ?>
          <?php } else { ?>
            <h3>請登入發布留言</h3>
          <?php } ?>
        </form>
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
  </main>
</body>
</html>