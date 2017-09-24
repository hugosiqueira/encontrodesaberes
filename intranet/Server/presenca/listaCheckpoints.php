<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$locais = array();
	$checkpoints = $db->listar_condicional('es_presencas_locais', array('id_local_presenca, descricao_local'), array('fgk_evento'=>$id_evento));
	foreach($checkpoints as $local) {
		$locais[] = $local;
	}

	echo json_encode(array(
		"success" => true,
		"locais" => $locais
	));
?>