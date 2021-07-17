<?php
  require_once("conn.php");
  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  if(empty($_GET['site_key'])) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $site_key = $_GET['site_key'];

  if (!empty($_GET['cursor'])) {
    $cursor = $_GET['cursor'];
  }
  
  if (!empty($_GET['cursor'])) {
    $sql = "SELECT * FROM wei_discussion WHERE (site_key = ? AND id < ?) ORDER BY id DESC LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $site_key, $cursor);
  } else {
    $sql = "SELECT * FROM wei_discussion WHERE site_key = ? ORDER BY id DESC LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $site_key);
  };
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
      "id" => $row['id'],
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
  echo "$response";
?>