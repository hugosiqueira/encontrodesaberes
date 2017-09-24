<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	$senha_atual 	= $_POST['senha_atual'];
	$nova_senha 	= $_POST['nova_senha'];
	$id_usuario		= $_SESSION['user_id'];
	
	//Verifica se a senha atual coincide com a informada
	$queryString = "
		SELECT desk_usuarios.* FROM desk_usuarios WHERE id_usuario = '$id_usuario'";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));	
	while($registro = mysqli_fetch_assoc($query)) {
		$db_password = $registro['password'];		
		$db_salt	 = $registro['salt'];		
	}
	$senha_atual = hash('sha512', $senha_atual . $db_salt);	
	if($senha_atual != $db_password){
		echo '{"success":false, "msg": "A senha atual é diferente da informada."}';
	}
	else{
		$salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); 
		$nova_senha = hash('sha512', $nova_senha . $salt);
		$query = sprintf("
			UPDATE desk_usuarios 
			SET password 		= '%s',
				salt 			= '%s'
			WHERE id_usuario = %d",
				mysqli_real_escape_string($mysqli,$nova_senha),	
				mysqli_real_escape_string($mysqli,$salt),
				mysqli_real_escape_string($mysqli,$id_usuario)
		);
		if (mysqli_query($mysqli,$query))
			echo '{"success":true, "msg": "Senha alterada com sucesso."}';
		else
			echo '{"success":false, "msg": "Erro 0001. Favor entrar em contato com o administrador do sistema"}';
	}	
?>