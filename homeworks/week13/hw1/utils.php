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

    // $sql = sprintf("SELECT * FROM wei_users WHERE username = '%s'", $username);
    $sql = sprintf("SELECT * FROM wei_users AS U
    LEFT JOIN wei_users_permission AS P ON U.user_group_id = P.user_group_id
    WHERE username = '%s'", $username);
    $result = $conn->query($sql);
    if(!$result) {
      die("Error: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return $row;
  }

  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }

  function string_interception($str, $length) {
    if(mb_strwidth($str, 'utf8') > $length ) {
      return mb_strimwidth($str, 0, $length, '...', 'utf8');
    }
    return $str;
  }
?>