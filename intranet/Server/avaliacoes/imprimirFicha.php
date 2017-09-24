<?php
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
require_once '../../includes/functions.php';
require_once('../../includes/db_connect.php');
require_once('../../includes/tcpdf2/examples/tcpdf_include.php');
require_once('../../includes/tcpdf2/tcpdf.php');

sec_session_start();

class MYPDF extends TCPDF {
	// Page footer
	public function Header() {
		// Page number
		$this->Cell(0, 0, $_SESSION['titulo_evento_atual'], 0, false, 'R', 0, '', 0, false, 'C', 'M');
	}
	public function Footer() {
		// Page number
		$this->Cell(0, 10, date("d/m/Y"), 0, false, 'L', 0, '', 0, false, 'C', 'M');
		$this->Cell(0, 10, " Sistema de Gestão - Encontro de Saberes", 0, false, 'R', 0, '', 0, false, 'C', 'M');
	}
}

if(login_check($db)){
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$filtros = array();
	$queryString = "
		SELECT es_trabalho.*, es_inscritos.nome AS nome_avaliador, es_sessao.nome AS nome_sessao, es_ufop_areas.codigo_area, es_trabalho_apresentacao.cod_poster, es_trabalho_apresentacao.id AS id_apresentacao, es_sessao.hora_ini, es_sessao.hora_fim, es_trabalho_autor.nome AS nome_apresentador
		FROM es_trabalho_apresentacao
		 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		  LEFT JOIN es_trabalho_autor ON es_trabalho_autor.fgk_trabalho = es_trabalho.id AND es_trabalho_autor.bool_apresentador = 1
		  INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 INNER JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
		  INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		 INNER JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
		WHERE es_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.titulo_enviado LIKE ? OR
			es_trabalho.palavras_chave LIKE ? OR
			es_inscritos.nome LIKE ? OR
			es_trabalho_apresentacao.cod_poster LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}

	if(isset($_REQUEST['pa'])&&($_REQUEST['pa']=='1')){
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
		if(isset($_REQUEST['status'])&&($_REQUEST['status']!='')){
			$status = $_REQUEST['status'];
			if($status == "1")
				$queryString.= " AND es_trabalho_apresentacao.status = 1";
			else if($status == "0")
				$queryString.= " AND es_trabalho_apresentacao.status = 0";
			else if($status == "2")
				$queryString.= " AND es_trabalho_apresentacao.status = 2";
		}
	}
	$queryString.=" ORDER BY es_sessao.nome, es_inscritos.nome";
	$query = $db->sql_query2($queryString, $filtros);
	$total = $query->rowCount();



	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('');
	$pdf->SetTitle('');
	$pdf->SetSubject('');
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	$pdf->SetMargins(10, PDF_MARGIN_TOP-10, 10, PDF_MARGIN_FOOTER);
	$pdf->SetHeaderMargin(10);
	$pdf->SetFooterMargin(10);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


	$pdf->AddPage('L','A4', true, false);
	$pdf->SetFont('helvetica', '', 9);

	$conteudo = '';
	$sessao_atual = "";
	$ava_atual = "";
	$x=0;
	foreach ($query as $trabalhos){
		if ($sessao_atual != $trabalhos->nome_sessao){
			$sessao_atual = $trabalhos->nome_sessao;
			$hora_ini = $trabalhos->hora_ini;
			$hora_fim = $trabalhos->hora_fim;
			$printa = 1;
		}
		if ($ava_atual != $trabalhos->nome_avaliador){
			$ava_atual = $trabalhos->nome_avaliador;
			$printa = 1;
		}
		if($printa == 1){
			if($x!=0){
				$pdf->writeHTML($conteudo, true, true, true, false, '');
				$conteudo = '';
				$pdf->AddPage('L','A4', true, false);
			}
			$conteudo .= '
				<table cellpadding="3">
					<tr colspan="2">
						<td  align="center"><h2>FORMULÁRIO DE AVALIAÇÃO</h2></td>
					</tr>
					<tr colspan="2">
						<td align="center"><h2>'.$sessao_atual.' '.$hora_ini.' - '.$hora_fim.'</h2></td>
					</tr>
					<tr colspan="2"><td><p>&nbsp;</p></td></tr>
					<tr>
						<td width="50%" align="justify">
							<b>INSTRUÇÕES:</b><br>
							<b>1.</b> Favor pontuar os itens de avaliação de A a E, atribuindo-lhes notas de 0 a 10<br>
							<b>2.</b> Caso o apresentador seja diferente do informado, favor marcar o nome do apresentador dentre os autores do trabalho e solicitar que o mesmo assine o verso da ficha. O certificado de apresentação será encaminhado automaticamente para o email do apresentador informado assim que a avaliação for registrada no sistema.<br>
							<b>3.</b> Não avalie trabalhos de sua autoria ou co-autoria, solicite à Coordenação a indicação de outro avaliador<br>
						</td>
						<td  width="50%" align="justify">
							<table border="1" cellpadding="5">
							<tr><td>
							<b>Critérios para notas:</b><br>
							<b>A.</b> Formato do pôster: clareza e objetividade<br>
							<b>B.</b> Clareza na apresentação (linguagem, domínio do assunto)<br>
							<b>C.</b> Adequação da metodologia aos objetivos<br>
							<b>D.</b> Adequação dos resultados e conclusões aos objetivos<br>
							<b>E.</b> Relevância do trabalho na formaçãoacadêmica e científica do(a) aluno(a)
							</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr colspan="2"><td><p>&nbsp;</p></td></tr>
					<tr>
						<td width="55%"><h3>'.$ava_atual.'</h3></td>
						<td width="45%"><h3>ASSINATURA: ____________________________________________</h3></td>
					</tr>
					<tr colspan="2"><td><p>&nbsp;</p></td></tr>
				</table>
				<table border="1" cellpadding="3">
					<tr>
						<td width="10%" align="center" rowspan="2" valign="bottom"><b>COD</b></td>
						<td width="35%" align="center" rowspan="2" valign="center"><b>Apresentador</b></td>
						<td width="30%" align="center" rowspan="2"><b>Titulo</b></td>
						<td width="25%" align="center" colspan="5"><b>Notas</b></td>
					</tr>
					<tr>
					  <td align="center">A</td>
					  <td align="center">B</td>
					  <td align="center">C</td>
					  <td align="center">D</td>
					  <td align="center">E</td>
					</tr>
				</table>
			';
			$printa = 0;
			$x=1;
		}
		$filtrosAutor = array();
		$queryAutores = "
			SELECT es_trabalho_autor.*, es_tipo_autor.descricao_tipo, es_tipo_autor.sigla
			FROM es_trabalho_autor
			 INNER JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
			WHERE es_trabalho_autor.fgk_trabalho = ?
			ORDER BY ordenacao, nome
		";
		$filtrosAutor[] = intval($trabalhos->id);
		$queryAutores = $db->sql_query2($queryAutores, $filtrosAutor);
		$apresentadores_d_b = "";
		foreach ($queryAutores as $autores){
			if($autores->bool_apresentador == 1)
				$apresentadores_d_b.= '(&nbsp;X&nbsp;) '.strtoupper($autores->nome).' ('.$autores->sigla.')<br>';
			else
				$apresentadores_d_b.= '(&nbsp;&nbsp;&nbsp; ) '.strtoupper($autores->nome).' ('.$autores->sigla.')<br>';
		}
		$params = $pdf->serializeTCPDFtagParameters(array($trabalhos->id_apresentacao, 'C128', '', '', 26, 10, 1,'', 'N'));
		$conteudo.= '
			<table border="1" cellpadding="3" style="vertical-align:middle;">
				<tr>
					<td width="10%" align="center" >'.$trabalhos->cod_poster.'<br><tcpdf method="write1DBarcode" params="'.$params.'" /></td>
					<td width="35%" >'.$apresentadores_d_b.'</td>
					<td width="30%" align="justify" >'.$trabalhos->titulo_enviado.'</td>
					<td width="5%" align="center" ></td>
					<td width="5%" align="center" ></td>
					<td width="5%" align="center" ></td>
					<td width="5%" align="center" ></td>
					<td width="5%" align="center" ></td>
				</tr>
			</table>
		';
	}
	$conteudo.= '
		<table cellpadding="3" style="vertical-align:middle;">
			<tr>
				<td width="100%">
					<b>Legenda tipo autor:</b><br>
					A = Autor / O = Orientador / CA = Co-Autor / CO = Colaborador
				</td>
			</tr>
		</table>
	';
	$pdf->writeHTML($conteudo, true, true, true, false, '');
	$pdf->lastPage();
	$pdf->Output('ficha_apresentacao.pdf', 'I');

}
else {
   header('Location: ../../index.php');
}
?>
