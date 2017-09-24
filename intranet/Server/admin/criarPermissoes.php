<?php
// aaaaaaaaaa
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['permissao'];
	
	$dados = json_decode($json);
	
	$fgk_modulo 			= $dados->fgk_modulo;
	$permissao 				= utf8_decode($dados->permissao);
	$descricao_permissao 	= utf8_decode($dados->descricao_permissao);

	//consulta sql
	$query = sprintf("
		INSERT INTO desk_permissoes
		(	fgk_modulo, permissao, descricao_permissao)
		values 
		(	'%d', '%s', '%s')",
			mysqli_real_escape_string($mysqli,$fgk_modulo),	
			mysqli_real_escape_string($mysqli,$permissao),
			mysqli_real_escape_string($mysqli,$descricao_permissao)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_permissao" => mysqli_insert_id($mysqli),
			"fgk_modulo" => $fgk_modulo,
			"permissao" => $permissao,
			"descricao_permissao" => $descricao_permissao	
		)
	));
?>