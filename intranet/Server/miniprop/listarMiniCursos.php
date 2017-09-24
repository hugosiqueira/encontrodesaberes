<?php
	header('Content-Type: application/json; charset=utf-8');
	// require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$filtros = array();
	$queryString = "
		SELECT es_minicursos.*
		FROM es_minicursos
		WHERE es_minicursos.fgk_evento = ?
		ORDER BY es_minicursos.titulo
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