<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_area = $_REQUEST['id_area'];
	$filtros = array();
	$queryString = "
		SELECT es_area_especifica.*
		FROM es_area_especifica
		WHERE fgk_area = ?
		ORDER BY es_area_especifica.descricao_area_especifica
	";
	$filtros[] = $id_area;
	$query = $db->sql_query2($queryString,$filtros);

	$resultado = array();
	$gamb = new StdClass;
	$gamb->id = "0";	$gamb->fgk_area = "0";	$gamb->descricao_area_especifica = "-- TODAS --"; 
	$resultado[] = $gamb;
	foreach ($query as $res){
		$resultado[] = $res;
	}
	
	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>