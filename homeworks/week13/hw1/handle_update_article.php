<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

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

  $PAGE = $_POST['PAGE'];

	if(empty($_POST['id']) || empty($_POST['title']) || empty($_POST['content']) || empty($_POST['category_id'])) {
		header("Location:" . $PAGE);
		die("資料不齊全");
	}
	
  $username = $_SESSION['username'];
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $category_id = $_POST['category_id'];

  $sql = "UPDATE wei_blog_article SET title = ?, content = ?, category_id = ? WHERE id = ? AND username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssiis', $title, $content, $category_id, $id, $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>