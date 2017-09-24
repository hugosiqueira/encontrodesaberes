<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();
	// INNER JOIN es_sessao_capacidade ON es_sessao_capacidade.fgk_sessao = es_sessao.id
	// INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_sessao_capacidade.fgk_area
	$queryString = "
		SELECT es_sessao.*
		FROM es_sessao
		WHERE es_sessao.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_sessao.sessao LIKE ? OR
			es_sessao.nome LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}

	$total = $db->sql_query2($queryString, $filtros);
	$queryString.=" ORDER BY es_sessao.nome ASC LIMIT ? , ? ;";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);

	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>