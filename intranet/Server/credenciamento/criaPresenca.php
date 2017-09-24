<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	date_default_timezone_set('America/Sao_Paulo');

	$id_evento = $_SESSION['id_evento_atual'];
	$id_inscrito = $_POST['id'];
	$data = $_POST['data'];
	$hora = $_POST['hora'];
	$fgk_local = $_POST['local'];

	$dateSave = date($data.' '.$hora);

	$insertData = array('fgk_evento'=> $id_evento, 'fgk_inscrito'=> $id_inscrito, 'fgk_local_presenca'=> $fgk_local, 'datahora_presenca'=> $dateSave );
	$db->inserir('es_presencas', $insertData);

	echo json_encode( array(
		"success" => true
	));
?>