<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	
	$json = $_POST['departamento'];
	$dados = json_decode($json);

	$id_departamento			= $dados->id_departamento;
	
	$query = sprintf("
		DELETE FROM es_ufop_departamentos WHERE id_departamento = '%s'",
		mysqli_real_escape_string($mysqli, $id_departamento)
	);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>