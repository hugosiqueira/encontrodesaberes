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
		SELECT es_trabalho.titulo_enviado, es_trabalho.resumo_enviado, es_inscritos.nome AS nome_avaliador, es_sessao.nome AS nome_sessao, es_ufop_areas.codigo_area, es_ufop_areas.descricao_area, es_trabalho_apresentacao.*
		FROM es_trabalho_apresentacao
		 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		  INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 INNER JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
		  INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		 INNER JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
		WHERE es_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.titulo_enviado LIKE ? OR
			es_trabalho.palavras_chave LIKE ? OR
			es_inscritos.nome LIKE ? OR
			es_trabalho_apresentacao.cod_poster LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	
	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_trabalho.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_revisor'])&&($_REQUEST['fgk_revisor']!='')){
			$fgk_revisor = $_REQUEST['fgk_revisor'];
			$queryString.= " AND es_avaliacao_revisor.id = ?";
			$filtros[] = $fgk_revisor;
		}
		if(isset($_REQUEST['fgk_sessao'])&&($_REQUEST['fgk_sessao']!='')){
			$fgk_sessao = $_REQUEST['fgk_sessao'];
			$queryString.= " AND es_sessao.id = ?";
			$filtros[] = $fgk_sessao;
		}
		if(isset($_REQUEST['status'])&&($_REQUEST['status']!='')){
			$status = $_REQUEST['status'];
			if($status == "1")
				$queryString.= " AND es_trabalho_apresentacao.status = 1";
			else if($status == "0")
				$queryString.= " AND es_trabalho_apresentacao.status = 0";
			else if($status == "2")
				$queryString.= " AND es_trabalho_apresentacao.status = 2";
		}
	}

	$total = $db->sql_query2($queryString, $filtros);
	$queryString.=" ORDER BY es_ufop_areas.codigo_area, es_sessao.nome, es_inscritos.nome LIMIT ? , ? ;";
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