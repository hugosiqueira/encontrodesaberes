<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$cpf = $_POST['cpf'];
	$queryString = "SELECT * FROM es_ufop_alunos WHERE cpf = '$cpf';";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	$resposta = array();
	if (mysqli_num_rows($query) > 0){
		$registro = mysqli_fetch_assoc($query);
		$id_aluno 				= $registro['id_aluno'];
		$matricula 				= $registro['matricula'];
		$nome 					= $registro['nome'];
		$email 					= $registro['email'];
		$cpf 					= $registro['cpf'];
		$fgk_curso 				= $registro['fgk_curso'];
		$bool_pos 				= $registro['bool_pos'];
		$mobilidade_ano_passado = $registro['mobilidade_ano_passado'];
		$mobilidade_ano_atual	= $registro['mobilidade_ano_atual'];
		$bool_monitoria			= $registro['bool_monitoria'];

		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0,
			"id_aluno" => $id_aluno,
			"matricula" => $matricula,
			"nome" => $nome,
			"email" => $email,
			"cpf" => $cpf,
			"fgk_curso" => $fgk_curso,
			"bool_pos" => $bool_pos,
			"mobilidade_ano_passado" => $mobilidade_ano_passado,
			"mobilidade_ano_atual" => $mobilidade_ano_atual,
			"bool_monitoria" => $bool_monitoria
		));
	}
	else{
		echo json_encode(array(
			"success" => false
		));
	}
?>