<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT *
		FROM es_ufop_departamentos
		ORDER BY nome_departamento
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$departamentos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$departamentos[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($departamentos),
		"resultado" => $departamentos
	));
?>