<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	function safeHexToString($input){
		if(strpos($input, '0x') === 0){
			$input = substr($input, 2);
		}
		return hex2bin($input);
	}
	
	$id_inscrito	= $_REQUEST['id_inscrito'];
	$cpf 			= $_REQUEST['cpf'];
	$password 		= $_REQUEST['password'];
	
	$password = trim(mcrypt_decrypt(MCRYPT_DES, "seic2015", safeHexToString($password), MCRYPT_MODE_ECB));	
	$salt = base64_encode($cpf);
	$password = crypt($password, $salt);
	
	$query = sprintf("
		UPDATE es_inscritos
		SET password = '%s'
		WHERE id = %d",
		mysqli_real_escape_string($mysqli,$password),
		mysqli_real_escape_string($mysqli,$id_inscrito)
	);
	if(mysqli_query($mysqli,$query) )
		$msg = "Password alterado com sucesso.";
	else 
		$msg = "Um erro ocorreu, favor entrar em contato com o admnistrador do sistema.";
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg" => $msg
	));
?>