<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  if(empty($_POST['username']) || empty($_POST['password'])) {
    header("Location: login.php?errCode=1");
    die();
  }

  $username = $_POST['username'];
  $password = $_POST['password'];
  // 帶出使用者資訊
  $sql = (sprintf("SELECT username, password FROM wei_users WHERE username = '%s' AND password = '%s'",
    $username, $password
  ));

  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }

  // 登入成功代表拿到資料
  if($result->num_rows) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
  } else {
    header("Location: login.php?errCode=2");
  }
?>