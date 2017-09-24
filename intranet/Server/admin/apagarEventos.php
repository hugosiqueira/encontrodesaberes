<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['evento'];
	
	$dados = json_decode($json);
	$id_evento = $dados->id;
	
	$query = sprintf("
		DELETE FROM desk_usuarios_evento WHERE fgk_evento = %d",
		mysqli_real_escape_string($mysqli, $id_evento)
	);
	mysqli_query($mysqli,$query);
	
	$query = sprintf("
		DELETE FROM es_evento WHERE id = %d",
		mysqli_real_escape_string($mysqli, $id_evento)
	);
	mysqli_query($mysqli,$query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>