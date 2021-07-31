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
  
  $id = $_GET['id'];
  $sql = "SELECT
  A.id AS id, A.title AS title, A.content AS content,
  A.created_at AS created_at, U.username AS username,
  C.category_name
  FROM wei_blog_article AS A
  LEFT JOIN wei_users AS U ON A.username = U.username
  LEFT JOIN wei_blog_category AS C ON A.category_id = C.id
  WHERE A.is_deleted IS NULL AND A.id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();

  if(!$result) {
    die("Error: " . $conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
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
      <article class="post">
      <?php if($result->num_rows) { ?>
        <div class="post__header">
          <div class="post__title"><?php echo escape($row['title']); ?></div>
          <?php if($username) { ?>
          <div class="post__actions">
            <a class="post__action" href="update_article.php?id=<?php echo $row['id']; ?>">編輯</a>
          </div>
          <?php } ?>
        </div>
        <div class="post__info"><?php echo $row['created_at']; ?></div>
        <div class="post__content"><?php echo escape($row['content']); ?></div>
      <?php } else { ?>
        <div class="admin-post">文章不存在</div>
      <?php } ?>
      </article>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>