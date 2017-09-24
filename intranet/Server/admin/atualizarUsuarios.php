<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['usuario'];

	$dados = json_decode($json);
	$id_usuario 		= $dados->id_usuario;
	$email 				= $dados->email;
	$nome_usuario	 	= $dados->nome_usuario;
	$login 				= $dados->login;
	$password 			= $dados->password;

	// verifica se o login passado coincide com o do funcionario, se não coincidir é pq o login está duplicado
	$queryString = sprintf("
		SELECT login
		FROM desk_usuarios
		WHERE login = '%s'
		 AND id_usuario <> %d
		",
		mysqli_real_escape_string($mysqli,$login),
		mysqli_real_escape_string($mysqli,$id_usuario)
	);

	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultados = mysqli_num_rows($query);
	if ($resultados > 0){
		echo '{ success: false, msg: "Este login já está em uso por outro usuário." }';
		exit;
	}

	if(isset($dados->password)&&($password!="")){
		// Cria um salt aleatório
		$salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
		// Cria uma password com salt
		$password = hash('sha512', $password . $salt);

		$query = sprintf("
			UPDATE desk_usuarios
			SET login 			= '%s',
				email 			= '%s',
				password 		= '%s',
				salt 			= '%s',
				nome_usuario	= '%s'
			WHERE id_usuario = %d",
				mysqli_real_escape_string($mysqli,$login),
				mysqli_real_escape_string($mysqli,$email),
				mysqli_real_escape_string($mysqli,$password),
				mysqli_real_escape_string($mysqli,$salt),
				mysqli_real_escape_string($mysqli,$nome_usuario),
				mysqli_real_escape_string($mysqli,$id_usuario)
		);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	}
	else{
		$query = sprintf("
			UPDATE desk_usuarios
			SET login 			= '%s',
				email 			= '%s',
				nome_usuario	= '%s'
			WHERE id_usuario = %d",
				mysqli_real_escape_string($mysqli,$login),
				mysqli_real_escape_string($mysqli,$email),
				mysqli_real_escape_string($mysqli,$nome_usuario),
				mysqli_real_escape_string($mysqli,$id_usuario)
		);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	}

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => array(
			"id_usuario" => $id_usuario,
			"login" => $login,
			"email" => $email
		)
	));
?>