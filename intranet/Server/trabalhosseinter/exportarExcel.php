<?php
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="trabalhos_seinter.xls"');
	header('Cache-Control: max-age=0');

	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");

	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	foreach ($_REQUEST as $key => $value){
		if(($value == "undefined") || $value == "")
			unset($_REQUEST[$key]);
	}

	$queryString = "SELECT * FROM es_trabalho_caint
		INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho_caint.fgk_status
		WHERE es_trabalho_caint.fgk_evento = ?";

	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho_caint.nome_aluno 			LIKE ? OR
			es_trabalho_caint.curso_aluno 			LIKE ? OR
			es_trabalho_caint.cidade_destino		LIKE ? OR
			es_trabalho_caint.pais_destino 			LIKE ? OR
			es_trabalho_caint.curso_destino 		LIKE ? OR
			es_trabalho_caint.universidade_destino	LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}

	if(isset($_REQUEST['cpf'])){
		$cpf = $_REQUEST['cpf'];
		$queryString.= " AND es_trabalho_caint.cpf LIKE ?";
		$filtros[] = $cpf;
	}
	if(isset($_REQUEST['nome_aluno'])){
		$nome_aluno = $_REQUEST['nome_aluno'];
		$queryString.= " AND es_trabalho_caint.nome_aluno = ?";
		$filtros[] = $nome_aluno;
	}
	if(isset($_REQUEST['curso_aluno'])){
		$curso_aluno = $_REQUEST['curso_aluno'];
		$queryString.= " AND es_trabalho_caint.curso_aluno = ?";
		$filtros[] = $curso_aluno;
	}
	if(isset($_REQUEST['universidade_destino'])){
		$universidade_destino = $_REQUEST['universidade_destino'];
		$queryString.= " AND es_trabalho_caint.universidade_destino = ?";
		$filtros[] = $universidade_destino;
	}
	if(isset($_REQUEST['tempo_afastamento'])){
		$tempo_afastamento = $_REQUEST['tempo_afastamento'];
		$queryString.= " AND es_trabalho_caint.tempo_afastamento = ?";
		$filtros[] = $tempo_afastamento;
	}
	if(isset($_REQUEST['fgk_status'])){
		$fgk_status = $_REQUEST['fgk_status'];
		$queryString.= " AND es_trabalho_caint.fgk_status = ?";
		$filtros[] = $fgk_status;
	}

	$query = $db->sql_query($queryString, $filtros);

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'CPF')
		->setCellValue('B1', 'NOME')
		->setCellValue('C1', 'CURSO')
		->setCellValue('D1', 'PERIODO')
		->setCellValue('E1', 'PAÍS DESTINO')
		->setCellValue('F1', 'CIDADE DESTINO')
		->setCellValue('G1', 'UNIVERSIDADE DESTINO')
		->setCellValue('H1', 'CURSO DESTINO')
		->setCellValue('I1', 'TIPO MOBILIDADE')
		->setCellValue('J1', 'AFASTAMENTO')
		->setCellValue('L1', 'SITUAÇÂO')
		->setCellValue('M1', 'Quais são áreas/cursos de destaque da Universidade em que você esteve?')
		->setCellValue('N1', 'Fale sobre a questão linguística na Universidade de destino: se haviam cursos de idiomas, como funcionavam, se haviam disciplinas ofertadas em outros idiomas, a dificuldades enfrentadas.')
		->setCellValue('O1', 'Descreva o tipo de moradia que você utilizou durante sua mobilidade (gratuita ou não, compartilhada, demais ofertas de imóveis e possibilidades, valores, estrutura...).')
		->setCellValue('P1', 'Descreva como é o sistema de avaliação e notas da Universidade onde esteve (Formas de avaliação, grau de dificuldade, formas de preparação para as avaliações, curiosidades...).')
		->setCellValue('Q1', 'Descreva como é a dinâmica/metodologia das aulas na Universidade de destino. Fale sobre o formato das aulas, atividades práticas e teóricas, trabalhos em grupo, monitorias. Aproveite e faça um comparativo com o nosso modelo aqui na UFOP.')
		->setCellValue('R1', 'Descreva o custo de vida para um estudante na cidade/país onde você morou. Fale sobre alguns preços, comparativos, principais despesas, vantagens, desvantagens...')
		->setCellValue('S1', 'Fale sobre a infra estrutura da Universidade em que esteve: laboratórios, bibliotecas, centros esportivos, parte administrativa, salas de aula e estudo...')
		->setCellValue('T1', 'Como funciona o serviço de acolhimento e suporte a alunos estrangeiros na Universidade de destino?')
		->setCellValue('U1', 'Com relação ao estágio? Como ele é considerado e avaliado na Universidade onde estudou? E em relação à oferta? Como localizar um estágio? A Universidade dá algum suporte? Como foi a experiência ao realizar o estágio.')
		->setCellValue('V1', ' Quais atividades são oferecidas pela Universidade de destino: Fale sobre grupos de estudos, atividades de pesquisa, esporte, atividades culturais, lazer...')
		->setCellValue('W1', 'Como foi o seu processo de adaptação à cidade e ao país de destino? Dificuldades com clima, idioma, receptividade, inserção cultural.')
		->setCellValue('X1', 'Relato  pessoal.  Fale  sobre  a  sua  experiência  pessoal  de  maneira  geral,  sobre  demais  atividades acadêmicas,  esportivas, culturais que desenvolveu, experiências profissionais,  amadurecimento, rede  decontatos  (tente  priorizar  as  atividades  relacionadas  à  sua  formação  pessoal,  acadêmica  e  profissional,evitando expor elementos exclusivamente de entreterimento).')
		->setCellValue('Y1', 'Quais conselhos você poderia dar para um calouro que quer se preparar para fazer mobilidade na mesma Universidade/país que você esteve?');
	$linha = 1;

	$objPHPExcel->setActiveSheetIndex(0)->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	foreach ($query as $res){
		$linha++;

		if($res->tipo_mobilidade == 1) 
			$tipo_mobilidade = "Ciência sem Fronteiras";
		else 
			$tipo_mobilidade = "Mobilidade CAINT";

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $res->cpf);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $res->nome_aluno);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linha, $res->curso_aluno);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linha, $res->periodo_cursava);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linha, $res->pais_destino);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linha, $res->cidade_destino);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linha, $res->universidade_destino);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linha, $res->curso_destino);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $linha, $tipo_mobilidade);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $linha, $res->tempo_afastamento." meses");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $linha, $res->descricao_status);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $linha, $res->curso_area_destaque);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $linha, $res->questoes_linguisticas);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $linha, $res->tipo_moradia);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $linha, $res->sistema_avaliacao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $linha, $res->dinamica_metodologia_aulas);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $linha, $res->custo_vida);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $linha, $res->infra_universidade);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $linha, $res->servico_acolhimento);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $linha, $res->estagio);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $linha, $res->atividades_universidade);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $linha, $res->processo_adaptacao);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $linha, $res->relato_pessoal);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $linha, $res->conselhos_calouro);

	}

	$objPHPExcel->getActiveSheet()->setTitle('Trabalhos SEINTER');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(45);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(50);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit();
?>