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
  }

  $sql = "SELECT * FROM wei_blog_category AS C ORDER BY C.id ASC";

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
  <link rel="stylesheet" href="main.css" />
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
      <div class="admin-posts">
      <?php if($result->num_rows) { ?>
        <?php
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="admin-post">
          <a href="category_list_area.php?category_id=<?php echo $row['id'] ?>"><div class="admin-post__title"><?php echo escape($row['category_name']); ?></div></a>
        </div>
        <?php }
          mysqli_free_result($result);
        } else { ?>
        <div class="admin-post">暫無分類</div>
      <?php } ?>
      </div>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>