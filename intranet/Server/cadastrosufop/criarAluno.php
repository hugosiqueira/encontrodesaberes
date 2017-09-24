<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$cpf 					= $_REQUEST['cpf'];
	$matricula 				= $_REQUEST['matricula'];
	$bool_pos 				= $_REQUEST['bool_pos'];
	$nome 					= $_REQUEST['nome'];
	$email 					= $_REQUEST['email'];
	$fgk_curso 				= $_REQUEST['fgk_curso'];
	$bool_monitoria = $_REQUEST['bool_monitoria'];
	$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
	$mobilidade_ano_atual 	= $_REQUEST['mobilidade_ano_atual'];

	$query = sprintf("
		INSERT INTO es_ufop_alunos
		(	cpf, matricula, bool_pos, nome, email, fgk_curso, mobilidade_ano_passado, mobilidade_ano_atual, bool_monitoria	)
		values
		(	'%s', '%s', %d, '%s', '%s', '%s', %d , %d, %d 	)",
		mysqli_real_escape_string($mysqli,$cpf),
		mysqli_real_escape_string($mysqli,$matricula),
		mysqli_real_escape_string($mysqli,$bool_pos),
		mysqli_real_escape_string($mysqli,$nome),
		mysqli_real_escape_string($mysqli,$email),
		mysqli_real_escape_string($mysqli,$fgk_curso),
		mysqli_real_escape_string($mysqli,$mobilidade_ano_passado),
		mysqli_real_escape_string($mysqli,$mobilidade_ano_atual),
		mysqli_real_escape_string($mysqli,$bool_monitoria)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Aluno registrado com sucesso."
	));
?>