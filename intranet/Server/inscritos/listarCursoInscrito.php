<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_departamento = $_REQUEST['id_departamento'];

	$queryString = "
		SELECT es_ufop_cursos.*
		FROM es_ufop_cursos
		 INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_cursos.fgk_departamento
		WHERE es_ufop_departamentos.id_departamento = '$id_departamento'
		ORDER BY es_ufop_cursos.descricao_curso, es_ufop_cursos.modalidade 
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$cursos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['rend_curso'] = $registro['descricao_curso'] . " - " . $registro['modalidade'];
		$cursos[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($cursos),
		"resultado" => $cursos
	));
?>