<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_aluno 				= $_REQUEST['id_aluno'];
	$cpf 					= $_REQUEST['cpf'];
	$matricula 				= $_REQUEST['matricula'];	
	$nome 					= $_REQUEST['nome'];
	$email 					= $_REQUEST['email'];
	$fgk_curso 				= $_REQUEST['fgk_curso'];	
	$bool_monitoria 		= $_REQUEST['bool_monitoria'];	
	
	if(isset($_REQUEST['bool_pos']))
		$bool_pos = 1;
	else
		$bool_pos = 0;
	
	if(isset($_REQUEST['mobilidade_ano_passado']))
		$mobilidade_ano_passado = 1;
	else
		$mobilidade_ano_passado = 0;
	
	if(isset($_REQUEST['mobilidade_ano_atual']))
		$mobilidade_ano_atual = 1;
	else
		$mobilidade_ano_atual = 0;


	$query = sprintf("
		UPDATE es_ufop_alunos
		SET cpf						= '%s',
			matricula 				= '%s',
			bool_pos 				= %d,
			nome					= '%s',
			email					= '%s',
			fgk_curso				= '%s',
			mobilidade_ano_passado	= %d,
			bool_monitoria	= %d,
			mobilidade_ano_atual	= %d
		WHERE id_aluno = %d",
			mysqli_real_escape_string($mysqli,$cpf),
			mysqli_real_escape_string($mysqli,$matricula),
			mysqli_real_escape_string($mysqli,$bool_pos),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$fgk_curso),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_passado),
			mysqli_real_escape_string($mysqli,$bool_monitoria),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_atual),
			mysqli_real_escape_string($mysqli,$id_aluno)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Aluno atualizado com sucesso."
	));
?>