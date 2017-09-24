<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_trabalho 		= $_REQUEST['id_trabalho'];
	$autores_ordenados 	= json_decode($_REQUEST['autores_ordenados']);

	for($i=0;$i<count($autores_ordenados);$i++){
		$atualizar = array(
			'ordenacao'				=> $i+1
		);
		$db->atualizar('es_trabalho_autor', $atualizar, 'id', $autores_ordenados[$i]);
	}

	echo json_encode(array(
		"success" => true,
		"msg" => "Registro alterado com sucesso.",
		"id_trabalho" => $id_trabalho,
		"ordem" => $autores_ordenados
	));
?>