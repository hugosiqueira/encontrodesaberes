<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	if(isset($_REQUEST['area']))
		$codigoArea = $_REQUEST['area'];
	else
		$codigoArea = true;

	$queryString = "SELECT * FROM es_area_especifica WHERE fgk_area = $codigoArea";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND (descricao_area_especifica LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli, $queryString.=' ORDER BY descricao_area_especifica') or die(mysqli_error($mysqli));

	$cursos = array();
	while($curso = mysqli_fetch_assoc($query))
		$cursos[] = $curso;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"cursos" => $cursos
	));
?>