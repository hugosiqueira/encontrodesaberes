<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$vars = array('id_evento'=> $id_evento);
	$info = $db->sql_query("SELECT COUNT(id_presenca) AS num_inscritos, descricao_local AS checkpoint FROM es_presencas  INNER JOIN es_presencas_locais ON es_presencas.fgk_local_presenca = es_presencas_locais.id_local_presenca WHERE es_presencas.fgk_evento = ? GROUP BY fgk_local_presenca;", $vars);

	$checkpoints = array();
	foreach ($info as $checkpoint)
		$checkpoints[] = $checkpoint;

	echo json_encode(array(
		"success" => true,
		"info" => $checkpoints
	));
?>