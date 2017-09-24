<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';	
	require_once('../../includes/db_connect.php');

	$queryString = "
		SELECT es_inscritos_tipos.*
		FROM es_inscritos_tipos		
		ORDER BY es_inscritos_tipos.descricao_tipo
	";
	$query = $db->sql_query2($queryString);
	$resultado = array();
	foreach ($query as $tipo){
		$resultado[] = $tipo;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>