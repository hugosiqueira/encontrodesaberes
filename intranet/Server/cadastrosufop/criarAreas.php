<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();


	$json = $_POST['area'];
	$dados = json_decode($json);

	$codigo_area 	= $dados->codigo_area;
	$descricao_area = $dados->descricao_area;

	$queryString = "SELECT id_area FROM es_ufop_areas WHERE codigo_area = '$codigo_area';";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	if (mysqli_num_rows($query) > 0){
		echo json_encode(array(
			"success" => false,
			"msg"	=> "Este código já está sendo usado por outra área."
		));
	}
	else{
		$query = sprintf("
			INSERT INTO es_ufop_areas
			(	codigo_area, descricao_area	)
			values
			(	'%s','%s'	)",
			mysqli_real_escape_string($mysqli,$codigo_area),
			mysqli_real_escape_string($mysqli,$descricao_area)
			);
		mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0,
			"msg"	=> "Área registrada com sucesso."
		));
	}



?>