<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();


	$json = $_POST['capacidade'];
	$dados = json_decode($json);

	$edit = array(
		'capacidade' => $dados->capacidade
	);

	$db->atualizar('es_sessao_capacidade', $edit, 'id', $dados->id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Capacidade atualizada com sucesso."
	));
?>