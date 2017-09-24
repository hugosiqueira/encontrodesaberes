<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	
	$json = $_POST['curso'];
	$dados = json_decode($json);

	$id_curso			= $dados->id_curso;
	
	$query = sprintf("
		DELETE FROM es_ufop_cursos WHERE id_curso = %d",
		mysqli_real_escape_string($mysqli, $id_curso)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>