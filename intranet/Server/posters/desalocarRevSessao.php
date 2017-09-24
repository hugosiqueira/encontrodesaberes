<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	$id_apresentacao	= $_REQUEST['id_apresentacao'];

	if($db->excluir('es_trabalho_apresentacao', 'id', $id_apresentacao)){
		echo json_encode(array(
			"success"=> true
		));
	}

?>