<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$json = $_POST['trabalho'];
	$dados = json_decode($json);

	$novo = array(
		'fgk_evento'		=> $id_evento_atual,
		'bool_premiado'		=> $dados->bool_premiado,
		'fgk_area_especifica'=> $dados->fgk_area_especifica,
		'palavras_chave'	=> $dados->palavras_chave,
		'resumo'			=> $dados->resumo,
		'datahora_registro'			=> date('Y-m-d h:i:s'),
		'titulo'			=> $dados->titulo
	);
	$db->inserir('es_anais_trabalho', $novo);	
	$id_trabalho = $db->lastInsertId();
	
	echo json_encode(array(
		"success" => true,
		"id_trabalho" => $id_trabalho,
		"resultado" => array(
			"id" => $id_trabalho,
			"fgk_area_especifica" => $dados->fgk_area_especifica,
			"resumo" => $dados->resumo,
			"titulo" => $dados->titulo,
			"palavras_chave" => $dados->palavras_chave,
			"bool_premiado" => $dados->bool_premiado
		)
	));

?>