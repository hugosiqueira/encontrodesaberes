<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_inscrito = $_POST['id_inscrito'];
	$conta_ativada = $_POST['conta_ativada'];

	if($conta_ativada == '1')
		$conta_ativada = 0;
	else
		$conta_ativada = 1;
	

	$ativarInscrito = array(
		'conta_ativada'=>$conta_ativada
	);

	$db->atualizar('es_inscritos', $ativarInscrito, 'id', $id_inscrito);

	echo json_encode(array(
		"success" => true,
		"msg" => "Inscrito atualizado com sucesso."
	));
?>