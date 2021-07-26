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
    header("Location: login.php");
    exit;
  }

  $id = $_GET['id'];
  $sql = "SELECT
  C.id AS id, C.category_name AS category_name
  FROM wei_blog_category AS C
  WHERE id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
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
  <link rel="stylesheet" href="style.css" />
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
        <form action="handle_update_category.php" method="POST">
          <div class="edit-post__title">
            更改分類名稱：
          </div>
          <?php if($result->num_rows) { ?>
            <?php 
              while($row = $result->fetch_assoc()) {
            ?>
            <div class="edit-post__input-wrapper">
              <input class="edit-post__input" placeholder="請輸入文章標題" name="category_name" value="<?php echo escape($row['category_name']); ?>" />
            </div>
            <div class="edit-post__btn-wrapper">
              <input type="hidden" name="id" value="<?php echo escape($row['id']); ?>">
              <input type="hidden" name="PAGE" value="<?php $_SERVER['HTTP_REFERER']; ?>">
              <input type="submit" class="edit-post__btn" value="送出">
            </div>
            <?php } ?>
          <?php } else { ?>
            <div class="admin-post">文章不存在</div>  
          <?php } ?>  
        </form>
      </div>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>