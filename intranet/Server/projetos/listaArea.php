<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT * FROM es_ufop_areas ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" WHERE (descricao_area LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli, $queryString.=" ORDER BY descricao_area") or die(mysqli_error($mysqli));

	$areas = array();
	while($area = mysqli_fetch_assoc($query))
		$areas[] = $area;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"areas" => $areas
	));
?>