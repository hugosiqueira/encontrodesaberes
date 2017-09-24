<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	require_once '../../includes/functions.php';
	sec_session_start();
	error_reporting(0);

	$id_usuario = $_SESSION['user_id'];

	$result0 = $db->listar('es_presencas_locais_usuarios', 'fgk_usuario', $id_usuario);
	if($result0->fgk_presenca_local){
		$id_local = $result0->fgk_presenca_local;

		$result1 = $db->listar('es_presencas_locais', 'id_local_presenca', $id_local);
			$nome_local = $result1->descricao_local;

		echo json_encode(array(
			"success" => true,
			"id_local" => $id_local,
			"nome_local" => $nome_local
		));
	}else{
		echo json_encode(array(
			"success" => false,
			"msg" => "Este usuário não está vinculado a um checkpoint, alterações não serão salvas."
		));
	}
	// var_dump($_SESSION);
?>