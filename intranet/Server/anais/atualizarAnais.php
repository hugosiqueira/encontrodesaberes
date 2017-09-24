<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['trabalho'];
	$dados = json_decode($json);

	$atualizar = array(
		'bool_premiado'=>  $dados->bool_premiado,
		'fgk_area_especifica'=>  $dados->fgk_area_especifica,
		'palavras_chave'=>  $dados->palavras_chave,
		'resumo'=>  $dados->resumo,
		'titulo'=>  $dados->titulo
	);
	$db->atualizar('es_anais_trabalho', $atualizar, 'id', $dados->id);

	echo json_encode(array(
		"success" => true
	));
?>