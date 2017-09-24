<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$json = $_POST['insc'];
	$dados = json_decode($json);
		$id_inscrito = $dados->id;
		$nome_credencial = $dados->nome_credencial;
		$nome_instituicao = $dados->nome_instituicao;

	$vars = array('nome_credencial'=>$nome_credencial, 'info_credencial'=>$nome_instituicao, 'fgk_evento'=>$id_evento, 'fgk_inscrito'=>$id_inscrito);
	$funcionario = $db->sql_query("UPDATE es_inscritos_credencial SET nome_credencial=?, info_credencial=? WHERE fgk_evento=? AND fgk_inscrito=?;", $vars);

	echo json_encode(array(
		"success"=>true,
		"msg"=>"Alteracões salvas com sucesso!"
	));
?>