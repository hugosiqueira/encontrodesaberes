<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');

	$json = $_POST['revisor'];
	$dados = json_decode($json);
	$id_revisor = $dados->id;

	if($db->excluir('es_avaliacao_revisor', 'id', $id_revisor)){
		echo json_encode(array(
			"success"=> true,
			"msg" => "Revisor removido com sucesso."
		));
	}

?>