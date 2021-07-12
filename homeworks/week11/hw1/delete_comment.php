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

  $sql = "UPDATE wei_comments SET is_deleted = 1 WHERE id = ? AND username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('is', $id, $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>