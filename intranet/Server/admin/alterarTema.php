<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_grupo	= $_POST['id_grupo'];
	$id_tema 	= $_POST['id_tema'];
	
	$query = sprintf("
		UPDATE desk_grupos 
		SET fgk_tema = '%d'
		WHERE id_grupo = '%d' ",
			mysqli_real_escape_string($mysqli,$id_tema),	
			mysqli_real_escape_string($mysqli,$id_grupo)
		);
	if (mysqli_query($mysqli,$query))
		echo '{"success":true, "msg": "Tema aplicado no grupo com sucesso."}';
	else
		echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
?>