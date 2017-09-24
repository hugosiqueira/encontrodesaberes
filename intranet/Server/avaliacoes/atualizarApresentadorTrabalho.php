<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['apresentador'];
	$dados = json_decode($json);
	// {"id":1227,"nome":"APARECIDA BARBOSA MAGESTE (DEQUI)","cpf":"015.681.386-60","bool_apresentador":true}
	
	if($dados->bool_apresentador == 1){
		$atualizar = array(
			'bool_apresentador'=> 0
		);
		$db->atualizar('es_trabalho_autor', $atualizar, 'fgk_trabalho', $dados->fgk_trabalho);
		
		$atualizar = array(
			'bool_apresentador'=> 1
		);
		$db->atualizar('es_trabalho_autor', $atualizar, 'id', $dados->id);
	}
	else{
		$atualizar = array(
			'bool_apresentador'=> 0
		);
		$db->atualizar('es_trabalho_autor', $atualizar, 'id', $dados->id);
	}

	echo json_encode(array(
		"success" => true
	));
?>