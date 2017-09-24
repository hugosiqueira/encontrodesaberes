<?php 
include "../config.php";
include('includes/phpqrcode/qrlib.php');
$c = filter_input(INPUT_GET, 'c');
$fundo = filter_input(INPUT_GET, 'f');

if($db->existe('es_certificados', array('chave_autenticidade'=>$c))){
	$sql_busca = "SELECT * FROM es_certificados WHERE es_certificados.chave_autenticidade = ? ";
	$certificado= $db->sql_query($sql_busca, array('es_certificados.chave_autenticidade'=>$c));
	foreach ($certificado as $registro) {
		$id_certificado = $registro->id_certificado;
		$id_tipo = $registro->fgk_tipo;
		$dizeres_certificado = $registro->dizeres_certificado;
		$chave_autenticidade = $registro->chave_autenticidade;
	}
 
	$codeContents = 'http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c='.$chave_autenticidade; 
	 
	QRcode::png($codeContents, 'img/certificados/qrcodes/'.$id_certificado.'.png', QR_ECLEVEL_L , 2); 

	$html = '<style>
		#wrap {
			left:50%;
			margin-top: 300px;
			margin-left:-175px; /* metade da largura fictícia */
			position:absolute;
			width:10px;
		}
		p {
			float:left; 
			line-height:30px; 
			text-align:center;
			font-size:22px; 
			font-family: Arial;
		}
		';
		if($fundo == 2)
			$html .='</style>';
		else 
			$html .='
		body { 
			background-image:url("img/certificados/tipos/'.$id_tipo.'.jpg"); 
			background-image-resize: 6;
		} 
		
		</style>
		';
			


	if($id_tipo != 2)
		$html .='<body>

		<div class="wrap">
			<p style="margin-left:250px; "><br><br><br><br><br><br><br><br>'.$dizeres_certificado.'</p>
		</div>
		<p style="position:absolute;left:5%;top:80%;font-size:11px; line-height:10px;">Autenticidade<br><img src="img/certificados/qrcodes/'.$id_certificado.'.png"><br>Código: '.$chave_autenticidade.'</p>
	</body>';

	else
		$html .='
		<body>

			<div class="wrap">
				<p>'.$dizeres_certificado.'</p>
			</div>
			<p style="margin-top: -20px;float: right;font-size:12px; text-align:right; line-height:10px">Autenticidade<br><img src="img/certificados/qrcodes/'.$id_certificado.'.png"><br>Código: '.$chave_autenticidade.'</p>
		</body>';


	  define('MPDF_PATH', 'plugins/mpdf/');
	  include(MPDF_PATH.'mpdf.php');
	  $mpdf=new mPDF('c','A4-L', 0, '', 15, 15, 16, 0, 9, 0); 
	  $mpdf->SetDisplayMode('fullwidth');
	  $mpdf->WriteHTML($html);
	  $mpdf->Output();
	  exit();
} else {
	Header("Location: http://www.encontrodesaberes.ufop.br/buscar_certificados.php");
}
