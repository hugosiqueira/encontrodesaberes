<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$queryString = "
		SELECT es_avaliacao_revisor.*, es_inscritos.nome
		FROM es_avaliacao_revisor
		 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		 INNER JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_revisor = es_avaliacao_revisor.id
	
        GROUP BY es_avaliacao_revisor.id
        	ORDER BY es_inscritos.nome
	";
	// echo $queryString;
	$query = $db->sql_query2($queryString);

	$resultado = array();	
	foreach ($query as $res){
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>