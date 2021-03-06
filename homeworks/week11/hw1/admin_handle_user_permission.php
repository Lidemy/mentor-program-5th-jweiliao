<?php
	require_once("conn.php");

	if(empty($_GET['user_id']) || empty($_GET['user_permission']) || $_GET['is_enable']) {
		header('Location: board_admin.php?errCode=1');
		die();
	}
	$user_id = $_GET['user_id'];
	$user_id = $_GET['user_permission'];
	$is_enable = $_GET['is_enable'];

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