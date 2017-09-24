<?php
	//chama o arquivo de conexão com o bd
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();
	
	$nome_modulo = $_POST['modulo'];
	$id_usuario = $_SESSION['user_id'];
	
	//PEGA O ID DO MÓDULO
	$queryString = "SELECT id_modulo FROM desk_modulos WHERE module = '$nome_modulo'";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());	
	while($resultado = mysqli_fetch_assoc($query)) {
		$id_modulo = $resultado['id_modulo'];
	}
	//echo $id_modulo;
	
	//PEGA O GRUPO DO USUÁRIO LOGADO
	$queryString = "SELECT fgk_grupo FROM desk_usuarios_grupos WHERE fgk_usuario = $id_usuario";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());	
	while($resultado = mysqli_fetch_assoc($query)) {
		$id_grupo = $resultado['fgk_grupo'];
	}
	//echo $id_grupo;
	
	
	//RETORNA UM JSON COM AS PERMISSÕES DO USUÁRIO LOGADO PARO O MÓDULO REQUISITADO
	$queryString2 = "
		SELECT desk_permissoes.* 
		FROM desk_grupos_permissoes 
		 INNER JOIN desk_permissoes ON desk_grupos_permissoes.fgk_permissao = desk_permissoes.id_permissao 
		WHERE desk_grupos_permissoes.fgk_grupo = $id_grupo AND desk_permissoes.fgk_modulo = $id_modulo
	";
	$query2 = mysqli_query($mysqli,$queryString2) or die(mysqli_error());

	$permissoes = array();	
	while($resultado2 = mysqli_fetch_assoc($query2)) {
	    $permissoes[] = $resultado2['permissao'];
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"permissoes" => $permissoes
	));
?>