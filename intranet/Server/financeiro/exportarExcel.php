<?php
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");
	require_once("../../includes/functions.php");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="pagamentos.xls"');
	header('Cache-Control: max-age=0');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	$queryPagamentos = "SELECT email, es_instituicao.nome AS nome_instituicao, fgk_tipo_pagamento, es_inscritos_boletos.valor AS valor_boleto, es_servicos.descricao_servico, es_inscritos.nome, DATE_FORMAT(datahora_pagamento, '%d/%m/%Y') AS data_pagamento, es_inscritos_pagamentos.valor_pago
						FROM es_inscritos_pagamentos 
						INNER JOIN es_inscritos_servicos ON es_inscritos_pagamentos.id_inscrito_servico = es_inscritos_servicos.id_inscrito_servico 
						INNER JOIN es_inscritos ON es_inscritos_servicos.fgk_inscrito = es_inscritos.id 
						INNER JOIN es_servicos ON es_inscritos_servicos.fgk_servico = es_servicos.id_servico
						LEFT JOIN es_inscritos_boletos ON es_inscritos_servicos.fgk_boleto = es_inscritos_boletos.id_boleto
						LEFT JOIN es_instituicao ON es_inscritos.fgk_instituicao = es_instituicao.id 
						INNER JOIN es_pagamentos_tipos ON es_inscritos_pagamentos.fgk_tipo_pagamento = es_pagamentos_tipos.id_tipo_pagamento
						INNER JOIN es_inscritos_tipos ON es_inscritos.fgk_tipo = es_inscritos_tipos.id_tipo_inscrito
						WHERE es_inscritos.id IS NOT NULL";

	$vars = array();

	if(isset($_REQUEST['filtro'])){
		$filtro = $_REQUEST['filtro'];
		$queryPagamentos.=" AND es_inscritos.nome LIKE ?
							OR es_servicos.descricao_servico LIKE ? ";
		$vars['es_inscritos.nome'] = "'%".$filtro."%'";
		$vars['es_servicos.descricao_servico'] = "'%".$filtro."%'";
	}

	if(isset($_REQUEST['fgk_instituicao']) && ($_REQUEST['fgk_instituicao'] != '')){
		$fgk_instituicao = $_REQUEST['fgk_instituicao'];
		$queryPagamentos.=" AND es_inscritos.fgk_instituicao = ?";
		$vars['es_inscritos.fgk_instituicao'] = $fgk_instituicao;
	}

	if(isset($_REQUEST['servico']) ){
		$servico = $_REQUEST['servico'];
		$queryPagamentos.=" AND es_servicos.id_servico = ?";
		$vars['es_servicos.id_servico'] = $servico;
	}

	if(isset($_REQUEST['tipo_pagamento'])){
		$tipo_pagamento = $_REQUEST['tipo_pagamento'];
		$queryPagamentos.=" AND es_pagamentos_tipos.id_tipo_pagamento = ?";
		$vars['es_pagamentos_tipos.id_tipo_pagamento'] = $tipo_pagamento;
	}

	if(isset($_REQUEST['tipo_inscrito'])){
		$tipo_inscrito = $_REQUEST['tipo_inscrito'];
		$queryPagamentos.=" AND es_inscritos_tipos.id_tipo_inscrito = ?";
		$vars['es_inscritos_tipos.id_tipo_inscrito'] = $tipo_inscrito;
	}

	if(isset($_REQUEST['dataMin']) && isset($_REQUEST['dataMax']) && ($_REQUEST['dataMin'] != 'undefined')){
		$dataMin = $_REQUEST['dataMin'];
		$dataMax = $_REQUEST['dataMax'];

		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) BETWEEN ? AND ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMin;
		$vars['es_inscritos_pagamentos.datahora_pagamento2'] = $dataMax;

	}else if(isset($_REQUEST['dataMin'])){
		$dataMin = $_REQUEST['dataMin'];
		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) >= ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMin;

	}else if(isset($_REQUEST['dataMax'])){
		$dataMax = $_REQUEST['dataMax'];
		$queryPagamentos.=" AND date(es_inscritos_pagamentos.datahora_pagamento) <= ?";
		$vars['es_inscritos_pagamentos.datahora_pagamento'] = $dataMax;
	}

	$queryPagamentos.=" ORDER BY es_inscritos_pagamentos.datahora_pagamento DESC; ";
	$result = $db->sql_query($queryPagamentos, $vars);

	$totalPgto = 0;

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'DATA PAGAMENTO')
		->setCellValue('B1', 'NOME INSCRITO')
		->setCellValue('C1', 'EMAIL')
		->setCellValue('D1', 'INSTITUIÇÃO')
		->setCellValue('E1', 'SERVIÇO')
		->setCellValue('F1', 'VALOR BOLETO')
		->setCellValue('G1', 'VALOR PAGO')
		->setCellValue('H1', 'FORMA DE PAGAMENTO');
	$linha = 1;

	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	foreach($result as $res){
		$linha++;

		$objPHPExcel->getActiveSheet()->getStyle('A'.$linha)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
		$objPHPExcel->getActiveSheet()->getStyle('F'.$linha)->getNumberFormat()->setFormatCode('[$R$-416] #.##;[RED]-[$R$-416] #.##');
		$objPHPExcel->getActiveSheet()->getStyle('G'.$linha)->getNumberFormat()->setFormatCode('[$R$-416] #.##;[RED]-[$R$-416] #.##');


		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $res->data_pagamento);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $res->nome);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $res->email);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $res->nome_instituicao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $res->descricao_servico);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $res->valor_boleto/100);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $res->valor_pago/100);

		if($res->fgk_tipo_pagamento == 6){
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, "Inscrição rápida");
		    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $res->valor_pago/100);
		}else if($res->fgk_tipo_pagamento == 7)
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, "Dinheiro");
		else
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, "Boleto");

	}
	$objPHPExcel->getActiveSheet()->setTitle('Pagamentos');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(90);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>