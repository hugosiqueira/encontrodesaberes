<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_aluno = $_REQUEST['id_aluno'];
	
	$query = sprintf("
		DELETE FROM es_ufop_alunos WHERE id_aluno = %d",
		mysqli_real_escape_string($mysqli, $id_aluno)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>