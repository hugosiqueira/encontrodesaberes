<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_evento = $_REQUEST['id_evento'];

	$queryString = "
		SELECT desk_usuarios.nome_usuario, desk_grupos.grupo, id_usuario
		FROM desk_usuarios_evento
		 INNER JOIN desk_usuarios ON desk_usuarios.id_usuario = desk_usuarios_evento.fgk_usuario
		 INNER JOIN desk_usuarios_grupos ON desk_usuarios_grupos.fgk_usuario = desk_usuarios_evento.fgk_usuario
		 INNER JOIN desk_grupos ON desk_grupos.id_grupo = desk_usuarios_grupos.fgk_grupo
		WHERE desk_usuarios_evento.fgk_evento = $id_evento AND fgk_grupo <> 1
		ORDER BY grupo ASC ,nome_usuario ASC";
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