<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	
	$queryString = "
		SELECT es_avaliacao_revisor.*, es_inscritos.nome
		FROM es_avaliacao_revisor
		 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		WHERE es_inscritos.fgk_evento = ?
		ORDER BY es_inscritos.nome
	";
	$query = $db->sql_query2($queryString, array($id_evento_atual));

	$resultado = array();
	foreach ($query as $res){
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>