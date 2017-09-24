<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$filtros = array();

	$queryString = "
		SELECT es_certificados_tipos.*
		FROM es_certificados_tipos
		WHERE es_certificados_tipos.fgk_evento = ?
		ORDER BY descricao_certificado
	";
	$filtros[] = intval($id_evento_atual);

	$total = $db->sql_query2($queryString,$filtros);
	

	$resultado = array();
	foreach ($total as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>