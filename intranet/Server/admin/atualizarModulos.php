<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['modulo'];

	$dados = json_decode($json);

	$id_modulo 		= $dados->id_modulo;
	$nome_modulo 	= utf8_decode($dados->nome_modulo);
	$name 			= $dados->name;
	$iconCls 		= $dados->iconCls;
	$module 		= $dados->module;
	$bool_ativo 	= $dados->bool_ativo;
	
	$query = sprintf("
		UPDATE desk_modulos 
		SET nome_modulo = '%s',
			name= '%s',
			iconCls = '%s',
			module= '%s',
			bool_ativo = '%d'
		WHERE id_modulo = %d",
			mysqli_real_escape_string($mysqli,$nome_modulo),	
			mysqli_real_escape_string($mysqli,$name),
			mysqli_real_escape_string($mysqli,$iconCls),
			mysqli_real_escape_string($mysqli,$module),
			mysqli_real_escape_string($mysqli,$bool_ativo),
			mysqli_real_escape_string($mysqli,$id_modulo)			
		);

	$rs = mysqli_query($mysqli,$query);
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_modulo" => $id_modulo,
			"nome_modulo" => $nome_modulo,
			"name" => $name,
			"iconCls" => $iconCls,
			"module" => $module,
			"bool_ativo" => $bool_ativo			
		)
	));
?>