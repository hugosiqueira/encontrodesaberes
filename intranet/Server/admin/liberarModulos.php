<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_modulo = $_POST['id_modulo'];
	$bool_ativo = $_POST['bool_ativo'];
	if($bool_ativo == '1')
		$bool_ativo = '0';
	else
		$bool_ativo = '1';
	$query = sprintf("
		UPDATE desk_modulos 
			SET bool_ativo = '%d'
		WHERE id_modulo = %d",
			mysqli_real_escape_string($mysqli,$bool_ativo),	
			mysqli_real_escape_string($mysqli,$id_modulo)		
		);

	if (mysqli_query($mysqli,$query))
		echo '{"success":true, "msg": "Módulo liberado com sucesso."}';
	else
		echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
	
	
?>