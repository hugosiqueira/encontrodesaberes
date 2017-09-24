<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['orgao'];
	$dados = json_decode($json);

	$id		= $dados->id;
	$sigla	= $dados->sigla;
	$nome 	= $dados->nome;

	$query = sprintf("
		UPDATE es_orgao_fomento
		SET sigla	= '%s',
			nome	= '%s'
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$sigla),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$id)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Órgão fomento atualizado com sucesso."
	));
?>