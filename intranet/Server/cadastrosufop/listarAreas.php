<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_areas.codigo_area LIKE '%$buscaRapida%' OR
			es_ufop_areas.descricao_area LIKE '%$buscaRapida%' 
		)";
	}
	
	$queryString = "
		SELECT *
		FROM es_ufop_areas
		WHERE  $filtro
		ORDER BY descricao_area ASC
		LIMIT $start, $limit
	";	
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	$queryTotal = "SELECT count(*) as num
		FROM es_ufop_areas
		WHERE  $filtro
		ORDER BY descricao_area ASC
	";
	$queryTotal = mysqli_query($mysqli,$queryTotal) or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resultado
	));
?>