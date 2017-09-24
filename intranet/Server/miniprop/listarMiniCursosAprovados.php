<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$filtros = array();
	$queryString = "
		SELECT *
		FROM es_minicursos
		WHERE es_minicursos.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_minicursos.apresentador LIKE ? OR
			es_minicursos.titulo LIKE ? OR
			es_minicursos.resumo LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString,$filtros);
	
	$queryString.="ORDER BY es_minicursos.datahora_registro DESC LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $minicurso){
		$resultado[] = $minicurso;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>