<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");	
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$queryString = "
		SELECT es_instituicao.*
		FROM es_instituicao		
		ORDER BY es_instituicao.ordem DESC, es_instituicao.sigla
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