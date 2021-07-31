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
  A.id AS id, A.title AS title, A.content AS content,
  A.created_at AS created_at, U.username AS username
  FROM wei_blog_article AS A
  LEFT JOIN wei_users AS U ON A.username = U.username
  WHERE A.is_deleted IS NULL
  ORDER BY A.id DESC";

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
              $title =  escape($row['title']);
          ?>
          <div class="admin-post">
            <div class="admin-post__title">
            <?php echo string_interception($title, 80); ?>
              </div>
              <div class="admin-post__info">
                <div class="admin-post__created-at">
                <?php echo escape($row['created_at']); ?>
                </div>
                <a class="admin-post__btn" href="update_article.php?id=<?php echo $row['id']; ?>">
                  編輯
                </a>
                <a class="admin-post__btn" href="delete_article.php?id=<?php echo $row['id']; ?>">
                  刪除
                </a>
              </div>
            </div>
          <?php }
            mysqli_free_result($result);
          } else { ?>
          <div class="admin-post">暫無文章</div>
        <?php } ?>  
      </div>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>