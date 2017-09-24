<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="inscritos.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	// foreach ($_REQUEST as $key => $value){
		// if(($value == "undefined") || $value == "")
			// unset($_REQUEST[$key]);
	// }

	if(isset($_REQUEST['pa'])){
		$cpf 					= $_REQUEST['cpf'];
		$fgk_tipo 				= $_REQUEST['fgk_tipo'];
		$fgk_instituicao 		= $_REQUEST['fgk_instituicao'];
		$fgk_departamento 		= $_REQUEST['fgk_departamento'];
		$departamento 			= $_REQUEST['departamento'];
		$fgk_curso 				= $_REQUEST['fgk_curso'];
		$curso 					= $_REQUEST['curso'];

		$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
		$bool_monitoria			= $_REQUEST['bool_monitoria'];
		$bool_temp				= $_REQUEST['bool_temp'];
		$conta_ativada			= $_REQUEST['conta_ativada'];
		$bool_coordenador		= $_REQUEST['bool_coordenador'];
		$bool_revisor			= $_REQUEST['bool_revisor'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s ",
			($_REQUEST['cpf'])						? "( es_inscritos.cpf = '$cpf' )" 	: "1",
			($_REQUEST['fgk_tipo'])					? "( es_inscritos.fgk_tipo = $fgk_tipo )" 	: "1",
			($_REQUEST['fgk_instituicao'])			? "( es_inscritos.fgk_instituicao = $fgk_instituicao )"	: "1",
			($_REQUEST['fgk_departamento'])			? "( es_inscritos.fgk_departamento = '$fgk_departamento' )"	: "1",
			($_REQUEST['departamento'])				? "( es_inscritos.departamento = '$departamento' )"	: "1",
			($_REQUEST['fgk_curso'])				? "( es_inscritos.fgk_curso = '$fgk_curso' )"	: "1",
			($_REQUEST['curso'])					? "( es_inscritos.curso = '$curso' )"	: "1",
			($_REQUEST['mobilidade_ano_passado']>-1)? "( es_inscritos.mobilidade_ano_passado = '$mobilidade_ano_passado' )"	: "1",
			($_REQUEST['bool_monitoria']>-1)		? "( es_inscritos.bool_monitoria = '$bool_monitoria' )"	: "1",
			($_REQUEST['bool_temp']>-1)				? "( es_inscritos.bool_temp = '$bool_temp' )"	: "1",
			($_REQUEST['conta_ativada']>-1)			? "( es_inscritos.conta_ativada = '$conta_ativada' )"	: "1",
			($_REQUEST['bool_coordenador']>-1)		? "( es_inscritos.bool_coordenador = '$bool_coordenador' )"	: "1",
			($_REQUEST['bool_revisor']>-1)			? "( es_inscritos.bool_revisor = '$bool_revisor' )"	: "1"
		);
	}
	else{
		$busca_avancada = "";
	}
	// echo $busca_avancada;
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
				es_inscritos.nome LIKE '%$buscaRapida%' OR
				es_inscritos.matricula LIKE '%$buscaRapida%' OR
				es_inscritos.curso LIKE '%$buscaRapida%' OR
				es_inscritos.departamento LIKE '%$buscaRapida%' OR
				es_inscritos.cpf LIKE '%$buscaRapida%'
			)";
	}

	$queryString = "
		SELECT es_inscritos.*, es_inscritos_tipos.descricao_tipo, es_evento.sigla, es_instituicao.sigla AS sigla_instituicao, es_instituicao.nome AS nome_instituicao, es_ufop_departamentos.nome_departamento, es_ufop_cursos.descricao_curso, desk_estados.id_estado,
		IF(es_inscritos.bool_temp = 1, 'Sim', 'Não') AS bool_temp,
		IF(es_inscritos.bool_coordenador = 1, 'Sim', 'Não') AS bool_coordenador,
		IF(es_inscritos.bool_revisor = 1, 'Sim', 'Não') AS bool_revisor,
		IF(es_inscritos.bool_monitoria = 1, 'Sim', 'Não') AS bool_monitoria,
		IF(es_inscritos.conta_ativada = 1, 'Sim', 'Não') AS conta_ativada,
		IF(es_inscritos.mobilidade_ano_passado = 1, 'Sim', 'Não') AS mobilidade_ano_passado
		,es_inscritos_credencial.codigo_credenciamento
		,SUM(CASE WHEN es_inscritos_servicos.bool_pago = 1 THEN 1 ELSE 0 END) serv_pg
		,SUM(CASE WHEN es_inscritos_servicos.fgk_inscrito = es_inscritos.id THEN 1 ELSE 0 END) servs
		,COUNT(es_inscritos_servicos.fgk_inscrito) AS num_servicos
		FROM es_inscritos
		 LEFT JOIN es_inscritos_tipos ON es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
		 INNER JOIN es_evento ON es_evento.id = es_inscritos.fgk_evento
		 LEFT JOIN es_instituicao ON es_instituicao.id = es_inscritos.fgk_instituicao
		 LEFT JOIN desk_estados ON desk_estados.uf = es_inscritos.estado
		 LEFT JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_inscritos.fgk_departamento AND es_inscritos.fgk_departamento <>  '0'
		 LEFT JOIN es_ufop_cursos ON es_ufop_cursos.id_curso = es_inscritos.fgk_curso AND es_inscritos.fgk_curso > 0
		 LEFT JOIN es_inscritos_credencial ON es_inscritos_credencial.fgk_inscrito = es_inscritos.id AND es_inscritos_credencial.fgk_evento = $id_evento_atual
		 LEFT JOIN es_inscritos_servicos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito
		WHERE $filtro
		 AND es_evento.id = $id_evento_atual
		 $busca_avancada
		 GROUP BY es_inscritos.id
		ORDER BY es_inscritos.nome
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'NOME')
		->setCellValue('B1', 'CPF')
		->setCellValue('C1', 'CRACHÁ')
		->setCellValue('D1', 'COD CRACHÁ')
		->setCellValue('E1', 'TIPO')
		->setCellValue('F1', 'INSTITUIÇÃO')
		->setCellValue('G1', 'COORDENADOR')
		->setCellValue('H1', 'REVISOR')
		->setCellValue('I1', 'MONITORIA')
		->setCellValue('J1', 'MOBILIDADE')
		->setCellValue('K1', 'PRÉ-CADASTRO')
		->setCellValue('L1', 'CONTA ATIVADA')
		->setCellValue('M1', 'SITUAÇÃO');

	$linha = 1;
	$styleArray = array(
	'font'  => array(
		'color' => array('rgb' => 'FF0000')
	));
	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	while($registro = mysqli_fetch_assoc($query)) {
		if( $registro['fgk_curso']=="0" || $registro['fgk_curso']=="" )
			$registro['descricao_curso'] = $registro['curso'];
		if( $registro['fgk_departamento']=="0" || $registro['fgk_curso']=="" )
			$registro['nome_departamento'] = $registro['departamento'];
		$registro['rend_inst'] = $registro['sigla_instituicao'] . " - " . $registro['nome_instituicao'];
		if($registro['num_servicos'] != 0)
			if($registro['serv_pg'] == $registro['servs'])
				$quite = "OK";
			else
				$quite = "Pendente";
		else
			$quite = "Pendente";
		$linha++;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, utf8_encode($registro['nome']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $registro['cpf']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, utf8_encode($registro['nome_cracha']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $registro['codigo_credenciamento']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, utf8_encode($registro['descricao_tipo']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, utf8_encode($registro['rend_inst']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $registro['bool_coordenador']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, $registro['bool_revisor']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $linha, $registro['bool_monitoria']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $linha, $registro['mobilidade_ano_passado']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $linha, $registro['bool_temp']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $linha, $registro['conta_ativada']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $linha, $quite);
		if($quite=="Pendente"){
			$objPHPExcel->getActiveSheet()
				->getStyle('A'.$linha.':M'.$linha.'')
				->applyFromArray($styleArray);
		}
	}

	$objPHPExcel->getActiveSheet()->setTitle('Inscritos');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>