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
  A.id AS id, A.title AS title, A.content AS content,
  A.created_at AS created_at, U.username AS username,
  A.category_id
  FROM wei_blog_article AS A
  LEFT JOIN wei_users AS U ON A.username = U.username
  WHERE A.is_deleted IS NULL AND A.id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();

  if(!$result) {
    die("Error: " . $conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $sql_category = "SELECT * FROM wei_blog_category";
  $result_category = $conn->query($sql_category);
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
        <form action="handle_update_article.php" method="POST">
          <div class="edit-post__title">
            編輯文章：
          </div>
          文章分類
          <select name="category_id">
            <?php
              while($row_category = $result_category->fetch_assoc()) {
                echo $row['category_id'];
                $is_selected = ($row['category_id'] == $row_category['id']) ? 'selected' : '';
            ?>
              <option value="<?php echo escape($row_category['id']) ?>" <?php echo $is_selected; ?>><?php echo escape($row_category['category_name']); ?></option>
            <?php } ?>
          </select>
          <?php if($result->num_rows) { ?>
            <div class="edit-post__input-wrapper">
              <input class="edit-post__input" placeholder="請輸入文章標題" name="title" value="<?php echo escape($row['title']); ?>" />
            </div>
            <div class="edit-post__input-wrapper">
              <textarea rows="20" class="edit-post__content" name="content"><?php echo escape($row['content']); ?></textarea>
            </div>
            <div class="edit-post__btn-wrapper">
                <input type="hidden" name="id" value="<?php echo escape($row['id']); ?>">
                <input type="hidden" name="PAGE" value="<?php $_SERVER['HTTP_REFERER']; ?>">
                <input type="submit" class="edit-post__btn" value="送出">
            </div>
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