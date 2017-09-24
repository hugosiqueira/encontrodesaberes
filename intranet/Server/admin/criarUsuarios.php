<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['usuario'];
	
	$dados = json_decode($json);
	
	$email 				= $dados->email;
	$nome_usuario 		= $dados->nome_usuario;
	$login 				= $dados->login;
	$password 			= $dados->password;	 
	$bool_ativo 		= 0;
	
	// Cria um salt aleatório
	$salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); 
	// Cria uma password com salt 
	$password = hash('sha512', $password . $salt);
	
	//verifica se já existe este login
	$queryString = "
		SELECT login FROM desk_usuarios WHERE login = '$login'";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultados = mysqli_num_rows($query);
	if ($resultados > 0){
		echo '{ success: false, msg: "Este login já está em uso." }';
		exit;
	}
	//verifica se o funcionário já possui um usuário
	 
	$query = sprintf("
		INSERT INTO desk_usuarios
		(	login, email, password, salt, nome_usuario, bool_ativo)
		values 
		(	'%s', '%s', '%s', '%s', '%s', '%d')",
			mysqli_real_escape_string($mysqli,$login),	
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$password),
			mysqli_real_escape_string($mysqli,$salt),
			mysqli_real_escape_string($mysqli,$nome_usuario),
			mysqli_real_escape_string($mysqli,$bool_ativo)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	$id_usuario = mysqli_insert_id($mysqli);
	//vincula o usuário recém criado com o grupo de usuários restritos.
	//5
	$query = sprintf("
		INSERT INTO desk_usuarios_grupos
		(	fgk_usuario, fgk_grupo)
		values 
		(	'%s', 5)",
			mysqli_real_escape_string($mysqli,$id_usuario)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
		,"resultado" => array(
			"id_usuario" => $id_usuario,
			"login" => $login,
			"email" => $email,
			"bool_ativo" => $bool_ativo	
		)
	));
?>