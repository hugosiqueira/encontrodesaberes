<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_areas.descricao_area LIKE '%$buscaRapida%' OR
			es_ufop_departamentos.nome_departamento LIKE '%$buscaRapida%' OR
			es_ufop_departamentos.id_departamento LIKE '%$buscaRapida%'
		)";
	}
	$queryString = "
		SELECT *
		FROM es_ufop_departamentos
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_ufop_departamentos.fgk_area
		WHERE
		 $filtro
		ORDER BY nome_departamento ASC
		LIMIT $start, $limit
	";
	$queryTotal = "SELECT count(*) as num
		FROM es_ufop_departamentos
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_ufop_departamentos.fgk_area
		WHERE
		 $filtro
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	$queryTotal = mysqli_query($mysqli,$queryTotal) or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resultado
	));
?>