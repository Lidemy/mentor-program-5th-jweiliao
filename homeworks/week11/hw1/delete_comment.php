<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if(empty($_GET['id'])) {
    header("Location: update_comment?errorCode=1?");
    die("資料不齊全");
  }
  
  $username = $_SESSION['username'];
  $id = $_GET['id'];

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

  if($user_group_id === 1) {
    $sql = "UPDATE wei_comments SET is_deleted = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
  } else {
    $sql = "UPDATE wei_comments SET is_deleted = 1 WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $id, $username);
  }

  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>