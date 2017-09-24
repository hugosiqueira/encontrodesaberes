<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	// $json = $_POST['autores_trabalho'];
	// $dados = json_decode($json);

	// $id 	= $dados->id;
	// $fgk_instituicao 	= $dados->fgk_instituicao;
	// $fgk_tipo_autor 	= $dados->fgk_tipo_autor;
	// $cpf 				= $dados->cpf;
	// $email 				= $dados->email;
	// $nome 				= $dados->nome;
	// $bool_apresentador 	= $dados->bool_apresentador;
	$id = $_REQUEST['id'];
	$fgk_instituicao = $_REQUEST['fgk_instituicao'];
	$fgk_tipo_autor = $_REQUEST['fgk_tipo_autor'];
	$cpf = $_REQUEST['cpf'];
	$email = $_REQUEST['email'];
	$nome = $_REQUEST['nome'];
	$bool_apresentador = $_REQUEST['bool_apresentador'];

	$query = sprintf("
		UPDATE es_trabalho_autor
		SET fgk_instituicao		= %d,
			fgk_tipo_autor 		= %d,
			cpf					= '%s',
			email				= '%s',
			nome				= '%s',
			bool_apresentador	= %d
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$fgk_instituicao),
			mysqli_real_escape_string($mysqli,$fgk_tipo_autor),
			mysqli_real_escape_string($mysqli,$cpf),
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$bool_apresentador),
			mysqli_real_escape_string($mysqli,$id)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg" => "Registro alterado com sucesso."
	));
?>