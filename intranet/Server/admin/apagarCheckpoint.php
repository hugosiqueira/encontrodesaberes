<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$json = $_POST['checkpoint'];
	$dados = json_decode($json);
		$id_local_presenca = $dados->id_local_presenca;

	$db->excluir('es_presencas_locais','id_local_presenca', $id_local_presenca);

	echo json_encode(array(
		"success" => true
	));
?>