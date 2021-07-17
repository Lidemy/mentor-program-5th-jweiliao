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

	if(empty($_POST['id']) || empty($_POST['category_name'])) {
		header("Location:" . $PAGE);
		die("資料不齊全");
	}

  $id = $_POST['id'];
  $category_name = $_POST['category_name'];
  echo $id;
  $sql = "UPDATE wei_blog_category SET category_name = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $category_name, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: category.php");
?>