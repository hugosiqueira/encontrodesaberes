<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();


	$json = $_POST['autores_trabalho'];
	$dados = json_decode($json);

	$fgk_instituicao 	= $dados->fgk_instituicao;
	$fgk_tipo_autor 	= $dados->fgk_tipo_autor;
	$fgk_trabalho 		= $dados->fgk_trabalho;
	$cpf 				= $dados->cpf;
	$email 				= $dados->email;
	$nome 				= $dados->nome;
	$bool_apresentador 	= $dados->bool_apresentador;
	
	$queryString = "SELECT id, nome FROM es_trabalho_autor WHERE cpf = '$cpf' AND fgk_trabalho = $fgk_trabalho;";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	$resposta = array();
	if (mysqli_num_rows($query) > 0){
		$registro = mysqli_fetch_assoc($query);
		$nome = $registro['nome'];
		echo json_encode(array(
			"success" => false,
			"msg"	=> "<b>$nome</b><br>já está vinculado neste trabalho."
		));
		exit;
	}
	else{
		$queryTotal = mysqli_query($mysqli,"SELECT count(*) as num FROM es_trabalho_autor WHERE fgk_trabalho = $fgk_trabalho") or die(mysql_error());
		$row = mysqli_fetch_assoc($queryTotal);
		$total = $row['num'];
		$ordenacao = $total++;
		
		$query = sprintf("
			INSERT INTO es_trabalho_autor
			(	fgk_instituicao, fgk_tipo_autor, fgk_trabalho, bool_apresentador, ordenacao, cpf, email, nome	)
			values
			(	%d, %d, %d, %d, %d, '%s', '%s', '%s')",
			mysqli_real_escape_string($mysqli,$fgk_instituicao),
			mysqli_real_escape_string($mysqli,$fgk_tipo_autor),
			mysqli_real_escape_string($mysqli,$fgk_trabalho),
			mysqli_real_escape_string($mysqli,$bool_apresentador),
			mysqli_real_escape_string($mysqli,$ordenacao),
			mysqli_real_escape_string($mysqli,$cpf),
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$nome)
			);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
		$id_trabalho = mysqli_insert_id($mysqli);

		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0		,
			"msg" => "Autor vinculado com sucesso."
		));
		
	}	
	
?>