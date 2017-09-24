<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['grupo'];

	$dados = json_decode($json);

	$id_grupo 			= $dados->id_grupo;
	$grupo 				= utf8_decode($dados->grupo);
	$descricao_grupo 	= utf8_decode($dados->descricao_grupo);
	
	$query = sprintf("
		UPDATE desk_grupos 
		SET grupo 			= '%s',
			descricao_grupo = '%s'
		WHERE id_grupo = %d",
			mysqli_real_escape_string($mysqli,$grupo),	
			mysqli_real_escape_string($mysqli,$descricao_grupo),
			mysqli_real_escape_string($mysqli,$id_grupo)		
		);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_grupo" => $id_grupo,
			"grupo" => $grupo,
			"descricao_grupo" => $descricao_grupo
		)
	));
?>