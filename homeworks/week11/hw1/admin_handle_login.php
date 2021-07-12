<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  if(empty($_POST['username']) || empty($_POST['password'])) {
    header("Location: admin_login.php?errCode=1");
    die();
  }

  $username = $_POST['username'];
  $password = $_POST['password'];
  // 帶出使用者資訊
  $sql = "SELECT * FROM wei_users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();

  if (!$result) {
    die($conn->error);
  }
  
  $result = $stmt->get_result();  
  
  if($result->num_rows === 0) {
    header("Location:  admin_login.php?errCode=2");
    exit();
  } 

  $row = $result->fetch_assoc();
  echo $row['user_group_id'];
  // 登入成功代表拿到資料
  if(password_verify($password, $row['password'])) {
    $_SESSION['username'] = $username;
    header("Location: admin_board.php");
  } else {
    header("Location: admin_login.php?errCode=2");
  }
?>