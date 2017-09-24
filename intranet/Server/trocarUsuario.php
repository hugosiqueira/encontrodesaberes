<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';	
	sec_session_start();
	
	$novo_user_id = $_REQUEST['novo_usuario'];
	
	$queryString = "SELECT id_usuario, login, password, salt, fgk_funcionario,ultimo_acesso, nome
        FROM desk_usuarios INNER JOIN funcionario ON fgk_funcionario = id_funcionario INNER JOIN cidadao ON id_cidadao = fgk_cidadao WHERE id_usuario = $novo_user_id";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());	
	while($registro = mysqli_fetch_assoc($query)) {
		$_SESSION['erro'] = 0; // sem erros
		$_SESSION['user_id'] = $registro['id_usuario'];
		$_SESSION['ultimo_acesso'] = $registro['ultimo_acesso'];
		$_SESSION['nome'] = $registro['nome'];
		$_SESSION['fgk_funcionario'] = $registro['fgk_funcionario'];
		$_SESSION['login'] = $registro['login'];
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		$db_password= $registro['password'];
		$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
		echo '{"success":true}';
		exit;
	}	
	echo '{"success":false}';

	

?>