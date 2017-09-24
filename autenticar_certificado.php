<?php include ("header.php");?>
  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Certificados</span> 
          <small>Imprima seu certificado</small>
          

        </h2>

      </div>

    </div>

  </div>
<div id="content">
    <div class="container">
        <div class="block">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="block-title sub-title">
                        <span>Verificar autenticidade: </span>
                    </h3>
                    <form id="autenticar" action="javascript:void(0);" />
                        <div class="form-group">
                            <label for="titulo">Código de autenticidade</label>
                            <input type="text" class="form-control"  id="codigo" required>
                            <p class="help-block"></p>
                        </div>
                        <button class="btn btn-danger" id="enviar">Autenticar</button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h3 class="block-title sub-title">
                        <span>Como achar meu código de autenticidade?</span>
                    </h3>
                    <img src="img/certificados/modelo2.jpg" class="img-responsive"/>
                    <br />
                    <img src="img/certificados/modelo.jpg" class="img-responsive"/>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>

  <?php include "bibliotecas.php"; ?>
  <script type="text/javascript">
  $(document).ready(function() {
    $("#enviar").click(function() {    
        if($("#codigo").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o código de autenticidade do seu certificado.',
                buttons: [{
                    id: 'btn-ok',   
                    icon: 'glyphicon glyphicon-check',       
                    label: 'OK',
                    cssClass: 'btn-primary', 
                    autospin: false,
                    action: function(dialogRef){    
                        dialogRef.close();
                    }
                }]
            });
            return;
        }

        $("#autenticar").submit(function(e) {
            var codigo = $("#codigo").val();
            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('verifica_autenticidade.php', {codigo: codigo }, 
                function(resposta) {
                     
                    if (resposta == "sucesso") {                           
                        location.href="gerar_certificado.php?c="+codigo;
                    } else {                            
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: 'O código informado está incorreto.',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href=location.href;
                                }
                            }]
                        });
                    }
                }
            );
        });
    });
});


  </script>
  
  <?php include ("footer.php");?>
