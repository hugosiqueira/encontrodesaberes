<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_apresentacao = $_REQUEST['cod_barras'];

	$queryString = "
		SELECT es_trabalho.titulo_enviado, es_trabalho.resumo_enviado, es_inscritos.nome AS nome_avaliador, es_sessao.nome AS nome_sessao, es_ufop_areas.codigo_area, es_ufop_areas.descricao_area, es_trabalho_apresentacao.*
		FROM es_trabalho_apresentacao
		 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		  INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 INNER JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
		  INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		 INNER JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
		WHERE es_trabalho_apresentacao.id = ?
	";
	$filtros[] = intval($id_apresentacao);

	$query = $db->sql_query2($queryString, $filtros);
	foreach ($query as $res){
		echo json_encode(array(
			"success" => true,
			"id_apresentacao" => $id_apresentacao,
			"fgk_revisor" => $res->fgk_revisor,
			"nome_avaliador" => $res->nome_avaliador,
			"status" => $res->status,
			"fgk_trabalho" => $res->fgk_trabalho,
			"nota_a" => $res->nota_a,
			"nota_b" => $res->nota_b,
			"nota_c" => $res->nota_c,
			"nota_d" => $res->nota_d,
			"nota_e" => $res->nota_e,
			"nome_sessao" => $res->nome_sessao,
			"descricao_area" => $res->descricao_area,
			"cod_poster" => $res->cod_poster,
			"titulo_enviado" => $res->titulo_enviado
		));
		exit;
	}

	echo json_encode(array(
		"success" => false
	));
?>