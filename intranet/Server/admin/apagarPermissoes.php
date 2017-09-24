<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['permissao'];
	
	$dados = json_decode($json);
	$id_permissao = $dados->id_permissao;

	$query = sprintf("
		DELETE FROM desk_grupos_permissoes WHERE fgk_permissao = %d",
		mysqli_real_escape_string($mysqli, $id_permissao)
	);
	mysqli_query($mysqli,$query);

	$query = sprintf("
		DELETE FROM desk_permissoes WHERE id_permissao = %d",
		mysqli_real_escape_string($mysqli, $id_permissao)
	);
	mysqli_query($mysqli,$query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>