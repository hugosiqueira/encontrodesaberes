<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_professor 		= $_REQUEST['id_professor'];
	$cod_siape 			= $_REQUEST['cod_siape'];
	$nome 				= $_REQUEST['nome'];
	$fgk_tipo 			= $_REQUEST['fgk_tipo'];
	$fgk_departamento 	= $_REQUEST['fgk_departamento'];
	$email 				= $_REQUEST['email'];
	$cpf 				= $_REQUEST['cpf'];
	$cursos 			= $_REQUEST['cursos'];
	$bool_monitoria 			= $_REQUEST['bool_monitoria'];
	if(isset($_REQUEST['bool_avaliador']))
		$bool_avaliador = 1;	
	else
		$bool_avaliador = 0;
	if(isset($_REQUEST['bool_coordenador']))
		$bool_coordenador = 1;	
	else
		$bool_coordenador = 0;
	

	$query = sprintf("
		UPDATE es_ufop_professores
		SET cod_siape			= '%s',
			nome 				= '%s',
			fgk_tipo 			= %d,
			fgk_departamento	= '%s',
			email				= '%s',
			cpf					= '%s',
			bool_avaliador		= %d,
			cursos				= '%s',
			bool_coordenador	= %d,
			bool_monitoria	= %d
		WHERE id_professor = %d",
			mysqli_real_escape_string($mysqli,$cod_siape),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$fgk_tipo),
			mysqli_real_escape_string($mysqli,$fgk_departamento),
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$cpf),
			mysqli_real_escape_string($mysqli,$bool_avaliador),
			mysqli_real_escape_string($mysqli,$cursos),
			mysqli_real_escape_string($mysqli,$bool_coordenador),
			mysqli_real_escape_string($mysqli,$bool_monitoria),
			mysqli_real_escape_string($mysqli,$id_professor)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Professor/TA atualizado com sucesso."
	));
?>