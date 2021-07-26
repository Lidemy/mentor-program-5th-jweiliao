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

  if(empty($_POST['title']) || empty($_POST['content'] || empty($_POST['category_id']))) {
    header("Location: create_article.php?errCode=1");
    die("資料不齊全");
  }

  $username = $_SESSION['username'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $category_id = $_POST['category_id'];
  $publish = 0;
  $sql = "INSERT INTO wei_blog_article(username, title, content, category_id, publish) VALUES(?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssii", $username, $title, $content, $category_id, $publish);
  $result = $stmt->execute();

  if(!$result) {
    die($conn->error);
  }

  header("Location: admin.php");
?>