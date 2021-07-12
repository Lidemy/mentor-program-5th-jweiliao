<?php
  require_once("conn.php");
  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  if(empty($_GET['id'])) {
    $json = array(
      "message" => "fail"
    );
    $response = json_encode($json);
    echo $response;
    die();
  }
  $id = $_GET['id'];

  $sql = "SELECT * FROM wei_todo_list WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
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
  $todo_list = array();
  while($row = $result->fetch_assoc()) {
    array_push($todo_list, array(
      "content" => $row['content']
    ));
  }

  $json = array(
    "message" => "success",
    "content" => $todo_list
  );

  $response = json_encode($json);
  echo $response;
?>