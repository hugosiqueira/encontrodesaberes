<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="projetos.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");

	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	$queryString = "SELECT es_projeto.id, es_projeto.fgk_instituicao, es_trabalho.fgk_status, es_projeto.fgk_area, es_projeto.fgk_area_especifica, es_projeto.fgk_orgao_fomento, fgk_programa_ic, fgk_departamento, 
	es_projeto.fgk_categoria, aluno, aluno_cpf, IF(es_projeto.apresentacao_obrigatoria, 'Sim', 'Não') AS apresentacao_obrigatoria, codigo_area, orientador, orientador_cpf, sigla_categoria, titulo,  
	 es_orgao_fomento.sigla AS sigla_orgao, es_programa_ic.sigla AS sigla_programa, es_programa_ic.nome AS nome_programa_ic, 
	 				IF(es_trabalho.id, 'Sim', 'Não') AS bool_trabalho 
					FROM es_projeto 
					INNER JOIN es_ufop_areas ON es_projeto.fgk_area = es_ufop_areas.id_area 
					INNER JOIN es_programa_ic ON es_projeto.fgk_programa_ic = es_programa_ic.id
					LEFT JOIN es_categorias ON es_projeto.fgk_categoria = es_categorias.id_categoria 
					LEFT JOIN es_trabalho ON es_projeto.id = es_trabalho.fgk_projeto
					INNER JOIN es_orgao_fomento ON es_projeto.fgk_orgao_fomento = es_orgao_fomento.id 
					WHERE es_projeto.fgk_evento = $id_evento ";

	if(isset($_REQUEST['cpf'])){
		$cpf = $_REQUEST['cpf'];
		$queryString.=" AND es_projeto.aluno_cpf = '$cpf' OR es_projeto.orientador_cpf = '$cpf'"; 
	}

	if(isset($_REQUEST['nome'])){
		$nome = $_REQUEST['nome'];
		$queryString.=" AND es_projeto.aluno LIKE '%$nome%' OR es_projeto.orientador LIKE '%$nome%'"; 
	}

	if(isset($_REQUEST['email'])){
		$email = $_REQUEST['email'];
		$queryString.=" AND es_projeto.aluno_email LIKE '%$email%' OR es_projeto.orientador_email LIKE '%$email%'"; 
	}

	if(isset($_REQUEST['titulo'])){
		$titulo = $_REQUEST['titulo'];
		$queryString.=" AND es_projeto.titulo LIKE '%$titulo%'";
	}

	if(isset($_REQUEST['fgk_area'])){
		$fgk_area = $_REQUEST['fgk_area'];
		$queryString.=" AND es_projeto.fgk_area = $fgk_area";
	}

	if(isset($_REQUEST['fgk_categoria'])){
		$fgk_categoria = $_REQUEST['fgk_categoria'];
		$queryString.=" AND es_projeto.fgk_categoria = $fgk_categoria";
	}

	if(isset($_REQUEST['fgk_programa_ic'])){
		$fgk_programa_ic = $_REQUEST['fgk_programa_ic'];
		$queryString.=" AND es_projeto.fgk_programa_ic = $fgk_programa_ic";
	}

	if(isset($_REQUEST['fgk_departamento'])){
		$fgk_departamento = $_REQUEST['fgk_departamento'];
		$queryString.=" AND es_projeto.fgk_departamento = '$fgk_departamento'";
	}

	if(isset($_REQUEST['fgk_orgao_fomento'])){
		$fgk_orgao_fomento = $_REQUEST['fgk_orgao_fomento'];
		$queryString.=" AND es_projeto.fgk_orgao_fomento = $fgk_orgao_fomento";
	}

	if(isset($_REQUEST['fgk_area_especifica'])){
		$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
		$queryString.=" AND es_projeto.fgk_area_especifica = $fgk_area_especifica";
	}

	if(isset($_REQUEST['apresentacao_obrigatoria'])){
		$apresentacao_obrigatoria = $_REQUEST['apresentacao_obrigatoria'];
		$queryString.=" AND es_projeto.apresentacao_obrigatoria = $apresentacao_obrigatoria";
	}

	if(isset($_REQUEST['filtro'])){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND sigla_categoria LIKE '%$filtro%' OR 
						aluno LIKE '%$filtro%' OR 
						orientador LIKE '%$filtro%' OR
						titulo LIKE '%$filtro%'"; 
	}

	$queryString.=" ORDER BY es_projeto.datahora_registro DESC ";	
		
	$query = $db->sql_query($queryString);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'CATEGORIA')
		->setCellValue('B1', 'ORIENTADOR')
		->setCellValue('C1', 'ALUNO')
		->setCellValue('D1', 'ÁREA')
		->setCellValue('E1', 'ÓRGÃO FOMENTO')
		->setCellValue('F1', 'PROG. INIC. CIENTÍFICA')
		->setCellValue('G1', 'TRABALHO')
		->setCellValue('H1', 'APRESENTAÇÃO OBRIGATÓRIA');
	$linha = 1;

	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	foreach ($query as $res){
		$linha++;

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $res->sigla_categoria);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $res->orientador);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $res->aluno);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $res->codigo_area);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $res->sigla_orgao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $res->nome_programa_ic);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $res->bool_trabalho);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, $res->apresentacao_obrigatoria);

	}

	$objPHPExcel->getActiveSheet()->setTitle('Projetos');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(26);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(29);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>