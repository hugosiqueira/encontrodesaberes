<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="trabalhos.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");

	sec_session_start();
	$nome_autores = "";
	$id_evento_atual = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	if(isset($_REQUEST['pa'])){
		$apresentacao_obrigatoria 	= $_REQUEST['apresentacao_obrigatoria'];
		$nome_autores 				= $_REQUEST['nome_autores'];
		$fgk_status 				= $_REQUEST['fgk_status'];
		$fgk_orgao_fomento 			= $_REQUEST['fgk_orgao_fomento'];
		$fgk_categoria 				= $_REQUEST['fgk_categoria'];
		$fgk_area					= $_REQUEST['fgk_area'];
		$fgk_area_especifica 		= $_REQUEST['fgk_area_especifica'];
		$fgk_tipo_apresentacao 		= $_REQUEST['fgk_tipo_apresentacao'];

		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s AND %s AND %s ",
			($_REQUEST['fgk_status'])		? "( es_trabalho.fgk_status = $fgk_status )" 	: "1",
			($_REQUEST['fgk_orgao_fomento'])? "( es_trabalho.fgk_orgao_fomento = $fgk_orgao_fomento )" 	: "1",
			($_REQUEST['fgk_categoria'])	? "( es_trabalho.fgk_categoria = $fgk_categoria )" 	: "1",
			($_REQUEST['fgk_area'])			? "( es_trabalho.fgk_area = $fgk_area )" 			: "1",
			($_REQUEST['fgk_area_especifica'])? "( es_trabalho.fgk_area_especifica = $fgk_area_especifica )"	: "1",
			($_REQUEST['fgk_tipo_apresentacao'])? "( es_trabalho.fgk_tipo_apresentacao = '$fgk_tipo_apresentacao' )"		: "1"
		);
		if(isset($_REQUEST['apresentacao_obrigatoria'])){
			if($apresentacao_obrigatoria == '0'){
				$busca_avancada .= " AND es_trabalho.apresentacao_obrigatoria = 0";
			}
			else if($apresentacao_obrigatoria == '1'){
				$busca_avancada .= " AND es_trabalho.apresentacao_obrigatoria = 1";
			}
		}
	}else{
		$busca_avancada = "";
	}
	// echo $busca_avancada;

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_trabalho.palavras_chave LIKE '%$buscaRapida%' OR
			es_trabalho.resumo_revisado LIKE '%$buscaRapida%' OR
			es_trabalho.resumo_enviado LIKE '%$buscaRapida%' OR
			es_trabalho.titulo_revisado LIKE '%$buscaRapida%' OR
			es_trabalho.titulo_enviado LIKE '%$buscaRapida%'
		)";
	}
	if($nome_autores != ""){  //caso a busca avançada esteja ativa para o autor, é necessário um LEFT JOIN a mais na query

		$queryString = "
			SELECT IF(es_trabalho.apresentacao_obrigatoria, 'Sim', 'Não') AS ap_obrigatoria, es_trabalho_justificativa.descricao, es_trabalho.*, es_inscritos.nome, es_area_especifica.descricao_area_especifica, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_tipo_apresentacao.descricao_tipo, es_trabalho_status.descricao_status, es_categorias.descricao_categoria, es_categorias.sigla_categoria
			FROM es_trabalho
			 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			 INNER JOIN es_evento ON es_evento.id = es_trabalho.fgk_evento
			 LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
			 INNER JOIN es_tipo_apresentacao ON es_tipo_apresentacao.id_tipo_apresentacao = es_trabalho.fgk_tipo_apresentacao
			 INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
			 INNER JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
			 LEFT JOIN es_projeto ON es_projeto.id = es_trabalho.fgk_projeto
			 LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			 LEFT JOIN es_trabalho_autor ON es_trabalho_autor.fgk_trabalho = es_trabalho.id
			 
			 LEFT JOIN es_trabalho_justificativa ON es_trabalho_justificativa.fgk_trabalho = es_trabalho.id
			WHERE $filtro
			 AND es_trabalho.fgk_evento = $id_evento_atual
			 $busca_avancada
			 AND es_trabalho_autor.nome LIKE '%$nome_autores%'
			ORDER BY datahora_registro DESC";
	}else{
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
			WHERE $filtro
			 AND es_trabalho.fgk_evento = $id_evento_atual
			 $busca_avancada
			ORDER BY datahora_registro DESC";
	}

	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'CATEGORIA')
		->setCellValue('B1', 'TÍTULO ENVIADO')
		->setCellValue('C1', 'AUTOR')
		->setCellValue('D1', 'ORIENTADOR')
		->setCellValue('E1', 'ÁREA')
		->setCellValue('F1', 'TIPO')
		->setCellValue('G1', 'APRESENTAÇÃO OBRIGATÓRIA')
		->setCellValue('H1', 'SITUAÇÃO');
	$linha = 1;

	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	while($registro = mysqli_fetch_assoc($query)) {
		$registro['titulo_a_mais'] = $registro['titulo_enviado'];
		$id_trabalho = $registro['id'];
		$autores = "";
		$cpfs = "";
		$orientador ="";
		$queryAutores ="
			SELECT es_trabalho_autor.nome, es_trabalho_autor.fgk_tipo_autor
			FROM es_trabalho_autor
			WHERE es_trabalho_autor.fgk_trabalho = $id_trabalho
			ORDER BY es_trabalho_autor.ordenacao
		";
		$queryAutores = mysqli_query($mysqli,$queryAutores) or die(mysqli_error($mysqli));
		while($reg = mysqli_fetch_assoc($queryAutores)) {
			if($reg['fgk_tipo_autor']=="2"){
				$orientador = $reg['nome'];
			}
			else{
				if($autores=="")
					$autores = $reg['nome'];
				else
					$autores = $autores.", ".$reg['nome'];
			}
		}
		$registro['todos_autores'] = $autores;
		$registro['orientador'] = $orientador;

		if($registro['fgk_tipo_apresentacao'] == 1)
			$registro['tipo_apresentacao'] = 'Apresentação em poster.';
		else if($registro['fgk_tipo_apresentacao'] == 2)
			$registro['tipo_apresentacao'] = 'Apresentação oral.';

		$linha++;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $registro['sigla_categoria']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, utf8_encode($registro['titulo_enviado']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $registro['todos_autores']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $registro['orientador']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, utf8_encode($registro['descricao_area']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $registro['tipo_apresentacao']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $registro['ap_obrigatoria']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, utf8_encode($registro['descricao_status']));
	}

	$objPHPExcel->getActiveSheet()->setTitle('Trabalhos');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(110);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>