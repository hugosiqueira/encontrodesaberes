<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel='stylesheet' type='text/css' >
  <?php include "bibliotecas.php"; ?>
	<script type="text/javascript" language="javascript" src="plugins/datatables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="plugins/datatables/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="plugins/datatables/resources/demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#anais').dataTable({
		 "order": [[ 4, "desc" ]]
	});
} );
</script>
  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Anais do SEIC - UFOP - ISSN: 21763410</span> 
          <small>Veja os anais das edi&ccedil;&otilde;es anteriores</small>

        </h2>

      </div>

    </div>

  </div>
<div id="content">

    <div class="container">
    	
		<div class="row">
			<div class="col-md-6">
				<p id="area"></p>
				<p id="titulo"></p>
				<p id="autores"></p>
				<p id="ano"></p>
			</div>
		    <div class="col-md-12">
		    	
			    <table id ="anais" class="table table-striped table-bordered display" data-toggle="table">
			    	<thead>
			    		<tr class="danger"><th></th>
			    			<th>Área</th>
			    			<th>Título</th>
			    			<th>Autores</th>
			    			<th>Ano</th>
			    			<th>PDF</th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<?php
			    			$stmt = $db->sql_query("SELECT es_anais_trabalho.*, es_evento.edicao, es_area_especifica.descricao_area_especifica as subarea, es_ufop_areas.descricao_area as area
													FROM es_anais_trabalho
													LEFT JOIN es_evento ON es_evento.id = es_anais_trabalho.fgk_evento
													LEFT JOIN es_area_especifica on es_anais_trabalho.fgk_area_especifica = es_area_especifica.id
													LEFT JOIN es_ufop_areas ON es_area_especifica.fgk_area = es_ufop_areas.id_area
													order by es_evento.edicao DESC");
			    			foreach ($stmt as $trabalho) {
			                    echo '
			                    <tr><td><a href="exibir_trabalho.php?id='.$trabalho->id.'"><img src="img/info.png" /></a></td>
					    			<td>'.$trabalho->area.' - '.$trabalho->subarea.'</td>
						            <td><a href="exibir_trabalho.php?id='.$trabalho->id.'">'.$trabalho->titulo.'</a></td><td>';
						            $stmt_autor = $db->sql_query("SELECT * FROM es_anais_trabalho_autor WHERE fgk_trabalho_anais = ? ORDER BY seq ASC", array('fgk_trabalho_anais'=>$trabalho->id));
						            foreach ($stmt_autor as $autor) {
						            	if($autor->seq == 1)
						            		echo $autor->nome_citacao;
						            	else
						            		echo ','.$autor->nome_citacao;
						            }

						            echo '</td>
						            <td data-value='.$trabalho->edicao.'>'.$trabalho->edicao.'</td>
						            <td><a href="gerar_pdf.php?id='.$trabalho->id.'"><img src="img/pdf.jpg" /></a></td>
						        </tr>';
			                }
			    		?>
			    	</tbody>
			    	
			    </table>
			</div>
		</div>
	</div>
</div>

</div>

</div>


  
  <?php include ("footer.php");?>
