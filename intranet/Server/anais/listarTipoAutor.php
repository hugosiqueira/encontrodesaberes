<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT es_tipo_autor.*
		FROM es_tipo_autor		
		ORDER BY es_tipo_autor.descricao_tipo
	";
	$query = $db->sql_query2($queryString);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;
		
	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>