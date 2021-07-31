<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $username = NULL;
  $user = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // $user = getUserFromUsername($username);
  } else {
    header("Location: index.php");
    exit;
  }

  $sql = "SELECT * FROM wei_blog_category";

  $stmt = $conn->prepare($sql);
  // $stmt->bind_param("i", $id);
  $result = $stmt->execute();

  if(!$result) {
    die("Error: " . $conn->error);
  }
  $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>部落格</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="normalize.css" />
  <link rel="stylesheet" href="main.css" />
</head>

<body>
  <?php include_once("header.php"); ?>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="container">
      <div class="edit-post">
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
        <form action="handle_create_article.php" method="POST">
          <div class="edit-post__title">
            發表文章：
          </div>
          文章分類
          <select name="category_id">
            <?php while($row = $result->fetch_assoc()) { ?>
              <option value="<?php echo $row['id'] ?>"><?php echo escape($row['category_name']); ?></option>
            <?php } ?>
          </select>
          <div class="edit-post__input-wrapper">
            <input class="edit-post__input" placeholder="請輸入文章標題" name="title" />
          </div>
          <div class="edit-post__input-wrapper">
            <textarea rows="20" class="edit-post__content" name="content"></textarea>
          </div>
          <div class="edit-post__btn-wrapper">
              <input type="submit" class="edit-post__btn" value="送出">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>