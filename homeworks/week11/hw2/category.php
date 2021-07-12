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

  $sql = "SELECT
  C.id AS id, C.category_name AS category_name
  FROM wei_blog_category AS C
  ORDER BY C.id ASC";

  $stmt = $conn->prepare($sql);
  // $stmt->bind_param("ii", $item_per_pages, $offset);
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
  <?php include_once("header.php") ?>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="container">
      <form action="handle_create_category.php" method="POST">
      <?php
        if(!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $msg = "Error";
          if($code === "1") {
            $msg = "請輸入分類名稱";
          }
          echo '<h2 class="err">' . $msg . '</h2>';
        }  
      ?>
        <h3>新增分類</h3>
        <input type="text" name="category_name" value="" placeholder="請輸入分類名稱">
        <input type="submit" value="提交">
      </form>
      <div class="admin-posts">
        <?php
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="admin-post">
          <div class="admin-post__title"><?php echo escape($row['category_name']); ?></div>
          <div class="admin-post__info">
            <a class="admin-post__btn" href="update_category.php?id=<?php echo $row['id']; ?>">編輯</a>
            <a class="admin-post__btn" href="delete_category.php?id=<?php echo $row['id']; ?>">刪除</a>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>