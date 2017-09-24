<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['modulo'];
	
	$dados = json_decode($json);
	
	$nome_modulo 	= utf8_decode($dados->nome_modulo);
	$name 			= $dados->name;
	$iconCls 		= $dados->iconCls;
	$module 		= $dados->module;
	$bool_ativo 	= 0;

	//consulta sql
	$query = sprintf("
		INSERT INTO desk_modulos
		(	nome_modulo, name, 	iconCls,	module,	bool_ativo)
		values 
		(	'%s', 		'%s', 	'%s', 		'%s', '	%d')",
			mysqli_real_escape_string($mysqli,$nome_modulo),	
			mysqli_real_escape_string($mysqli,$name),
			mysqli_real_escape_string($mysqli,$iconCls),
			mysqli_real_escape_string($mysqli,$module),
			mysqli_real_escape_string($mysqli,$bool_ativo)
		);
	$rs  = mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_modulo" => mysqli_insert_id($mysqli),
			"nome_modulo" => $nome_modulo,
			"name" => $name,
			"iconCls" => $iconCls,
			"module" => $module,
			"bool_ativo" => $bool_ativo			
		)
	));
?>