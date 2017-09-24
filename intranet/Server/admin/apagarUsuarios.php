<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['usuario'];
	
	$dados = json_decode($json);
	$id_usuario = $dados->id_usuario;

	$query = sprintf("
		DELETE FROM desk_usuarios_grupos WHERE fgk_usuario = %d",
		mysqli_real_escape_string($mysqli, $id_usuario)
	);
	mysqli_query($mysqli,$query);

	$query = sprintf("
		DELETE FROM desk_usuarios WHERE id_usuario = %d",
		mysqli_real_escape_string($mysqli, $id_usuario)
	);
	mysqli_query($mysqli,$query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>