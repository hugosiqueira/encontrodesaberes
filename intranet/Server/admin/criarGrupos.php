<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['grupo'];
	
	$dados = json_decode($json);
	
	$grupo 				= utf8_decode($dados->grupo);
	$descricao_grupo 	= utf8_decode($dados->descricao_grupo);
	$bool_ativo 		= 0;

	//consulta sql
	$query = sprintf("
		INSERT INTO desk_grupos
		(	grupo, descricao_grupo, bool_ativo)
		values 
		(	'%s', '%s', '%d')",
			mysqli_real_escape_string($mysqli,$grupo),	
			mysqli_real_escape_string($mysqli,$descricao_grupo),
			mysqli_real_escape_string($mysqli,$bool_ativo)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_grupo" => mysqli_insert_id($mysqli),
			"grupo" => $grupo,
			"descricao_grupo" => $descricao_grupo,
			"bool_ativo" => $bool_ativo	
		)
	));
?>