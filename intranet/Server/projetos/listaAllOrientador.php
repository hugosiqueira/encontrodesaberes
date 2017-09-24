<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryOrientadores= "SELECT nome, fgk_departamento, cpf FROM es_ufop_professores";

	$total = $db->sql_query($queryOrientadores);

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryOrientadores.=" WHERE (nome LIKE '%$filtro%') OR (fgk_departamento LIKE '%$filtro%') OR (cpf LIKE '%$filtro%')"; 
	}

	$queryOrientadores.=" ORDER BY es_ufop_professores.nome ASC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryOrientadores);

	$orientadores = array();
	foreach ($result as $orientador)
		$orientadores[] = $orientador;

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"orientadores" => $orientadores
	));
?>