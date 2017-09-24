<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['trabalhoseinter'];
	$dados = json_decode($json);

	if($db->excluir('es_trabalho_caint', 'id', $dados->id)){
		echo json_encode(array(
			"success"=> true
		));
	}
?>