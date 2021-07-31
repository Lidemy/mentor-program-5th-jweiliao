<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $username = NULL;
  $user = NULL;
  
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  $user_group_id = isset($user['user_group_id']) ? (int)$user['user_group_id'] : 0;
  if($user_group_id === 0 || $user_group_id > 3) {
    echo "您沒有權限操作";
    exit;
  }

  if(empty($_GET['user_group_id']) || empty($_GET['user_id'])) {
    header('Location: board_admin.php?errCode=1');
    die();
  }
  $user_id = $_GET['user_id'];
  $user_group_id = $_GET['user_group_id'];
  

  $sql = "UPDATE `wei_users` SET `user_group_id` = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $user_group_id, $user_id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $json = array(
    "message" => "success",
    "user_id" => $user_id
  );

  $response = json_encode($json);
  header('Content-Type: application/json; charset=utf-8');
  echo $response;
?>