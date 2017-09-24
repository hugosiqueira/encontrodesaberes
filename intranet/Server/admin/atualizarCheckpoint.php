<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$json = $_POST['checkpoint'];
	$dados = json_decode($json);
		$id_local_presenca = $dados->id_local_presenca;
		$descricao_local = $dados->descricao_local;
		$apelido_local = $dados->apelido_local;

	$vars = array('descricao_local'=>$descricao_local, 'apelido_local'=>$apelido_local);
	$db->atualizar('es_presencas_locais', $vars, 'id_local_presenca', $id_local_presenca);

	echo json_encode(array(
		"success" => true
	));
?>