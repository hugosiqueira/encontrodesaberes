<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$id_revisor = $_REQUEST['id_revisor'];
	$filtros = array();
	$queryString = "
		SELECT es_avaliacao_revisor_horarios.fgk_sessao
		FROM es_avaliacao_revisor_horarios
		 INNER JOIN es_sessao ON es_sessao.id = es_avaliacao_revisor_horarios.fgk_sessao
		WHERE es_avaliacao_revisor_horarios.fgk_revisor = ? AND es_sessao.fgk_evento = ?
	";
	$filtros[] = intval($id_revisor);
	$filtros[] = intval($id_evento_atual);
	$query = $db->sql_query2($queryString, $filtros);
	$sessoes = array();
	foreach ($query as $res)
		$sessoes[] = $res->fgk_sessao;

	$filtros = array();
	$queryString = "
		SELECT es_sessao.*
		FROM es_sessao
		WHERE es_sessao.fgk_evento = ?
		ORDER BY es_sessao.nome ASC
	";
	$filtros[] = intval($id_evento_atual);
	$query = $db->sql_query2($queryString, $filtros);
	$resultado = array();
	foreach ($query as $res){
		if(in_array($res->id, $sessoes))
			$res->check = true;
		else
			$res->check = false;
		$res->fgk_revisor = $id_revisor;
	    $resultado[] = $res;
	}


	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));





?>