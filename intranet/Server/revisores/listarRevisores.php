<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();
	// SUM(CASE WHEN (es_avaliacao_revisao.status < 2 OR es_avaliacao_revisao.status IS NULL ) THEN 1 ELSE 0 END) pendentes,
	$queryString = "
		SELECT
		 SUM(CASE WHEN (es_avaliacao.fgk_revisor1 = es_avaliacao_revisor.id OR es_avaliacao.fgk_revisor2 = es_avaliacao_revisor.id) THEN 1 ELSE 0 END) qtd_trabalhos,
		 SUM(CASE WHEN (es_avaliacao_revisao.status < 2 OR es_avaliacao_revisao.status IS NULL  ) THEN 1 ELSE 0 END) pendentes,
		es_avaliacao_revisor.*, es_inscritos.nome, es_inscritos.cpf, es_inscritos.email, es_inscritos_tipos.descricao_tipo, es_area_especifica.descricao_area_especifica, es_ufop_areas.codigo_area

		FROM es_avaliacao_revisor
		 LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		  LEFT JOIN es_inscritos_tipos ON  es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
		 LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_avaliacao_revisor.fgk_area
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_avaliacao_revisor.fgk_area_especifica

		 LEFT JOIN es_avaliacao ON (es_avaliacao.fgk_revisor1 = es_avaliacao_revisor.id) OR (es_avaliacao.fgk_revisor2 = es_avaliacao_revisor.id)
		 LEFT JOIN es_avaliacao_revisao ON (es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id) AND (es_avaliacao_revisao.fgk_revisor = es_avaliacao_revisor.id)
		 LEFT JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho

		WHERE  es_inscritos.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['pa'])){
		if($_REQUEST['com_trabalho']=='1'){
			$queryString.= " AND es_trabalho.id > 0 ";
		}
		if(isset($_REQUEST['nome'])&&($_REQUEST['nome']!='')){
			$nome = $_REQUEST['nome'];
			$queryString.= " AND es_inscritos.nome LIKE ?";
			$filtros[] = '%'.$nome.'%';
		}
		if(isset($_REQUEST['fgk_tipo'])&&($_REQUEST['fgk_tipo']!='')){
			$fgk_tipo = $_REQUEST['fgk_tipo'];
			$queryString.= " AND es_inscritos.fgk_tipo = ?";
			$filtros[] = $fgk_tipo;
		}
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_avaliacao_revisor.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
			$queryString.= " AND es_avaliacao_revisor.fgk_area_especifica = ?";
			$filtros[] = $fgk_area_especifica;

		}
		if($_REQUEST['bool_avaliador_prograd']!='-1'){
			$bool_avaliador_prograd = $_REQUEST['bool_avaliador_prograd'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_prograd = ?";
			$filtros[] = $bool_avaliador_prograd;
		}
		if($_REQUEST['bool_avaliador_proex']!='-1'){
			$bool_avaliador_proex = $_REQUEST['bool_avaliador_proex'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_proex = ?";
			$filtros[] = $bool_avaliador_proex;
		}
		if($_REQUEST['bool_avaliador_caint']!='-1'){
			$bool_avaliador_caint = $_REQUEST['bool_avaliador_caint'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_caint = ?";
			$filtros[] = $bool_avaliador_caint;
		}
	}
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_inscritos.nome LIKE ? OR
			es_ufop_areas.codigo_area LIKE ? OR
			es_area_especifica.descricao_area_especifica LIKE ? OR
			es_inscritos.cpf LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$queryString.=" GROUP BY es_avaliacao_revisor.id HAVING 1 ";
	if(isset($_REQUEST['pa'])){
		if($_REQUEST['com_trabalho']=='1'){
			$queryString.= " AND qtd_trabalhos > 0 ";
			if($_REQUEST['pendentes']=='1')
				$queryString.= " AND pendentes > 0 ";
			else if($_REQUEST['pendentes']=='2')
				$queryString.= " AND pendentes = 0 ";
		}
		else if($_REQUEST['com_trabalho']=='0'){
			$queryString.= " AND qtd_trabalhos = 0 ";
		}
	}
	$total = $db->sql_query2($queryString,$filtros);
	
	$queryString.=" ORDER BY es_inscritos.nome LIMIT ? , ?;";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);

	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $revisor)
		$resultado[] = $revisor;
	
	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>