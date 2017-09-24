<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
		$id_inscrito = $_REQUEST['id'];

		$queryBoletos = "SELECT link, es_inscritos_boletos.id_boleto, es_servicos.valor_servico, valor_pago, data_vencimento, data_pagamento, descricao_servico, es_inscritos_servicos.bool_pago
						 FROM es_inscritos_boletos 
						 INNER JOIN es_inscritos_servicos ON es_inscritos_boletos.id_boleto = es_inscritos_servicos.fgk_boleto 
						 INNER JOIN es_servicos ON es_inscritos_servicos.fgk_servico = es_servicos.id_servico 
						 WHERE es_inscritos_boletos.fgk_inscrito = ? 
						 AND es_inscritos_boletos.status != 3";
						 //AND es_servicos.fgk_evento = ? //Não foram criados servicos pro SEIC2016, e sim usados do SEIC2015 

		$vars = array('es_inscritos_boletos.fgk_inscrito'=> $id_inscrito); //'es_servicos.fgk_evento'=> $id_evento, 
		
		$total = $db->sql_query($queryBoletos, $vars);

		$queryBoletos.=" ORDER BY descricao_servico ASC LIMIT $start, $limit; ";
		$result = $db->sql_query($queryBoletos, $vars);

		$boletos = array();
		foreach ($result as $boleto)
			$boletos[] = $boleto;

		echo json_encode(array(
			"success" => true,
			"total" => $total->rowCount(),
			"boletos" => $boletos
		));
	}
?>