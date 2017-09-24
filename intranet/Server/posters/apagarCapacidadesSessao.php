<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');

	$json = $_POST['capacidade'];
	$dados = json_decode($json);

	$db->excluir('es_sessao_capacidade', 'id', $dados->id_sessao_capacidade);
		echo json_encode(array(
			"success"=> true,
			"msg" => "Sessão removido com sucesso."
		));


?>