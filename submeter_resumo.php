<?php include ("header.php");?>
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

          <span>Submeter Resumo</span> 

        </h2>

      </div>

    </div>

  </div>
<div id="content">

    <div class="container">
    	
		<div class="row">
			<p class="text-justify">Para submeter o seu resumo, acesse o sistema com seu login e senha cadastrados. Se você ainda n&atilde;o possui o cadastro, clique<a href="cadastros.php"> aqui</a>, e realize o seu cadastro!</p> 
      <div class="col-md-6 text-center" style="float: none;margin:0 auto;"><?php include "form_login.php";?></div>

		</div>
	</div>
</div>

</div>

</div>


  
  <?php include ("footer.php");?>