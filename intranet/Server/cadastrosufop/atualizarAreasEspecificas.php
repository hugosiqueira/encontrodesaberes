<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['areaespecifica'];
	$dados = json_decode($json);

	$id							= $dados->id;
	$fgk_area 					= $dados->fgk_area;
	$descricao_area_especifica 	= $dados->descricao_area_especifica;
	
	$query = sprintf("
		UPDATE es_area_especifica
		SET fgk_area			= %d,
			descricao_area_especifica	= '%s'
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$fgk_area),
			mysqli_real_escape_string($mysqli,$descricao_area_especifica),
			mysqli_real_escape_string($mysqli,$id)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Área específica atualizada com sucesso."
	));
?>