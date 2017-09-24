<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_evento = $_REQUEST['id_evento'];
	$id_local = $_REQUEST['checkpoint'];

	$queryString = "
		SELECT desk_usuarios.nome_usuario, desk_usuarios.id_usuario
		FROM es_presencas_locais_usuarios
		INNER JOIN desk_usuarios ON desk_usuarios.id_usuario = es_presencas_locais_usuarios.fgk_usuario
		INNER JOIN desk_usuarios_evento ON desk_usuarios_evento.fgk_usuario = desk_usuarios.id_usuario
		WHERE desk_usuarios_evento.fgk_evento = $id_evento 
		AND fgk_presenca_local = $id_local 
		ORDER BY nome_usuario ASC";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));

	$usuarios = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$usuarios[] = $registro;
	}

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $usuarios
	));
?>