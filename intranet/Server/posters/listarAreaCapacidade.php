<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();


	$queryString = "
		SELECT  es_ufop_areas.*
		FROM es_ufop_areas
		
		WHERE 1
		ORDER BY es_ufop_areas.descricao_area
	";
		$query = $db->sql_query2($queryString);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>