<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_estado = $_REQUEST['id_estado'];

	$queryString = "
		SELECT desk_cidades.*
		FROM desk_cidades
		LEFT JOIN desk_estados ON desk_estados.id_estado = desk_cidades.fgk_estado
		WHERE desk_cidades.fgk_estado = $id_estado
	";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND (descricao_cidade LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli,$queryString." ORDER BY desk_cidades.descricao_cidade ") or die(mysqli_error($mysqli));
	$cidades = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$cidades[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($cidades),
		"resultado" => $cidades
	));
?>