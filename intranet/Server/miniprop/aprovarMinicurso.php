<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id 	= $_REQUEST['id'];
	$apresentador 	= $_REQUEST['responsavel'];
	
	$minicurso = $db->listar('es_minicursos_propostos', 'id_minicurso_prop', $id);
	$minicurso->assunto;
	
	$criar = array(
		'fgk_evento'		=> $id_evento_atual,
		'apresentador'		=> $apresentador,
		'resumo'			=> $minicurso->resumo,
		'titulo'			=> $minicurso->assunto,
		'bool_publicado'	=> 1,
		'datahora_registro'	=> date('Y-m-d H:i:s')
	);
	$db->inserir('es_minicursos', $criar);
	
	$aprovar = array(
		'status'=> 3
	);
	$db->atualizar('es_minicursos_propostos', $aprovar, 'id_minicurso_prop', $id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Aprovado com sucesso."
	));
?>