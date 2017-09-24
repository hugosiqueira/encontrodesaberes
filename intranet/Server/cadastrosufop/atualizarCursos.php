<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['curso'];
	$dados = json_decode($json);

	$id_curso			= $dados->id_curso;
	$fgk_departamento	= $dados->fgk_departamento;
	$fgk_area_especifica	= $dados->fgk_area_especifica;
	$codigo 			= $dados->codigo;
	$descricao_curso 	= $dados->descricao_curso;
	$modalidade 		= $dados->modalidade;
	
	$query = sprintf("
		UPDATE es_ufop_cursos
		SET fgk_departamento	= '%s',
			fgk_area_especifica	= %d,
			codigo 				= '%s',
			descricao_curso 	= '%s',
			modalidade			= '%s'			
		WHERE id_curso = %d",
			mysqli_real_escape_string($mysqli,$fgk_departamento),
			mysqli_real_escape_string($mysqli,$fgk_area_especifica),
			mysqli_real_escape_string($mysqli,$codigo),
			mysqli_real_escape_string($mysqli,$descricao_curso),
			mysqli_real_escape_string($mysqli,$modalidade),
			mysqli_real_escape_string($mysqli,$id_curso)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Curso atualizado com sucesso."
	));
?>