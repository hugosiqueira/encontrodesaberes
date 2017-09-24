<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_revisor	= $_REQUEST['id_revisor'];
	$id_area	= $_REQUEST['id_area'];
	
	$filtros = array();
	$queryString = "
		SELECT 
		 SUM(CASE WHEN (es_trabalho_apresentacao.id IS NOT NULL AND es_trabalho.fgk_area = ?) THEN 1 ELSE 0 END) total,
		 es_sessao.id, es_sessao.nome, es_sessao_capacidade.capacidade, es_sessao_capacidade.fgk_area
		FROM  es_avaliacao_revisor_horarios
		 INNER JOIN es_sessao ON es_sessao.id = es_avaliacao_revisor_horarios.fgk_sessao
		  INNER JOIN es_sessao_capacidade ON es_sessao_capacidade.fgk_sessao = es_sessao.id
		  LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_sessao= es_sessao.id
		  LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		WHERE es_sessao.fgk_evento = ? 
		 AND es_avaliacao_revisor_horarios.fgk_revisor = ?
		 AND es_sessao_capacidade.fgk_area = ?
		GROUP BY es_sessao.id
		ORDER BY es_sessao.nome
	";
	$filtros[] = $id_area;
	$filtros[] = $id_evento_atual;
	$filtros[] = $id_revisor;
	$filtros[] = $id_area;
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