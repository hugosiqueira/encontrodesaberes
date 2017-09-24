<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
		
	$json = $_POST['departamento'];
	$dados = json_decode($json);

	$id_departamento	= $dados->id_departamento;
	$fgk_area 			= $dados->fgk_area;
	$nome_departamento 	= $dados->nome_departamento;
	
	$queryString = "SELECT id_departamento FROM es_ufop_departamentos WHERE id_departamento = '$id_departamento';";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	if (mysqli_num_rows($query) > 0){
		echo json_encode(array(
			"success" => false,
			"msg"	=> "Este código já está sendo usado para outro departamento."
		));
	}
	else{
		$query = sprintf("
			INSERT INTO es_ufop_departamentos
			(	id_departamento, fgk_area, nome_departamento	)
			values
			(	'%s',%d,'%s'	)",
			mysqli_real_escape_string($mysqli,$id_departamento),
			mysqli_real_escape_string($mysqli,$fgk_area),
			mysqli_real_escape_string($mysqli,$nome_departamento)
			);
		mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0,
			"msg"	=> "Departamento registrado com sucesso."
		));
	}
	
	
	
?>