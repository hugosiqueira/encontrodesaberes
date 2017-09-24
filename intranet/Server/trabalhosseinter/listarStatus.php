<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT es_trabalho_status.*
		FROM es_trabalho_status		
		ORDER BY es_trabalho_status.descricao_status
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