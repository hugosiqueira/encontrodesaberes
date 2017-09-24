<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$queryString = "SELECT id, nome, sigla FROM es_orgao_fomento ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" WHERE (nome LIKE '%$filtro%') OR (sigla LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli, $queryString.=" ORDER BY nome") or die(mysqli_error($mysqli));

	$orgaos = array();
	while($orgao = mysqli_fetch_assoc($query))
		$orgaos[] = $orgao;

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"orgaos" => $orgaos
	));
?>