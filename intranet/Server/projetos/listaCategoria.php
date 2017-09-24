<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT id_categoria, sigla_categoria FROM es_categorias;";

	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));

	$categorias = array();
	while($categoria = mysqli_fetch_assoc($query))
		$categorias[] = $categoria;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"categorias" => $categorias
	));
?>