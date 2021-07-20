<?php
  require_once("conn.php");
  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  if(empty($_GET['content'])) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }
  $content = $_GET['content'];

  $sql = "INSERT INTO wei_todo_list(content) VALUES(?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $content);
  $result = $stmt->execute();

  if (!$result) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $last_id = $conn->insert_id;
  $sql = "SELECT * FROM wei_todo_list WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $last_id);
  $result = $stmt->execute();
  $result = $stmt->get_result();

  $todo_list = array();
  while($row = $result->fetch_assoc()) {
    array_push($todo_list, array(
      "content" => $row['content']
    ));
  }

  $json = array(
    "message" => "success",
    "content" => $todo_list,
    "id" => $last_id
  );

  $response = json_encode($json);
  echo $response;
?>