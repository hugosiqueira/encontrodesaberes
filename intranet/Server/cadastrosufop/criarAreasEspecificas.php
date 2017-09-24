<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
		
	$json = $_POST['areaespecifica'];
	$dados = json_decode($json);

	$fgk_area 					= $dados->fgk_area;
	$descricao_area_especifica 	= $dados->descricao_area_especifica;

	$query = sprintf("
		INSERT INTO es_area_especifica
		(	fgk_area, descricao_area_especifica	)
		values
		(	%d, '%s' )",
		mysqli_real_escape_string($mysqli,$fgk_area),
		mysqli_real_escape_string($mysqli,$descricao_area_especifica)
		);
	if(mysqli_query($mysqli, $query)){
		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0,
			"msg"	=> "Área específica registrada com sucesso."
		));
	}
	else{
		echo json_encode(array(
			"success" => false,
			"msg"	=> "Um erro ocorreu. Favor entrar em contato com o administrador do sistema."
		));
	}

	

	
	
	
?>