<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	require_once('../../includes/functions.php');
	require_once('../../includes/tcpdf/tcpdf.php');
	require_once('../../includes/tcpdf/tcpdf_autoconfig.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$params = $_POST['param'];
		$dados = json_decode($params);

	$queryInscritos = "SELECT es_inscritos.nome, es_inscritos_tipos.descricao_tipo, es_instituicao.nome AS nome_instituicao, es_instituicao.sigla AS sigla_instituicao,
		SUM(CASE WHEN es_inscritos_servicos.bool_pago = 1 THEN 1 ELSE 0 END) serv_pg,
		SUM(CASE WHEN es_inscritos_servicos.fgk_inscrito = es_inscritos.id THEN 1 ELSE 0 END) servs, 
		IF(es_presencas.fgk_inscrito, 1, 0) AS credencial, 
		COUNT(es_inscritos_servicos.fgk_inscrito) AS num_servicos
		FROM es_inscritos 
		INNER JOIN es_instituicao ON es_inscritos.fgk_instituicao = es_instituicao.id
		INNER JOIN es_inscritos_tipos ON es_inscritos.fgk_tipo = es_inscritos_tipos.id_tipo_inscrito
		LEFT JOIN es_presencas ON es_inscritos.id = es_presencas.fgk_inscrito
		LEFT JOIN es_inscritos_servicos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito
		WHERE es_inscritos.fgk_evento = $id_evento ";

	if(isset($dados->cpf)){
		$cpf = $dados->cpf;
		$queryInscritos.=" AND es_inscritos.cpf = '$cpf'"; 
	}

	if(isset($dados->nome)){
		$nome = $dados->nome;
		$queryInscritos.=" AND es_inscritos.nome LIKE '%$nome%'"; 
	}

	if(isset($dados->tipo_inscrito)){
		$tipo_inscrito = $dados->tipo_inscrito;
		queryInscritos.=" AND es_inscritos.fgk_tipo = $tipo_inscrito"; 
	}
	
	if(isset($dados->instituicao))
		$id_instituicao = $dados->instituicao;
	if(isset($dados->credenciado))
		$credenciado->credenciado;

	$total = $db->sql_query($queryInscritos);
	
	$queryInscritos.=" ORDER BY es_inscritos.nome ASC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryInscritos);

	$inscritos = array();
	foreach ($result as $inscrito){
		if($inscrito->num_servicos != 0)
			if($inscrito->serv_pg == $inscrito->servs)
				$inscrito->quite = 1;
			else
				$inscrito->quite = 0;
		else
			$inscrito->quite = 2;

		$inscritos[] = $inscrito;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"inscritos" => $inscritos
	));
	// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// // set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Encontro de Saberes'); 
// $pdf->SetTitle('Relatório');
// $pdf->SetSubject('Presenças');
// $pdf->SetKeywords('');

// // set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, 190, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);

// // set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// $pdf->setPrintFooter(true);

// // set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// //set margins
// $pdf->SetMargins(10, PDF_MARGIN_TOP+10, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// //set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// //set auto page breaks
// //$margin = $pdf->getFooterMargin();
// $pdf->SetAutoPageBreak(FALSE);

// //HTML CONTENT
// $html1= '
// <html>
// 	<head>
// 		<style type="text/css">
// 			.tg{
// 				border-collapse:collapse;
// 				border-spacing:0;
// 				border-color:#ccc;
// 				width: 100%;
//                 font-size:12px;
// 			}
				
// 			.tg td{
//                 text-align: center;
// 				font-family:Arial, sans-serif;
// 				border-style:solid;
// 				border-width:1px;
// 				overflow:hidden;
// 				word-break:normal;
// 				border-color:#ccc;
// 				color:#333;
// 				background-color:#fff;
// 				border-top-width:1px;
// 				border-bottom-width:1px;
// 			}
             
// 			.tg th{
//                 text-align: center;
// 				font-family:Arial, sans-serif;
// 				font-weight:normal;
// 				border-style:solid;
// 				border-width:1px;
// 				overflow:hidden;
// 				word-break:normal;
// 				border-color:#ccc;
// 				color: white;
// 				background-color:#5C5C5C;
// 				border-top-width:1px;
// 				border-bottom-width:1px;
// 			}
// 			.tg .tg-4eph{
// 				background-color:#ccc
// 			}
// 		</style>
// 	</head>
		
// 	<body>		
// 		<table class="tg">
// 			<tr>
// 			    <th class="tg-031e" style=" width: 272px">Inscritos</th>
// 			</tr>			
// 		</table>
// 	</body>
// </html>';

// $pdf->AddPage('P','A4', true, false);

// $pdf->writeHTMLCell( '0', '0', '9', '35', $html1, 0, 0, false, true, 'R', true);

// $pdf->lastPage();

// //Close and output PDF document
// $pdf->Output('Relatorio.pdf', 'I');
?>