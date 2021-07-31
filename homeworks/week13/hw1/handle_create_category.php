<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $username = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } else {
    header("Location: login.php");
    exit;
  }

  if(empty($_POST['category_name'])) {
    header("Location: category.php?errCode=1");
    die("資料不齊全");
  }

  $category_name = $_POST['category_name'];
  echo $category_name;
  $sql = "INSERT INTO wei_blog_category(category_name) VALUES(?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $category_name);
  $result = $stmt->execute();

  if(!$result) {
    die($conn->error);
  }

  header("Location: category.php");
?>