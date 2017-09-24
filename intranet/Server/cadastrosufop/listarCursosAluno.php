<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT *
		FROM es_ufop_cursos
		ORDER BY descricao_curso ASC, modalidade ASC
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['rend_curso'] = $registro['descricao_curso'] ." - ". $registro['modalidade'];		
		$resultado[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resultado),
		"resultado" => $resultado
	));
?>