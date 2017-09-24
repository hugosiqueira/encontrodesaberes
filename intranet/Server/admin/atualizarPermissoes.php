<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['permissao'];

	$dados = json_decode($json);

	$id_permissao 				= $dados->id_permissao;
	$fgk_modulo 			= $dados->fgk_modulo;
	$permissao 				= utf8_decode($dados->permissao);
	$descricao_permissao 	= utf8_decode($dados->descricao_permissao);
	
	$query = sprintf("
		UPDATE desk_permissoes 
		SET fgk_modulo 			= '%d',
			permissao 			= '%s',
			descricao_permissao = '%s'
		WHERE id_permissao = %d",
			mysqli_real_escape_string($mysqli,$fgk_modulo),	
			mysqli_real_escape_string($mysqli,$permissao),
			mysqli_real_escape_string($mysqli,$descricao_permissao),
			mysqli_real_escape_string($mysqli,$id_permissao)		
		);
	mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_permissao" => $id_permissao,
			"fgk_modulo" => $fgk_modulo,
			"permissao" => $permissao,
			"descricao_permissao" => $descricao_permissao
		)
	));
?>