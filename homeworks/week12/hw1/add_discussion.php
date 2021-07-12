<?php
  require_once("conn.php");
  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  if(empty($_POST['nickname']) || empty($_POST['content']) || empty($_POST['site_key'])) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }
  $nickname = $_POST['nickname'];
  $content = $_POST['content'];
  $site_key = $_POST['site_key'];
  $sql = "INSERT INTO wei_discussion(site_key, nickname, content) VALUES(?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $site_key, $nickname, $content);
  $result = $stmt->execute();

  if (!$result) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }
  
  $sql = "SELECT * FROM wei_discussion WHERE site_key = ? ORDER BY id DESC LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $site_key);
  $result = $stmt->execute();

  if (!$result) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $result = $stmt->get_result();
  $discussion = array();
  while($row = $result->fetch_assoc()) {
    array_push($discussion, array(
      "nickname" => $row['nickname'],
      "content" => $row['content'],
      "created_at" => $row['created_at']
    ));
  }

  $json = array(
    "message" => "success",
    "discussion" => $discussion
  );

  $response = json_encode($json);
  echo $response;
?>