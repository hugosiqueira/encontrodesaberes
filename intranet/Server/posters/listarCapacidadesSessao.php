<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_sessao = $_REQUEST['id_sessao'];

	$queryString = "
		SELECT es_sessao_capacidade.*, es_sessao_capacidade.id AS id_sessao_capacidade, es_ufop_areas.*
		FROM es_sessao_capacidade
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_sessao_capacidade.fgk_area
		WHERE es_sessao_capacidade.fgk_sessao = ?
		ORDER BY es_ufop_areas.descricao_area
	";
	$filtros[] = intval($id_sessao);

	$query = $db->sql_query2($queryString,$filtros);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>