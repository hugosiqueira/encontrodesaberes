<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_evento = $_POST['id_evento'];

	$query = sprintf("
		UPDATE es_evento 
		SET bool_logo = 1
		WHERE id = %d",
		mysqli_real_escape_string($mysqli,$id_evento)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0 
	));
?>