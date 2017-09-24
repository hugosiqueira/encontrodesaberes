<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="trabalhos.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");

	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	$filtros = array();
	$queryString = "
		SELECT IF(es_trabalho.apresentacao_obrigatoria, 'Sim', 'Não') AS ap_obrigatoria, es_trabalho_justificativa.descricao, es_trabalho.*, es_inscritos.nome, es_area_especifica.descricao_area_especifica, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_tipo_apresentacao.descricao_tipo, es_trabalho_status.descricao_status, es_categorias.descricao_categoria, es_categorias.sigla_categoria, es_instituicao.nome, es_instituicao.sigla
		FROM es_trabalho
			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			INNER JOIN es_evento ON es_evento.id = es_trabalho.fgk_evento
			LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
			LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho.fgk_instituicao
			INNER JOIN es_tipo_apresentacao ON es_tipo_apresentacao.id_tipo_apresentacao = es_trabalho.fgk_tipo_apresentacao
			INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
			INNER JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
			LEFT JOIN es_projeto ON es_projeto.id = es_trabalho.fgk_projeto
			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			LEFT JOIN es_trabalho_justificativa ON es_trabalho_justificativa.fgk_trabalho = es_trabalho.id
		WHERE es_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);


	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['nome_autores'])&&($_REQUEST['nome_autores']!='')){
			$queryString.= "
				AND es_trabalho.id IN (
					SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
				)
			";
			$filtros[] = '%'.$_REQUEST['nome_autores'].'%';
		}
		if(isset($_REQUEST['apresentacao_obrigatoria'])&&($_REQUEST['apresentacao_obrigatoria']!='')){
			$queryString.= "  AND es_trabalho.apresentacao_obrigatoria = ?";
			$filtros[] = $_REQUEST['apresentacao_obrigatoria'];
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho.fgk_status = ? ";
			$filtros[] = $fgk_status;
		}
		if(isset($_REQUEST['fgk_orgao_fomento'])&&($_REQUEST['fgk_orgao_fomento']!='')){
			$fgk_orgao_fomento = $_REQUEST['fgk_orgao_fomento'];
			$queryString.= " AND es_trabalho.fgk_orgao_fomento = ?";
			$filtros[] = $fgk_orgao_fomento;
		}
		if(isset($_REQUEST['fgk_categoria'])&&($_REQUEST['fgk_categoria']!='')){
			$fgk_categoria = $_REQUEST['fgk_categoria'];
			$queryString.= " AND es_trabalho.fgk_categoria = ?";
			$filtros[] = $fgk_categoria;
		}
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_trabalho.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
			$queryString.= " AND es_trabalho.fgk_area_especifica = ?";
			$filtros[] = $fgk_area_especifica;
		}
		if(isset($_REQUEST['fgk_tipo_apresentacao'])&&($_REQUEST['fgk_tipo_apresentacao']!='')){
			$fgk_tipo_apresentacao = $_REQUEST['fgk_tipo_apresentacao'];
			$queryString.= " AND es_trabalho.fgk_tipo_apresentacao = ?";
			$filtros[] = $fgk_tipo_apresentacao;
		}
		if(isset($_REQUEST['avaliacao'])&&($_REQUEST['avaliacao']!='-1')){
			$avaliacao = $_REQUEST['avaliacao'];
			if($avaliacao=='0'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status = 0
					)
				";
			}
			else if($avaliacao=='1'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status > 0
					)
				";
			}
		}
	}
	if(isset($_REQUEST['filtro'])){
		$buscaRapida = $_REQUEST['filtro'];
		$queryString.= " AND (
			es_trabalho.palavras_chave 	LIKE ? OR
			es_trabalho.resumo_revisado LIKE ? OR
			es_trabalho.resumo_enviado 	LIKE ? OR
			es_trabalho.titulo_revisado LIKE ? OR
			es_trabalho.titulo_enviado 	LIKE ? OR
			es_trabalho.id IN (
				SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
			)
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$query = $db->sql_query2($queryString, $filtros);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'CATEGORIA')
		->setCellValue('B1', 'TÍTULO ENVIADO')
		->setCellValue('C1', 'AUTOR')
		->setCellValue('D1', 'ORIENTADOR')
		->setCellValue('E1', 'ÁREA')
		->setCellValue('F1', 'ÁREA ESPECÍFICA')
		->setCellValue('G1', 'TIPO')
		->setCellValue('H1', 'APRESENTAÇÃO OBRIGATÓRIA')
		->setCellValue('I1', 'SITUAÇÃO');
	$linha = 1;
	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
	foreach ($query as $res){
		// echo $linha.' '.$res->id.'<br>';
		$res->titulo_a_mais = $res->titulo_enviado;
		$autores 	= "";
		$orientador = "";
		$queryAutores ="
			SELECT es_trabalho_autor.nome, es_trabalho_autor.fgk_tipo_autor
			FROM es_trabalho_autor
			WHERE es_trabalho_autor.fgk_trabalho = ?
			ORDER BY es_trabalho_autor.ordenacao
		";
		$queryAutores = $db->sql_query2($queryAutores,array($res->id));
		foreach ($queryAutores as $resAutor){
			if($resAutor->fgk_tipo_autor ==2){
				$orientador = $resAutor->nome;
			}
			else{
				if($autores=="")
					$autores = $resAutor->nome;
				else
					$autores = $autores.", ".$resAutor->nome;
			}
		}
		$res->todos_autores = $autores;
		$res->orientador 	= $orientador;

		if($res->fgk_tipo_apresentacao == 1)
			$res->tipo_apresentacao = 'Apresentação em poster.';
		else if($res->fgk_tipo_apresentacao == 2)
			$res->tipo_apresentacao = 'Apresentação oral.';

		$linha++;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $res->sigla_categoria);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $res->titulo_enviado);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $res->todos_autores);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $res->orientador);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $res->descricao_area);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $res->descricao_area_especifica);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $res->tipo_apresentacao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, $res->ap_obrigatoria);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $linha, $res->descricao_status);
	}

	$objPHPExcel->getActiveSheet()->setTitle('Trabalhos');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(110);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>