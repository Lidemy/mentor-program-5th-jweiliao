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
  
  if(empty($_GET['category_id'])) {
    header("Location: category_list.php");
    exit;
  }
  $category_id = $_GET['category_id'];

  $page = 1;
  if(!empty($_GET['page'])) {
    $page = (int)$_GET['page'];
  }
  $item_per_pages = 5;
  $offset = ($page - 1) * $item_per_pages;

  $sql = "SELECT
  A.id AS id, A.title AS title, A.content AS content,
  A.created_at AS created_at, U.username AS username,
  C.category_name
  FROM wei_blog_article AS A
  LEFT JOIN wei_users AS U ON A.username = U.username
  LEFT JOIN wei_blog_category AS C ON A.category_id = C.id
  WHERE A.is_deleted IS NULL AND A.category_id = $category_id
  ORDER BY A.id DESC
  LIMIT ? OFFSET ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $item_per_pages, $offset);
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
        </div>
        <div>文章分類: <?php echo $row['category_name']; ?></div>
        <div class="post__info">
        <?php echo $row['created_at']; ?>
        </div>
        <div class="post__content"><?php echo string_interception($row_content, 300); ?></div>
        <a class="btn-read-more" href="article.php?id=<?php echo $row['id']; ?>">READ MORE</a>
      </article>
      <?php } ?>
    <?php } else { ?>
      <div class="admin-post">暫無文章</div>
    <?php } mysqli_free_result($result); ?>
    <?php
        $sql = "SELECT count(id) as count, category_id FROM wei_blog_article WHERE is_deleted IS NULL AND category_id =" . $category_id;
        $stmt = $conn->prepare($sql);
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
          <li><a href="category_list_area.php?category_id=<?php echo $category_id; ?>&page=1">第一頁</a></li>
          <li><a href="category_list_area.php?category_id=<?php echo $category_id; ?>&page=<?php echo $page - 1 ?>">上一頁</a></li>
        <?php } ?>
        <?php if($page !== $total_page) { ?>
          <li><a href="category_list_area.php?category_id=<?php echo $category_id; ?>&page=<?php echo $page + 1 ?>">下一頁</a></li>
          <li><a href="category_list_area.php?category_id=<?php echo $category_id; ?>&page=<?php echo $total_page ?>">最末頁</a></li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
  </div>
  <?php include_once("footer.php"); ?>
</body>
</html>