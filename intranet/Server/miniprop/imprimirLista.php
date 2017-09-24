<?php
header('Content-Type: application/json; charset=utf-8');
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
	$id_minicurso	= preg_replace("/[^0-9]+/", "", $_REQUEST['id']);
	$filtros = array();
	$queryString = "
		SELECT * FROM es_minicursos WHERE id = ?
	";
	$filtros[] = $id_minicurso;
	$query = $db->sql_query2($queryString, $filtros);
	foreach ($query as $minicurso){
		$titulo = $minicurso->titulo;
		$apresentador = $minicurso->apresentador;
	}
	$filtros = array();
	$queryString = "
		SELECT es_minicursos_inscritos.*, es_inscritos.nome, es_inscritos.email, es_servicos.descricao_servico, es_inscritos_servicos.bool_pago
		FROM es_minicursos_inscritos
		 INNER JOIN es_inscritos_servicos ON es_inscritos_servicos.id_inscrito_servico = es_minicursos_inscritos.fgk_inscrito_servico
	     	 INNER JOIN es_inscritos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito
	     	 INNER JOIN es_servicos ON es_servicos.id_servico = es_inscritos_servicos.fgk_servico
		 INNER JOIN es_minicursos ON es_minicursos.id = es_minicursos_inscritos.fgk_minicurso
		WHERE es_minicursos_inscritos.fgk_minicurso = ? AND es_inscritos_servicos.bool_pago > 0
		ORDER BY es_inscritos.nome ASC
	";
	$filtros[] = intval($id_minicurso);
	$query = $db->sql_query2($queryString, $filtros);
	$total = $query->rowCount();
	$conteudo = '
		<table >
			<tr>
				<td colspan="2" align="center"><h2>'.$titulo.'</h2></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><p>&nbsp;</p></td>
			</tr>
		</table>
		<table border="1" cellpadding="3">
			<tr>
				<td coolspan="2" align="center"><b>Lista de presença</b></td>
			</tr>
	';
	foreach ($query as $inscritos){
		$conteudo .= '
			<tr>
				<td width="70%">'.$inscritos->nome.'</td>
				<td width="30%"></td>
			</tr>
		';
	}
	$conteudo .= '
		<tr><td colspan="2" align="right">Total: '.$total.'</td></tr>
		</table>
	';

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
	$pdf->SetMargins(10, PDF_MARGIN_TOP, 10, PDF_MARGIN_FOOTER);
	$pdf->SetHeaderMargin(10);
	$pdf->SetFooterMargin(10);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->AddPage('','A4', true, false);
	$pdf->SetFont('helvetica', '', 12);

	// $pdf->write1DBarcode($codigoDeBarras, 'C128C',$x=1,$y=1,  '', 8, 0.4,"", 'N');
	// $pdf->Cell(0, 0, $codigoDeBarras, 0, 1);





	$pdf->writeHTML($conteudo, true, true, true, false, '');
	$pdf->lastPage();
	$pdf->Output('lista_presenca.pdf', 'I');

}
else {
   header('Location: ../../index.php');
}
?>
