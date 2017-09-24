<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$json = $_POST['sessao'];
	$dados = json_decode($json);

	$dia = new DateTime($dados->dia);

	$sessao = array(
		'dia'			=> $dia->format('Y-m-d'),
		'hora_ini'		=> $dados->hora_ini,
		'hora_fim'		=> $dados->hora_fim,
		'nome'			=> $dados->nome,
		'sessao'		=> $dados->sessao,
		'fgk_evento'	=> $id_evento_atual
	);
	$db->inserir('es_sessao', $sessao);
	$id_sessao = $db->lastInsertId();

	echo json_encode(array(
		"success" => true,
		"id_sessao" => $id_sessao
	));
?>