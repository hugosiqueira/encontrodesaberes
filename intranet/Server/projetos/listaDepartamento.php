<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT * FROM es_ufop_departamentos ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" WHERE (nome_departamento LIKE '%$filtro%') OR (id_departamento LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli, $queryString." ORDER BY nome_departamento") or die(mysqli_error($mysqli));

	$departamentos = array();
	while($departamento = mysqli_fetch_assoc($query))
		$departamentos[] = $departamento;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"departamentos" => $departamentos
	));
?>