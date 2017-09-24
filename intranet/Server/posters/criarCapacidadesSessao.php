<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['capacidade'];
	$dados = json_decode($json);

	
	// capacidade:{"id":0,"id_sessao_capacidade":0,"fgk_area":0,"id_area":0,"fgk_sessao":9,"capacidade":123,"descricao_area":""}
	
	$capacidade = array(
		'fgk_area'			=> $dados->fgk_area,
		'fgk_sessao'		=> $dados->fgk_sessao,
		'capacidade'		=> $dados->capacidade
	);
	$db->inserir('es_sessao_capacidade', $capacidade);

	echo json_encode(array(
		"success" => true
	));
?>