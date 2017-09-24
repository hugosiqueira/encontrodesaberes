<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_minicurso_prop 	= $_REQUEST['id_minicurso_prop'];
	$status = $_REQUEST['status'];

	$atualizarStatus = array(
		'status'=>$status
	);

	$db->atualizar('es_minicursos_propostos', $atualizarStatus, 'id_minicurso_prop', $id_minicurso_prop);

	echo json_encode(array(
		"success" => true,
		"msg" => "Status atualizado com sucesso."
	));
?>