<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['servico'];
	$dados = json_decode($json);
	$id_servico = $dados->id;

	$db->excluir('es_servicos','id_servico',$id_servico);

	echo json_encode(array(
		"success" => true
	));
?>