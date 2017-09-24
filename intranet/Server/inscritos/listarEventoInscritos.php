<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_usuario = $_SESSION['primeiro_user'];
	
	$queryString = "
		SELECT desk_usuarios_grupos.fgk_grupo
		FROM desk_usuarios_grupos
		WHERE desk_usuarios_grupos.fgk_usuario = $id_usuario
	";	
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());	
	$resultado = mysqli_fetch_assoc($query);
	$id_grupo = $resultado['fgk_grupo'];

	if( $id_grupo == '1'){
		$queryString = "
			SELECT es_evento.*
			FROM es_evento
			ORDER BY data_evento_ini DESC
		";
	}
	else{
		$queryString = "
			SELECT es_evento.*
			FROM es_evento
			 INNER JOIN desk_usuarios_evento ON desk_usuarios_evento.fgk_evento = es_evento.id
			WHERE fgk_usuario = $id_usuario
			ORDER BY data_evento_ini DESC
		";
	}
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$eventos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['rend_evento'] = $registro['sigla'] . " - " . $registro['titulo'];
		$eventos[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($eventos),
		"resultado" => $eventos
	));
?>