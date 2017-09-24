<?php
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
require_once '../../includes/functions.php';
require_once('../../includes/db_connect.php');
require_once('../../includes/tcpdf/tcpdf.php');
require_once('../../includes/tcpdf/tcpdf_autoconfig.php');
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
	// $id_minicurso	= preg_replace("/[^0-9]+/", "", $_REQUEST['id']);

	$filtros = array();
	$queryString = "
		SELECT es_trabalho.*, es_inscritos.nome AS nome_avaliador, es_sessao.nome AS nome_sessao, es_ufop_areas.codigo_area, es_ufop_areas.descricao_area, es_trabalho_apresentacao.cod_poster, es_sessao.hora_ini, es_sessao.hora_fim, es_trabalho_autor.nome AS nome_apresentador
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

	$pdf->SetFont('helvetica', '', 9);
	// $pdf->write1DBarcode($codigoDeBarras, 'C128C',$x=1,$y=1,  '', 8, 0.4,"", 'N');
	// $pdf->Cell(0, 0, $codigoDeBarras, 0, 1);


	$sessao_atual = "";
	$ava_atual = "";
	$x=0;
	foreach ($query as $trabalhos){
		$pdf->AddPage('','A4', true, false);
		$conteudo = '
			<table>
				<tr >
					<td  align="center"><h2>'.$trabalhos->titulo_enviado.'</h2></td>
				</tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr >
					<td><b>POSTER: </b>'.$trabalhos->cod_poster.' ('.$trabalhos->descricao_area.')</td>
				</tr>
				<tr >
					<td><b>AVALIADOR: </b>'.$trabalhos->nome_avaliador.'</td>
				</tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr>
					<td><b>APRESENTADOR: </b>'.$trabalhos->nome_apresentador.'</td>
				</tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr>
					<td><b>AUTORES: </b>';
		$filtrosAutor = array();
		$queryAutores = "
			SELECT es_trabalho_autor.*, es_tipo_autor.descricao_tipo
			FROM es_trabalho_autor
			 INNER JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
			WHERE es_trabalho_autor.fgk_trabalho = ?
			ORDER BY ordenacao, nome
		";
		$filtrosAutor[] = intval($trabalhos->id);
		$queryAutores = $db->sql_query2($queryAutores, $filtrosAutor);
		foreach ($queryAutores as $autores){
			$conteudo .= '
				<br>'.$autores->nome.' ('.$autores->descricao_tipo.')
			';
		}

		$conteudo .= '
					</td>
				</tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr ><td><p>&nbsp;</p></td></tr>
				<tr >
					<td align="justify">'.$trabalhos->resumo_revisado.'</td>
				</tr>
			</table>
		';
		$pdf->writeHTML($conteudo, true, true, true, false, '');
	}
	$pdf->lastPage();
	$pdf->Output('resumo.pdf', 'I');

}
else {
   header('Location: ../../index.php');
}
?>
