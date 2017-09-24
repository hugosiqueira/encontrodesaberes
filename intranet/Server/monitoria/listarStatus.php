<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';	
	require_once '../../includes/db_connect.php';	

	$queryString = "
		SELECT *
		FROM es_trabalho_status		
		ORDER BY descricao_statu
	";
	$query = $db->sql_query($queryString);
	$resultado = array();
	foreach ($query as $status){
		$resultado[] = $status;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>