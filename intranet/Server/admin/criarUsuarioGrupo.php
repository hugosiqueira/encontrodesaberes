<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_usuario = $_POST['id_usuario'];
	$id_grupo = $_POST['id_grupo'];
	
	//REMOVE O USUÁRIO DO SEU GRUPO ANTIGO
	$query = sprintf("
		DELETE FROM desk_usuarios_grupos WHERE fgk_usuario = %d",
		mysqli_real_escape_string($mysqli, $id_usuario)
	);
	mysqli_query($mysqli,$query);
	
	//CADASTRO DO USUÁRIO NO NOVO GRUPO
	$query = sprintf("
		INSERT INTO desk_usuarios_grupos
		(	fgk_usuario, fgk_grupo)
		values 
		(	'%d', '%d')",
			mysqli_real_escape_string($mysqli,$id_usuario),	
			mysqli_real_escape_string($mysqli,$id_grupo)
		);
	if (mysqli_query($mysqli,$query))
		echo '{"success":true, "msg": "Grupo vinculado com sucesso."}';
	else
		echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
	
?>