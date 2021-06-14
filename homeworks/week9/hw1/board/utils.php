<?php
  require_once("conn.php");

  function generateToken() {
    $token = "";
    for ($i = 0; $i <= 16; $i++) {
      $token .= chr(rand(65, 90));
    }
    return $token;
  }

  function getUserFromUsername($username) {
    GLOBAL $conn;

    $sql = sprintf("SELECT * FROM wei_users WHERE username = '%s'", $username);
    $result = $conn->query($sql);
    if(!$result) {
      die("Error: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return $row;
  }
?>