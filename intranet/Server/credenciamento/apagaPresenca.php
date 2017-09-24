<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['id'];
	$dados = json_decode($json);

	foreach ($dados as $id){
		$db->excluir('es_presencas','id_presenca',$id);
	}

	echo json_encode( array(
		"success" => true
	));
?>