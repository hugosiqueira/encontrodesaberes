<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	
	
	$json = $_POST['minicurso'];
	$dados = json_decode($json);
	
	$atualizar = array(
		'apresentador'	=> $dados->apresentador,
		'classificacao'	=> $dados->classificacao,
		'data'			=> $dados->data,
		'hora_ini'		=> $dados->hora_ini,
		'hora_fim'		=> $dados->hora_fim,
		'local'			=> $dados->local,
		'max_alunos'	=> $dados->max_alunos,
		'resumo'		=> $dados->resumo,
		'titulo'		=> $dados->titulo
	);	

	$db->atualizar('es_minicursos', $atualizar, 'id', $dados->id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Atualizado com sucesso."
	));
?>