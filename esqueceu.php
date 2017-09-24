<?php
session_start();
include ("header.php");
?>
<div id="highlighted">

  <div class="container">

    <div class="header">

      <h2 class="page-title">

        <span>Área Restrita</span> 
        <small>Faça seu login para acessar o sistema</small>

      </h2>

    </div>

  </div>

</div>
<div id="content">

  <div class="container">
    <div class="row">
      <div class="col-md-6 text-center" style="float: none;margin:0 auto;">
        <form id="esqueceu" action="javascript:void(0);">
          <fieldset>

            <h2>Esqueci minha senha</h2>

            <hr class="colorgraph">
            <div id="aguarde" class="modal fade modal" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Encontro de Saberes</h4>
                  </div>
                  <div class="modal-body">
                    Aguarde, enviando...
                  </div>
                </div>

              </div>
            </div>
            <div id="sucesso"></div>
            <div class="form-group">

              <input type="text" name="cpf" id="cpf" data-mask="000.000.000-00" class="form-control input-lg" placeholder="Digite seu cpf">

            </div>
            <hr class="colorgraph">
            <div id="loading" style="display: none;">Carregando...</div>
            <?php if ( ! empty( $_SESSION['login_erro'] ) ) :?>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?= $_SESSION['login_erro']; ?>
            </div>
            <?php $_SESSION['login_erro'] = ''; ?>
          <?php endif; ?>
          <?php
          $erro = isset($_GET['erro']) ? $_GET['erro'] : ''; 
          if($erro == 1)
            echo '<div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              CPF não cadastrado em nosso sistema.
            </div>';
          ?>
          <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-6">

              <button id="btn_email" class="btn btn-lg btn-success btn-block" type="submit">Recuperar pelo e-mail</button>

            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">


            </div>

          </div>

        </fieldset>

        

      </form>
    </div>
  </div>
</div>

</div>

<?php include "bibliotecas.php"; ?>
<script type="text/javascript">

$(document).ready(function() {
  $("#btn_email").click(function(){
    $("#esqueceu").submit(function() {
    var cpf = $("input[name=cpf]").val();
    window.location="recuperar_senha.php?tipo=email&cpf="+cpf;
  });
    });

  $("#btn_sms").click(function(){
    $("#esqueceu").submit(function() {
    var cpf = $("input[name=cpf]").val();
    window.location="recuperar_senha.php?tipo=sms&cpf="+cpf;
});

  });
});

</script>
<?php include "footer.php"; ?>
