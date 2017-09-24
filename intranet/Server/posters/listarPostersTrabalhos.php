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
		SELECT es_trabalho.*, es_ufop_areas.id_area, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_orgao_fomento.sigla AS sigla_orgao, es_orgao_fomento.nome AS nome_orgao, es_trabalho_apresentacao.cod_poster, es_trabalho_apresentacao.id AS id_apresentacao, es_inscritos.nome AS avaliador, es_sessao.nome AS nome_sessao, es_area_especifica.descricao_area_especifica
		FROM es_trabalho 
			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			
			LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_trabalho = es_trabalho.id
			LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
			LEFT JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
			LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		WHERE es_trabalho.fgk_evento = ? AND es_trabalho.fgk_tipo_apresentacao = 1 AND (es_trabalho.fgk_status = 6 OR es_trabalho.fgk_status = 14)
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.titulo_enviado LIKE ? OR
			es_trabalho.palavras_chave LIKE ? OR
			es_orgao_fomento.sigla LIKE ? OR
			es_inscritos.nome LIKE ? OR
			es_trabalho_apresentacao.cod_poster LIKE ? OR
			es_trabalho.resumo_enviado LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
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
		if(isset($_REQUEST['bool_alocado'])&&($_REQUEST['bool_alocado']!='')){
			$bool_alocado = $_REQUEST['bool_alocado'];
			if($bool_alocado == "1")
				$queryString.= " AND es_trabalho_apresentacao.id > 0";
			else if($bool_alocado == "0")
				$queryString.= " AND es_trabalho_apresentacao.id IS NULL";
		}
	}
	$total = $db->sql_query2($queryString, $filtros);
	$queryString.=" ORDER BY es_ufop_areas.descricao_area, es_trabalho.titulo_enviado ASC LIMIT ? , ? ;";
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