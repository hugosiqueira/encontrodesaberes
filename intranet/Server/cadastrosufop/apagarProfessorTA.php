<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_professor = $_REQUEST['id_professor'];
	
	$query = sprintf("
		DELETE FROM es_ufop_professores WHERE id_professor = %d",
		mysqli_real_escape_string($mysqli, $id_professor)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>