<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_grupo = $_POST['id_grupo'];
	$bool_ativo = $_POST['bool_ativo'];
	if($bool_ativo == '1')
		$bool_ativo = '0';
	else
		$bool_ativo = '1';
	$query = sprintf("
		UPDATE desk_grupos 
			SET bool_ativo = '%d'
		WHERE id_grupo = %d",
			mysqli_real_escape_string($mysqli,$bool_ativo),	
			mysqli_real_escape_string($mysqli,$id_grupo)		
		);

	if (mysqli_query($mysqli,$query))
		echo '{"success":true, "msg": "Grupo liberado/bloqueado com sucesso."}';
	else
		echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
	
	
?>