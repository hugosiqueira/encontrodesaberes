<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryPagamentos = "SELECT fgk_tipo_pagamento, es_inscritos_boletos.valor AS valor_boleto, es_servicos.descricao_servico, es_inscritos.nome, datahora_pagamento, es_inscritos_pagamentos.valor_pago
						FROM es_inscritos_pagamentos 
						INNER JOIN es_inscritos_servicos ON es_inscritos_pagamentos.id_inscrito_servico = es_inscritos_servicos.id_inscrito_servico 
						INNER JOIN es_inscritos ON es_inscritos_servicos.fgk_inscrito = es_inscritos.id 
						INNER JOIN es_servicos ON es_inscritos_servicos.fgk_servico = es_servicos.id_servico
						LEFT JOIN es_inscritos_boletos ON es_inscritos_servicos.fgk_boleto = es_inscritos_boletos.id_boleto
						INNER JOIN es_pagamentos_tipos ON es_inscritos_pagamentos.fgk_tipo_pagamento = es_pagamentos_tipos.id_tipo_pagamento
						INNER JOIN es_inscritos_tipos ON es_inscritos.fgk_tipo = es_inscritos_tipos.id_tipo_inscrito
						WHERE es_inscritos.fgk_evento = ?";

	$vars = array('fgk_evento'=> $id_evento);

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryPagamentos.=" AND es_inscritos.nome LIKE ?
							OR es_servicos.descricao_servico LIKE ? ";
		$vars['es_inscritos.nome'] = '%'.$filtro.'%';
		$vars['es_servicos.descricao_servico'] = '%'.$filtro.'%';
	}

	if(isset($_REQUEST['fgk_instituicao']) && ($_REQUEST['fgk_instituicao'] != '')){
		$fgk_instituicao = $_REQUEST['fgk_instituicao'];
		$queryPagamentos.=" AND es_inscritos.fgk_instituicao = ?";
		$vars['es_inscritos.fgk_instituicao'] = $fgk_instituicao;
	}

	if(isset($_REQUEST['servico']) && ($_REQUEST['servico'] != '')){
		$servico = $_REQUEST['servico'];
		$queryPagamentos.=" AND es_servicos.id_servico = ?";
		$vars['es_servicos.id_servico'] = $servico;
	}

	if(isset($_REQUEST['tipo_pagamento']) && ($_REQUEST['tipo_pagamento'] != '')){
		$tipo_pagamento = $_REQUEST['tipo_pagamento'];
		$queryPagamentos.=" AND es_pagamentos_tipos.id_tipo_pagamento = ?";
		$vars['es_pagamentos_tipos.id_tipo_pagamento'] = $tipo_pagamento;
	}

	if(isset($_REQUEST['tipo_inscrito']) && ($_REQUEST['tipo_inscrito'] != '')){
		$tipo_inscrito = $_REQUEST['tipo_inscrito'];
		$queryPagamentos.=" AND es_inscritos_tipos.id_tipo_inscrito = ?";
		$vars['es_inscritos_tipos.id_tipo_inscrito'] = $tipo_inscrito;
	}

	if(isset($_REQUEST['dataMin']) && isset($_REQUEST['dataMax'])){
		$dataMin = $_REQUEST['dataMin'];
		$dataMax = $_REQUEST['dataMax'];

		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) BETWEEN ? AND ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMin;
		$vars['es_inscritos_pagamentos.datahora_pagamento2'] = $dataMax;

	}else if(isset($_REQUEST['dataMin']) && ($_REQUEST['dataMin'] != '')){
		$dataMin = $_REQUEST['dataMin'];
		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) >= ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMin;

	}else if(isset($_REQUEST['dataMax']) && ($_REQUEST['dataMax'] != '')){
		$dataMax = $_REQUEST['dataMax'];
		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) <= ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMax;
	}

	$total = $db->sql_query($queryPagamentos, $vars);
	$queryPagamentos.=" ORDER BY es_inscritos_pagamentos.datahora_pagamento DESC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryPagamentos, $vars);

	$pagamentos = array();
	foreach ($result as $pagamento){
		$pagamentos[] = $pagamento;
	}

	$totalPgto = 0;
	foreach ($total as $pgto) {
		$totalPgto += $pgto->valor_pago;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"somaPgto" => $totalPgto,
		"pagamentos" => $pagamentos
	));
?>