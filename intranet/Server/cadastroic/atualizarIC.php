<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['ic'];
	$dados = json_decode($json);
	
	$id					= $dados->id;
	$sigla					= $dados->sigla;
	$fgk_tipo_apresentacao	= $dados->fgk_tipo_apresentacao;
	$nome 					= $dados->nome;
	
	$query = sprintf("
		UPDATE es_programa_ic
		SET sigla			= '%s',
			fgk_tipo_apresentacao	= %d,
			nome	= '%s'
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$sigla),
			mysqli_real_escape_string($mysqli,$fgk_tipo_apresentacao),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$id)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Programa atualizado com sucesso."
	));
?>