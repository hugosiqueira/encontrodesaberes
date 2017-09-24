<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	
	$json = $_POST['area'];
	$dados = json_decode($json);

	$id_area	= $dados->id_area;
	
	$query = sprintf("
		DELETE FROM es_ufop_areas WHERE id_area = %d",
		mysqli_real_escape_string($mysqli, $id_area)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>