<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$cpf = $_POST['cpf']; 	
	$queryString = "SELECT nome, email FROM es_ufop_professores WHERE cpf = '$cpf';";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	$resposta = array();
	if (mysqli_num_rows($query) > 0){
		$registro = mysqli_fetch_assoc($query);
		$nome = $registro['nome'];
		$email = $registro['email'];
		$fgk_instituicao = 1;
		$fgk_tipo_autor =2;
	}
	else{
		$queryString = "SELECT nome, email FROM es_ufop_alunos WHERE cpf = '$cpf';";
		$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
		if (mysqli_num_rows($query) > 0){
			$registro = mysqli_fetch_assoc($query);
			$nome = $registro['nome'];
			$email = $registro['email'];
			$fgk_instituicao = 1;
			$fgk_tipo_autor = 1;
		}
		else{
			echo json_encode(array(
				"success" => false
			));
			exit;
		}
	}	

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"nome" => $nome,
		"email" => $email,
		"fgk_instituicao" => $fgk_instituicao,
		"fgk_tipo_autor" => $fgk_tipo_autor
	));
?>