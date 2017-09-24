<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$fgk_evento = $_SESSION['id_evento_atual'];
	
	$queryString = "
		SELECT es_sessao.*
		FROM es_sessao
		WHERE es_sessao.fgk_evento = ?
		ORDER BY es_sessao.nome
	";
	$query = $db->sql_query2($queryString,array($fgk_evento));

	$resultado = array();	
	foreach ($query as $res){
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>