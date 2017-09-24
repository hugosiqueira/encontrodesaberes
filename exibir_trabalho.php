<?php include ("header.php");
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
?>
<link href="css/footable.core.css" rel="stylesheet" type="text/css" />
  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Trabalhos nos anais do SEIC</span> 
          <small>Veja o resumo do trabalho</small>

        </h2>

      </div>

    </div>

  </div>
<div id="content">

    <div class="container">
    	<div class="col-md-12">
            <div class="row">
            	<p>Publicado no <?=$edicao; ?> SEIC, em <?=$ano?>. </p>
            	<p><strong>Área: </strong><?=$area;?></p>
            	<p><strong>Subárea:</strong><?=$subarea;?> </p>
		    	

			    	<table class="table table-bordered table-hover">
			        	<tr class="danger"><td>Título</td></tr>
			        	<tr><td><?=$titulo;?></td></tr>
			        </table>

			        <table class="table table-bordered table-hover">
			        	<tr class="danger"><td>Autores</td></tr>
			        	<tr>
			        		<td>
			        		<?php
			        		 $stmt_autor = $db->sql_query("SELECT * FROM es_anais_trabalho_autor INNER JOIN es_tipo_autor ON fgk_tipo = id_tipo_autor WHERE fgk_trabalho_anais = ? ORDER BY seq ASC", array('fgk_trabalho_anais'=>$id));
						            foreach ($stmt_autor as $autor) {
						            	if($autor->seq == 1)
						            	echo '<strong>'.$autor->nome.' ('.$autor->descricao_tipo.')</strong><br>';
						            	else
						            		echo $autor->nome.' ('.$autor->descricao_tipo.')<br>';

						            }
						    ?>
						    </td></tr>
			        </table>

			        <table class="table table-bordered table-hover">
			        	<tr class="danger"><td class="text-justify">Resumo</td></tr>
			        	<tr><td><?=$resumo;?></td></tr>
			        </table>
				<a href="javascript:window.history.go(-1)" class="btn btn-danger">Voltar</a>
				<a href="gerar_pdf.php?id=<?=$id;?>" class="btn btn-danger pull-right" target="_blank">Visualizar PDF</a>
			       
			       
			
		</div>
	</div>
</div>

</div>

</div>


  <?php include "bibliotecas.php"; ?>

  <?php include ("footer.php");?>