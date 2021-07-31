<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $username = NULL;
  $user = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }
  
  $sql = "SELECT
  A.id AS id, A.title AS title, A.content AS content,
  A.created_at AS created_at, U.username AS username,
  C.category_name
  FROM wei_blog_article AS A
  LEFT JOIN wei_users AS U ON A.username = U.username
  LEFT JOIN wei_blog_category AS C ON A.category_id = C.id
  WHERE A.is_deleted IS NULL
  ORDER BY A.id DESC
  LIMIT 5";

  $stmt = $conn->prepare($sql);
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
    <div class="posts">
    <?php if($result->num_rows) { ?>
      <?php 
        while($row = $result->fetch_assoc()) {
          $title =  escape($row['title']);
          $row_content = escape($row['content']);
      ?>
      <article class="post">
        <div class="post__header">
          <div><?php echo string_interception($title, 100); ?></div>
          <?php if($username) { ?>
          <div class="post__actions">
            <a class="post__action" href="update_article.php?id=<?php echo $row['id']; ?>">編輯</a>
          </div>
          <?php } ?>
        </div>
        <div>文章分類: <?php echo $row['category_name']; ?></div>
        <div class="post__info">
        <?php echo $row['created_at']; ?>
        </div>
        <div class="post__content"><?php echo string_interception($row_content, 300); ?></div>
        <a class="btn-read-more" href="article.php?id=<?php echo $row['id']; ?>">READ MORE</a>
      </article>
      <?php }
          mysqli_free_result($result);
        } else { ?>
        <div class="admin-post">暫無文章</div>
      <?php } ?>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>