<?php include ("header.php");
$cpf = filter_input(INPUT_GET, 'cpf');
?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel='stylesheet' type='text/css' >
  <?php include "bibliotecas.php"; ?>
	<script type="text/javascript" language="javascript" src="plugins/datatables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="plugins/datatables/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="plugins/datatables/resources/demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#anais').dataTable(
		
		);
} );
</script>
  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Certificados </span> 
          <small>Imprima seu certificado</small>

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
			    		<tr class="danger">
			    			<th>Evento</th>
			    			<th>Tipo de Certificado</th>
			    			<th>Edição</th>
			    			<th>Nome</th>
			    			<th>PDF</th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<?php
			    			$stmt = $db->sql_query("SELECT *
														FROM es_certificados
														INNER JOIN es_evento ON es_evento.id = es_certificados.fgk_evento 
														INNER JOIN es_certificados_tipos ON es_certificados.fgk_tipo = es_certificados_tipos.id_tipo_certificado
														WHERE cpf = ?", array('cpf'=>$cpf));
			    			foreach ($stmt as $certificado) {
			                    echo '
			                    <tr>
			                    	<td>'.$certificado->titulo.'</td>
			                    	<td>'.$certificado->descricao_certificado.'</td>
					    			<td>'.$certificado->edicao.'</td>
					    			<td>'.$certificado->nome.'</td>
						            <td><a href="gerar_certificado.php?c='.$certificado->chave_autenticidade.'" target="_blank"><img src="img/pdf.jpg" /></a></td>
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