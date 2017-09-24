<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT * FROM es_instituicao ORDER BY ordem DESC, sigla ASC ";

	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));

	$inst = array();
	while($registro = mysqli_fetch_assoc($query))
		$inst[] = $registro;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $inst
	));
?>