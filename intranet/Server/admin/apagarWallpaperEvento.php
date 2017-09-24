<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_evento = $_POST['id_evento'];
	$onde = '../../resources/wallpapers/';
	$arquivo = $onde.$id_evento.'.jpg';
	
	if(unlink($arquivo)){
		echo json_encode(array(
			"success" => true,
			"msg"	=> 'Plano de fundo apagado com sucesso.'
		));
	}
	else{
		echo json_encode(array(
			"success" => false,
			"msg"	=> 'Ero ao apagar arquivo. Favor entrar em contato com o administrador do sistema.'
		));		
	}
	
	
	
?>