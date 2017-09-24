<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['area'];
	$dados = json_decode($json);

	$id_area	= $dados->id_area;
	$codigo_area 	= $dados->codigo_area;
	$descricao_area = $dados->descricao_area;
	
	$query = sprintf("
		UPDATE es_ufop_areas
		SET descricao_area	= '%s'
		WHERE id_area = %d",
			mysqli_real_escape_string($mysqli,$descricao_area),
			mysqli_real_escape_string($mysqli,$id_area)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Área atualizada com sucesso."
	));
?>