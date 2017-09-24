<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	sec_session_start();

	$queryString = "
		SELECT es_orgao_fomento.*
		FROM es_orgao_fomento	
		ORDER BY es_orgao_fomento.nome
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resultado),
		"resultado" => $resultado
	));
?>