<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	$id_usuario = $_SESSION['user_id'];

	$queryString = "
		SELECT nome_usuario, es_evento.edicao
		FROM desk_usuarios_evento
		 INNER JOIN desk_usuarios ON desk_usuarios.id_usuario = desk_usuarios_evento.fgk_usuario
		 INNER JOIN es_evento on es_evento.id = desk_usuarios_evento.fgk_evento
		WHERE desk_usuarios_evento.fgk_usuario = $id_usuario
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	while($resultado = mysqli_fetch_assoc($query)) {
		$nome = $resultado['nome_usuario'];
		// $evento = $_SESSION['primeiro_evento'];
	}

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"nome" => $nome
		// ,"grupo" => $evento
	));
?>