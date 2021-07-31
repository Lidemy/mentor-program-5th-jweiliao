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

	if(empty($_POST['id']) || empty($_POST['title']) || empty($_POST['content'])) {
		header("Location:" . $PAGE);
		die("資料不齊全");
	}
	
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = "UPDATE wei_blog_info SET title = ?, content = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssi', $title, $content, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: about_me.php");
?>