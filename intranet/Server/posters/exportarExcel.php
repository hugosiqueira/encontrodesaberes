<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="alocacao.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");

	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	$queryString = "SELECT es_trabalho.*, es_ufop_areas.id_area, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_orgao_fomento.sigla AS sigla_orgao, es_orgao_fomento.nome AS nome_orgao, es_trabalho_apresentacao.cod_poster, es_trabalho_apresentacao.id AS id_apresentacao, es_inscritos.nome AS avaliador, es_sessao.nome AS nome_sessao, es_area_especifica.descricao_area_especifica, DATE_FORMAT(es_sessao.dia,'%d/%m/%Y') AS data_sessao, es_sessao.hora_ini, es_sessao.hora_fim, es_instituicao.sigla AS nome_instituicao
		

		, (
			SELECT GROUP_CONCAT(nome  SEPARATOR ', ') FROM es_trabalho_autor WHERE bool_apresentador = 1 AND es_trabalho_autor.fgk_trabalho = es_trabalho.id
		) AS apresentadores
		
		FROM es_trabalho
			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_trabalho = es_trabalho.id
			LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
			LEFT JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
			LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
			LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho.fgk_instituicao
		WHERE es_trabalho.fgk_evento = ? AND es_trabalho.fgk_tipo_apresentacao = 1 AND (es_trabalho.fgk_status = 6 OR es_trabalho.fgk_status = 14)
	";
	$filtros[] = intval($id_evento_atual);
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
	$queryString.=" ORDER BY cod_poster ASC ";
	// echo $queryString;
	$query = $db->sql_query2($queryString, $filtros);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'PÔSTER')
		->setCellValue('B1', 'APRESENTADOR')
		->setCellValue('C1', 'TÍTULO')
		->setCellValue('D1', 'INSTITUIÇÃO')
		->setCellValue('E1', 'DATA')
		->setCellValue('F1', 'HORÁRIO')
		->setCellValue('G1', 'SESSÃO');
	$linha = 1;

	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
	$id=0;
	// echo $query->rowCount()."<br>";
	foreach ($query as $res){
		$linha++;
		$horario = $res->hora_ini." - ".$res->hora_fim;
		// echo $res->id." ".$res->cod_poster." ".$res->apresentadores."<br>";
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $res->cod_poster);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $res->apresentadores);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $res->titulo_enviado);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $res->nome_instituicao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $res->data_sessao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $horario);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $res->nome_sessao);

	}

	$objPHPExcel->getActiveSheet()->setTitle('Posters');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(55);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>