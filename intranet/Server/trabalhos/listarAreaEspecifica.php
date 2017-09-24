<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	if($_REQUEST['id_area']!='')
		$id_area = $_REQUEST['id_area'];
	else
		$id_area = 0;

	$queryString = "
		SELECT es_area_especifica.*
		FROM es_area_especifica
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_area_especifica.fgk_area
		WHERE es_area_especifica.fgk_area = $id_area
		ORDER BY es_area_especifica.descricao_area_especifica
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resultado),
		"resultado" => $resultado
	));
?>