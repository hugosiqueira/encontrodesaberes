<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");


	$json = $_POST['autores'];
	$dados = json_decode($json);

	$db->excluir('es_anais_trabalho_autor', 'id', $dados->id);
	
	echo json_encode(array(
		"success" => true
	));
?>