<?php include ("header.php");
$cpf = filter_input(INPUT_GET, 'cpf');
?>
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
			<form id="form_trabalho" name="form_trabalho" method="get" action="certificados.php">
				<div class="col-md-6">
					 <div class="form-group">
		                <label for="aluno">Digite seu CPF</label>
		                <input type="text" class="form-control" id="cpf" name="cpf" data-mask="000.000.000-00">
		                <p class="help-block"></p>
		            </div>
		            <input type="submit" id="enviar" class="btn btn-success" value="Buscar certificados" />
				</div>
			</form>

		</div>
	</div>
</div>

</div>

</div>


  
  <?php 
  include "bibliotecas.php"; 
  include ("footer.php");
  ?>