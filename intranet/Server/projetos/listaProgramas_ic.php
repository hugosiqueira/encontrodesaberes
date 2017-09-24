<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT id, nome FROM es_programa_ic ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" WHERE (nome LIKE '%$filtro%') OR (sigla LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli, $queryString.=" ORDER BY sigla") or die(mysqli_error($mysqli));

	$programas = array();
	while($programa = mysqli_fetch_assoc($query))
		$programas[] = $programa;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"programas" => $programas
	));
?>