<?php
  session_start();
  require_once("conn.php");

  if(empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errCode=1');
    die();
  }

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  //將使用者資訊寫入資料表
  $sql = sprintf("INSERT INTO wei_users(nickname, username, password) values('%s', '%s', '%s')",
  $nickname, $username, $password);
  $result = $conn->query($sql);

  if(!$result) {
    $code = $conn->errno;
    if($code === 1062) {
      header("Location:  register.php?errCode=2");
    }
    die($code);
  }

  $_SESSION['username'] = $username;
  header("Location: index.php");
?>