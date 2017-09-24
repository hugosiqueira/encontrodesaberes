<?php include "header.php"; ?>
<div id="highlighted">

    <div class="container">

        <div class="header">

            <h2 class="page-title">

                <span>Ativação do E-mail</span> 
                <small>Verificação se o e-mail é válido</small>
            
            </h2>

        </div>

    </div>

</div>
<div id="content">

    <div class="container">
    	<?php 
    		//include "../config.php";

			$email_descriptografado  = base64_decode( $_GET['token'] );

			try{
  						$atualizar_email = $db->atualizar('es_inscritos', array('conta_ativada'=> 1), 'email', $email_descriptografado);
  						
                echo '<div class="alert alert-success">
  							<button type="button" class="close" data-dismiss="alert">&times;</button>
  							<h4>Sucesso</h4>
  							Seu e-mail foi ativado com sucesso. Aguarde você será redirecionado para a pagina de login.
  							</div>
							<meta http-equiv=refresh content=3;URL=login.php />
                ';

  					
  						/*	echo '<div class="alert alert-error">
  							<button type="button" class="close" data-dismiss="alert">&times;</button>
  							<h4>Atenção</h4>
  							E-mail não está cadastrado em nosso sistema!
  							</div>';*/
  						
  					} catch(PDOException $e){
  						echo '<div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Atenção</h4>
                E-mail não está cadastrado em nosso sistema!
                </div>
                <meta http-equiv=refresh content=3;URL=login.php />';
  					}

    	?>
       

    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">         
          <div class="modal-body">                
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  
</div>



      </div>

    </div>

  </div>

  <?php include "bibliotecas.php"; ?>
  
  <?php include ("footer.php");?>