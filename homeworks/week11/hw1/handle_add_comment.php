<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  if(empty($_POST['content'])) {
    header("Location: index.php?errCode=1");
    die("資料不齊全");
  }

  $username = $_SESSION['username'];
  $content = $_POST['content'];

  $sql = "SELECT user_group_id FROM `wei_users` WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $user_group_id = $row['user_group_id'];

  if($user_group_id === 4) {
    echo "您沒有操作權限";
    exit;
  }

  $sql = "INSERT INTO wei_comments(username, content) VALUES(?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $content);
  $result = $stmt->execute();

  if(!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>