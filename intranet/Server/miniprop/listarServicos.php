<?php
	header('Content-Type: application/json; charset=utf-8');
	// require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$filtros = array();
	$queryString = "
		SELECT es_servicos.*
		FROM es_servicos
		WHERE es_servicos.fgk_evento = ?
		ORDER BY es_servicos.descricao_servico
	";
	$filtros[] = intval($id_evento_atual);		
	
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $minicurso){
		$resultado[] = $minicurso;
	}

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>