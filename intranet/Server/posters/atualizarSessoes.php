<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();


	$json = $_POST['sessao'];
	$dados = json_decode($json);
	
	$dia = new DateTime($dados->dia);
	
	$sessao = array(
		'dia'			=> $dia->format('Y-m-d'),
		'hora_ini'		=> $dados->hora_ini,
		'hora_fim'		=> $dados->hora_fim,
		'nome'			=> $dados->nome,
		'sessao'		=> $dados->sessao
	);

	$db->atualizar('es_sessao', $sessao, 'id', $dados->id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Sessão atualizado com sucesso."
	));
?>