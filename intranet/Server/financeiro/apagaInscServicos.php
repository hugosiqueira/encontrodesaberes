<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];

	$json = $_POST['servico'];
	$dados = json_decode($json);
		$id_inscrito_servico = $dados->id_inscrito_servico;

	$db->excluir('es_inscritos_servicos','id_inscrito_servico', $id_inscrito_servico);

	echo json_encode(array(
		"success" => true
	));
?>