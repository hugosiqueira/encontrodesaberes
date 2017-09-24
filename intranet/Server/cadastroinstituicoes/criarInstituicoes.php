<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$json = $_POST['instituicao'];
	$dados = json_decode($json);

	$sigla	= $dados->sigla;
	$nome	= $dados->nome;
	
	$query = sprintf("
		INSERT INTO es_instituicao
		(	ordem, sigla, nome	)
		values
		(	0, '%s','%s'	)",
		mysqli_real_escape_string($mysqli,$sigla),
		mysqli_real_escape_string($mysqli,$nome)
		);
	mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Instituição registrada com sucesso."
	));
		
?>