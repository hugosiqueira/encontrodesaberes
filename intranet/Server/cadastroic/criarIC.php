<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
		
	$json = $_POST['ic'];
	$dados = json_decode($json);

	$sigla					= $dados->sigla;
	$fgk_tipo_apresentacao	= $dados->fgk_tipo_apresentacao;
	$nome 					= $dados->nome;
	
	$query = sprintf("
		INSERT INTO es_programa_ic
		(	atual, sigla, fgk_tipo_apresentacao, nome	)
		values
		(	1, '%s',%d,'%s'	)",
		mysqli_real_escape_string($mysqli,$sigla),
		mysqli_real_escape_string($mysqli,$fgk_tipo_apresentacao),
		mysqli_real_escape_string($mysqli,$nome)
		);
	mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Programa registrado com sucesso."
	));
		
?>