<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	
	$json = $_POST['areaespecifica'];
	$dados = json_decode($json);

	$id			= $dados->id;
	
	$query = sprintf("
		DELETE FROM es_area_especifica WHERE id = %d",
		mysqli_real_escape_string($mysqli, $id)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>