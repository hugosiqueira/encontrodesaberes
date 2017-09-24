<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "SELECT * FROM es_area_especifica ORDER BY descricao_area_especifica ASC";
	$query = $db->sql_query2($queryString);
	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>