<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id = $_POST['id'];
	$onde = '../../../img/certificados/tipos/';
	$arquivo = $onde.$id.'.jpg';

	if(unlink($arquivo))
		echo "{success: true, msg:'Imagem removida com sucesso.'}";
	else
		echo "{success: false, msg:'Erro ao apagar imagem. Favor entrar em contato com o administrador do sistema.'}";

?>