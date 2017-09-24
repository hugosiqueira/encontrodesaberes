<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['servico'];
	$dados = json_decode($json);
	$id_servico = $dados->id;
	$valor = $dados->valor_servico;
	$descricao = $dados->descricao_servico;

	$dados = array('descricao_servico'=>$descricao, 'valor_servico'=>$valor);
	$db->atualizar('es_servicos', $dados, 'id_servico', $id_servico);

	echo json_encode(array(
		"success" => true
	));
?>