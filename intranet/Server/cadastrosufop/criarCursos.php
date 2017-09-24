<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
		
	$json = $_POST['curso'];
	$dados = json_decode($json);

	$fgk_departamento	= $dados->fgk_departamento;
	$fgk_area_especifica	= $dados->fgk_area_especifica;
	$codigo 			= $dados->codigo;
	$descricao_curso 	= $dados->descricao_curso;
	$modalidade 		= $dados->modalidade;

	$query = sprintf("
		INSERT INTO es_ufop_cursos
		(	fgk_departamento,fgk_area_especifica, codigo, descricao_curso, modalidade	)
		values
		(	'%s',%d,'%s','%s','%s'	)",
		mysqli_real_escape_string($mysqli,$fgk_departamento),
		mysqli_real_escape_string($mysqli,$fgk_area_especifica),
		mysqli_real_escape_string($mysqli,$codigo),
		mysqli_real_escape_string($mysqli,$descricao_curso),
		mysqli_real_escape_string($mysqli,$modalidade)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Curso registrado com sucesso."
	));
?>