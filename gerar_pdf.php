<?php 
include "../config.php";
$id = $_GET['id'];
$sql_trabalho = "SELECT es_anais_trabalho.*, es_evento.edicao, es_area_especifica.descricao_area_especifica as subarea, es_ufop_areas.descricao_area as area
							FROM es_anais_trabalho
							LEFT JOIN es_evento ON es_evento.id = es_anais_trabalho.fgk_evento
							LEFT JOIN es_area_especifica on es_anais_trabalho.fgk_area_especifica = es_area_especifica.id
							LEFT JOIN es_ufop_areas ON es_area_especifica.fgk_area = es_ufop_areas.id_area
					WHERE es_anais_trabalho.id = ?";
$trabalho = $db->sql_query($sql_trabalho, array('es_anais_trabalho.id'=>$id));
foreach ($trabalho as $registro) {
	$resumo = $registro->resumo;
	$titulo = $registro->titulo;
	$ano = $registro->edicao;
	$area = $registro->area;
	$subarea = $registro->subarea;
	$edicao = $registro->edicao;
}
$html ='<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		    		<table class="table"  style="border: 1px solid red;">
			        	<tr><td class="text-center" style="font-weight: bold; padding: 10px;">XXIII Seminário de Iniciação Ciéntifica da UFOP</td></tr>
			        </table>

			    	<table class="table">
			        	<tr><td class="text-justify" style="font-weight: bold;">'.$titulo.'</td></tr>
			        </table>

			        <table class="table">
			        	<tr>
			        		<td>';

			        		 $stmt_autor = $db->sql_query("SELECT * FROM es_anais_trabalho_autor INNER JOIN es_tipo_autor ON fgk_tipo = id_tipo_autor WHERE fgk_trabalho_anais = ? ORDER BY seq ASC", array('fgk_trabalho_anais'=>$id));
						            foreach ($stmt_autor as $autor) {
						            	$instituicao = $autor->instituicao;
						            	if($autor->seq == 1)
						            		$html .= $autor->nome.' ('.$autor->descricao_tipo.')';
						            	else
						            		$html .= ', '.$autor->nome.' ('.$autor->descricao_tipo.')';

						            }

						    $html .= '</td></tr>
			        </table>

			        <table class="table">
			        	<tr><td class="text-justify">'.$resumo.'</td></tr>
			        </table>
			        <p>Instituição de Ensino: '.$instituicao;


  define('MPDF_PATH', 'plugins/mpdf/');
  include(MPDF_PATH.'mpdf.php');
  $mpdf=new mPDF();
  $mpdf->SetFooter('ISSN: 21763410');
  $mpdf->WriteHTML($html);
  $mpdf->Output();
  exit();