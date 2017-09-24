<?php

set_time_limit(0);
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$filtros = array();

	$queryString = "
		SELECT es_comunicacao_email.*
		FROM es_comunicacao_email
		WHERE es_comunicacao_email.fgk_evento = ?
	";
	$filtros[] = $id_evento_atual;

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			nome_destinatario LIKE ? OR
			email_destinatario LIKE ? OR
			categoria LIKE ? OR
			cpf_destinatario LIKE ?
		)";
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString,$filtros);
	$queryString.="ORDER BY datahora_envio DESC LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $email){
		$resultado[] = $email;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>