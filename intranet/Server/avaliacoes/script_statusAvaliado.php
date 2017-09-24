<?php
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');

	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$filtros = array();
	$queryString = "
		SELECT es_trabalho_apresentacao.id,es_trabalho_apresentacao.fgk_trabalho, es_trabalho_apresentacao.status, es_trabalho.fgk_status
		FROM es_trabalho_apresentacao
			INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		WHERE es_trabalho.fgk_evento = ?
			AND es_trabalho_apresentacao.status = 2
	";
	$filtros[] = intval($id_evento_atual);

	$query = $db->sql_query2($queryString, $filtros);
	echo $query->rowCount()."<br>";
	foreach ($query as $res){
		echo $res->id." ".$res->status." ".$res->fgk_trabalho." ".$res->fgk_status."<br>";
		// $db->atualizar('es_trabalho', array('fgk_status'=>17), 'id', $res->fgk_trabalho);
	}

?>