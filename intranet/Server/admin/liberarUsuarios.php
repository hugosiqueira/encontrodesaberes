<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_usuario = $_POST['id_usuario'];
	$bool_ativo = $_POST['bool_ativo'];
	if($bool_ativo == '1')
		$bool_ativo = '0';
	else
		$bool_ativo = '1';
	$query = sprintf("
		UPDATE desk_usuarios 
			SET bool_ativo = '%d'
		WHERE id_usuario = %d",
			mysqli_real_escape_string($mysqli,$bool_ativo),	
			mysqli_real_escape_string($mysqli,$id_usuario)		
		);

	if (mysqli_query($mysqli,$query))
		echo '{"success":true, "msg": "Usuário liberado/bloqueado com sucesso."}';
	else
		echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
	
	
?>