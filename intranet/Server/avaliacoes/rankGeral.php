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
		SELECT es_trabalho.titulo_enviado, es_ufop_areas.codigo_area, es_ufop_areas.descricao_area, es_trabalho_apresentacao.*, es_avaliacao.id AS id_avaliacao, es_instituicao.nome AS nome_instituicao, es_instituicao.sigla AS sigla_instituicao
		,(((5*es_avaliacao.nota)+(nota_a+nota_b+nota_c+nota_d+nota_e))/10) AS nota_geral, nota_a, nota_b, nota_c, nota_d, nota_e, es_avaliacao.nota AS nota_avaliacao, (5*es_avaliacao.nota) AS nota_avaliacao_final
		FROM es_trabalho_apresentacao
		 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		  LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho.fgk_instituicao
		  INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 LEFT JOIN es_avaliacao ON es_avaliacao.fgk_trabalho = es_trabalho_apresentacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
		WHERE es_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.titulo_enviado LIKE ? OR
			es_ufop_areas.descricao_area LIKE ? OR
			es_ufop_areas.codigo_area LIKE ? OR
			es_instituicao.nome LIKE ? OR
			es_instituicao.sigla LIKE ? OR
			es_trabalho_apresentacao.cod_poster LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString, $filtros);
	$queryString.=" ORDER BY nota_geral DESC LIMIT ? , ? ;";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);

	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $res){
		$tooltip = "
			<table>
			<tr>
				<td>Parecer final:</td>
				<td>".$res->nota_avaliacao_final."</td>
			</tr>
			<tr>
				<td>Avaliação A:</td>
				<td>".number_format((float)$res->nota_a, 2, '.', '')."</td>
			</tr>
			<tr>
				<td>Avaliação B:</td>
				<td>".number_format((float)$res->nota_b, 2, '.', '')."</td>
			</tr>
			<tr>
				<td>Avaliação C:</td>
				<td>".number_format((float)$res->nota_c, 2, '.', '')."</td>
			</tr>
			<tr>
				<td>Avaliação D:</td>
				<td>".number_format((float)$res->nota_d, 2, '.', '')."</td>
			</tr>
			<tr>
				<td>Avaliação E:</td>
				<td>".number_format((float)$res->nota_e, 2, '.', '')."</td>
			</tr>
			<tr>
				<td>Total:</td>
				<td>".number_format((float)$res->nota_geral, 2, '.', '')."</td>
			</tr>
		";
		$res->tooltip = $tooltip;
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount()
		,"resultado" => $resultado
	));
?>