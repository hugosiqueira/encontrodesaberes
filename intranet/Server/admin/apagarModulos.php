<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['modulo'];
	
	$dados = json_decode($json);
	$id_modulo = $dados->id_modulo;

	$query = sprintf("
		DELETE FROM desk_grupos_modulos WHERE fgk_modulo = %d",
		mysqli_real_escape_string($mysqli, $id_modulo)
	);
	$rs = mysqli_query($mysqli,$query);
	
	$query = sprintf("
		DELETE FROM desk_modulos WHERE id_modulo = %d",
		mysqli_real_escape_string($mysqli, $id_modulo)
	);
	$rs = mysqli_query($mysqli,$query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>