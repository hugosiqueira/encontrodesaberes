<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	// $id_evento_atual = $_SESSION['id_evento_atual'];
	$queryString = "
		SELECT es_inscritos_tipos.*
		FROM es_inscritos_tipos
		WHERE 1
	";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND (descricao_tipo LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli,$queryString." ORDER BY descricao_tipo") or die(mysqli_error($mysqli));
	$tipos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$tipos[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($tipos),
		"resultado" => $tipos
	));
?>