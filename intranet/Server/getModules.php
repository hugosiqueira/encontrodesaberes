<?php
	header('Content-Type: application/json; charset=utf-8');
	//chama o arquivo de conexão com o bd
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	
	sec_session_start();
	$id_usuario = $_SESSION['user_id'];
	$queryString = "SELECT * FROM desk_usuarios_grupos WHERE fgk_usuario = $id_usuario";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));	
	while($resultado = mysqli_fetch_assoc($query)) {
		$id_grupo = $resultado['fgk_grupo'];
	}	
	if($id_grupo == '1'){
		$queryString = "
			SELECT desk_modulos.* 
			FROM desk_modulos
			WHERE desk_modulos.bool_ativo = 1 
			ORDER BY desk_modulos.nome_modulo";
	}
	else{
		$queryString = "SELECT desk_modulos.* FROM desk_grupos_modulos INNER JOIN desk_modulos ON desk_modulos.id_modulo = desk_grupos_modulos.fgk_modulo WHERE fgk_grupo = $id_grupo AND desk_modulos.bool_ativo = 1 ORDER BY desk_modulos.nome_modulo";
	}
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$shortcuts = array();
	$modules = array();
	while($resultado = mysqli_fetch_assoc($query)) {
		$resultado['nome_modulo'] = $resultado['nome_modulo']; //trata os acentos direto
	    $shortcuts[] = $resultado;
		$modules[] =  "Seic.view.module.".$resultado['name'];
	}

	// echo  utf8_encode($shortcuts);
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"shortcuts" => $shortcuts,
		"modules" => $modules
	));
?>