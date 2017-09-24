<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';	
	require_once('../../includes/db_connect.php');

	if(isset($_REQUEST['id_area']))
		$id_area = $_REQUEST['id_area'];
	else
		$id_area = 0;
	$queryString = "
		SELECT es_area_especifica.*
		FROM es_area_especifica
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_area_especifica.fgk_area
		WHERE es_area_especifica.fgk_area = ?
		ORDER BY es_area_especifica.descricao_area_especifica
	";
	echo $queryString;
	$query = $db->sql_query($queryString, array('fgk_area'=> $id_area));
	$resultado = array();
	foreach ($query as $area_especifica){
		$resultado[] = $area_especifica;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>