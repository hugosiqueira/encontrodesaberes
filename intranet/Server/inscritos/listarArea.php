<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';	
	require_once('../../includes/db_connect.php');

	$queryString = "
		SELECT es_ufop_areas.*
		FROM es_ufop_areas		
		ORDER BY es_ufop_areas.descricao_area
	";
	$query = $db->sql_query2($queryString);
	$resultado = array();
	foreach ($query as $area){
		$resultado[] = $area;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>