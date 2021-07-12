<?php
  session_start();
  require_once("conn.php");

  if(empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errCode=1');
    die();
  }

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $user_group_id = 3;

  //將使用者資訊寫入資料表
  $sql = "INSERT INTO wei_users(nickname, username, password, user_group_id) VALUES(?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi", $nickname, $username, $password, $user_group_id);
  $result = $stmt->execute();

  if(!$result) {
    $code = $conn->errno;
    if($code === 1062) {
      header("Location:  register.php?errCode=2");
    }
    die($code);
  }

  // 指定登入完成後的狀態
  $_SESSION['username'] = $username;
  header("Location: index.php");
?>