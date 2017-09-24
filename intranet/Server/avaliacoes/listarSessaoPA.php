<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$queryString = "
		SELECT es_sessao.*
		FROM es_sessao
		ORDER BY es_sessao.nome
	";
	$query = $db->sql_query2($queryString);

	$resultado = array();	
	foreach ($query as $res){
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>