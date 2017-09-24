<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$cod_siape 			= $_REQUEST['cod_siape'];
	$nome 				= $_REQUEST['nome'];
	$fgk_tipo 			= $_REQUEST['fgk_tipo'];
	$fgk_departamento 	= $_REQUEST['fgk_departamento'];
	$email 				= $_REQUEST['email'];
	$cpf 				= $_REQUEST['cpf'];
	$bool_avaliador 	= $_REQUEST['bool_avaliador'];
	$cursos 			= $_REQUEST['cursos'];
	$bool_coordenador 	= $_REQUEST['bool_coordenador'];
	$bool_monitoria 	= $_REQUEST['bool_monitoria'];

	$query = sprintf("
		INSERT INTO es_ufop_professores
		(	cod_siape, nome, fgk_tipo, fgk_departamento, email, cpf	, cursos, bool_avaliador, bool_coordenador, bool_monitoria	)
		values
		(	'%s', '%s', %d, '%s', '%s', '%s', '%s', %d, %d	, %d	)",
		mysqli_real_escape_string($mysqli,$cod_siape),
		mysqli_real_escape_string($mysqli,$nome),
		mysqli_real_escape_string($mysqli,$fgk_tipo),
		mysqli_real_escape_string($mysqli,$fgk_departamento),
		mysqli_real_escape_string($mysqli,$email),
		mysqli_real_escape_string($mysqli,$cpf),
		mysqli_real_escape_string($mysqli,$cursos),
		mysqli_real_escape_string($mysqli,$bool_avaliador),
		mysqli_real_escape_string($mysqli,$bool_coordenador),
		mysqli_real_escape_string($mysqli,$bool_monitoria)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Professor/TA registrado com sucesso."
	));
?>