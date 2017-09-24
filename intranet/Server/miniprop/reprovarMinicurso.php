<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id 	= $_REQUEST['id'];
	
	$reprovar = array(
		'status'=> 4
	);

	$db->atualizar('es_minicursos_propostos', $reprovar, 'id_minicurso_prop', $id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Reprovado com sucesso."
	));
?>