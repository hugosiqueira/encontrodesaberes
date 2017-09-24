<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$json = $_POST['checkpoint'];
	$dados = json_decode($json);
	$descricao_local = $dados->descricao_local;
	$apelido_local = $dados->apelido_local;

	$vars = array('fgk_evento'=>$id_evento, 'descricao_local'=>$descricao_local,'apelido_local'=>$apelido_local);
	$db->inserir('es_presencas_locais', $vars);

	echo json_encode(array(
		"success" => true
	));
?>