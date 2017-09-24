<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();
	$queryString = "
		SELECT es_anais_trabalho.*, es_area_especifica.descricao_area_especifica
		FROM es_anais_trabalho
		 INNER JOIN es_area_especifica ON es_area_especifica.id = es_anais_trabalho.fgk_area_especifica
		WHERE es_anais_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_area_especifica.descricao_area_especifica LIKE ? OR
			es_anais_trabalho.resumo LIKE ? OR
			es_anais_trabalho.titulo LIKE ? OR
			es_anais_trabalho.palavras_chave LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}

	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$queryString.= " AND es_anais_trabalho.fgk_area_especifica = ?";
			$filtros[] = $_REQUEST['fgk_area_especifica'];
		}
		if(isset($_REQUEST['bool_premiado'])&&($_REQUEST['bool_premiado']!='-1')){
			if($_REQUEST['bool_premiado']=="0")
				$queryString.= " AND es_anais_trabalho.bool_premiado = 0";
			else
				$queryString.= " AND es_anais_trabalho.bool_premiado = 1";
		}
	}
	$total = $db->sql_query2($queryString, $filtros)->rowCount();
	$queryString.=" ORDER BY es_anais_trabalho.datahora_registro DESC LIMIT ? , ? ;";
	// echo $queryString;
	array_push($filtros,intval($start),intval($limit));
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"total" => $total,
		"resultado" => $resultado
	));
?>