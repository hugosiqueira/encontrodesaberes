<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['responsavel'];
	$dados = json_decode($json);
		$id_usuario = $dados->id_usuario;
		$id_checkpoint = $dados->id_local;

	$vars = array('fgk_usuario'=>$id_usuario, 'fgk_presenca_local'=>$id_checkpoint);
	$db->inserir('es_presencas_locais_usuarios', $vars);

	echo json_encode(array(
		"success" => true,
		"msg" => 'Usuário vinculado com sucesso!'
	));
?>