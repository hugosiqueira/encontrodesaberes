<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['departamento'];
	$dados = json_decode($json);

	$id_departamento	= $dados->id_departamento;
	$fgk_area 			= $dados->fgk_area;
	$nome_departamento 	= $dados->nome_departamento;
	
	$query = sprintf("
		UPDATE es_ufop_departamentos
		SET fgk_area			= %d,
			nome_departamento	= '%s'
		WHERE id_departamento = '%s'",
			mysqli_real_escape_string($mysqli,$fgk_area),
			mysqli_real_escape_string($mysqli,$nome_departamento),
			mysqli_real_escape_string($mysqli,$id_departamento)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Departamento atualizado com sucesso."
	));
?>