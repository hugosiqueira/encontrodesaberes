<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Encontro de Saberes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Intranet">
    <meta name="keywords" content="encontro, saberes, seic, intranet">
    <meta name="author" content="" charset="utf-8">
    <script type="text/JavaScript" src="includes/sha512.js"></script>
    <script type="text/JavaScript" src="includes/forms.js"></script> 
    <!-- Bootstrap core CSS -->
    <link href="resources/css/bootstrap/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" href="bootstrap.css">
	<script src="ext/ext-all-dev.js"></script>
	<script src="ext/locale/ext-lang-pt_BR.js"></script>
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery.mask.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="resources/css/login.css" rel="stylesheet">
    <link href="resources/css/animate-custom.css" rel="stylesheet">
</head>
<body>
<?php
	if(isset($_SESSION['erro'])){
		$erro = $_SESSION['erro'];
		// echo  $erro;
?>
<script>
Ext.onReady(function(){
	<?php
		if($erro == 1){
	?>		titulo = "Erro";
			mensagem = "Usuário não encontrado.";
	<?php
		}
		else if($erro == 2){
	?>		titulo = "Erro";
			mensagem = "Senha inválida.";
	<?php
		}
		else if($erro == 3){
	?>		titulo = "Erro";
			mensagem = "O usuário informado não possui nenhum evento vinculado.<br>Favor entrar em contato com o administrador do sistema.";
	<?php
		}
		else if($erro == 4){
	?>		titulo = "Erro";
			mensagem = "O grupo: <b><?php echo $_SESSION['grupo']; ?></b> está bloqueado.<br>Favor entrar em contato com o administrador do sistema.";
	<?php
		}
		else if($erro == 5){
	?>		titulo = "Erro";
			mensagem = "Este usuário está bloqueado.<br>Favor entrar em contato com o administrador do sistema.";
	<?php
		}
		else if($erro == 6){
	?>		titulo = "Erro";
			mensagem = "Este usuário foi bloqueado por motivos de segurança.<br>Tente novamente em 10 minutos. ";
	<?php
		}
		else{
	?>	titulo = "Erro";
		mensagem = "Erro desconhecido.";
	<?php
		}
	if( $erro > 0){
	?>
		Ext.Msg.alert({
			title: titulo,
			msg: mensagem,
			buttons: Ext.Msg.OK,
			icon: Ext.MessageBox.ERROR
		});
	<?php
	}
	?>
});
</script>
<?php
	}
?>
    <div class="container" id="login-block">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

                <div class="login-box clearfix animated flipInY">
					 <!-- TREM QUE PULA ! kkk
                    <div class="page-icon animated bounceInDown"></div>
                    <div class="login-logo" height="200"></div>
					<hr>
					-->                    
                    <div class="login-form">
                        <div class="alert alert-error hide">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?php
                            if (isset($_GET['error'])) {
                                echo '<h4>Erro!</h4>Dados Incorretos!</p>';
                            }
                            ?>

                        </div>
						<script>
							jQuery(function($){
								   $("#login").mask("999.999.999-99");
							});
						</script>
                        <form id ="frmLogin" action="includes/process_login.php" method="post" name="login_form">
                            <input placeholder="Usuário" class="input-field" required="" type="text" id="login" name="login">
                            <input placeholder="Senha" class="input-field" required="" type="password" id="password" name="password" onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { console.log(formhash(this.form, this.form.password)); }">
                            <input type="button" class="btn btn-login" onclick="formhash(this.form, this.form.password);" value="Entrar">
							<p id="footer-text"><small>Copyright © 2015 UFOP </a></small></p>
                        </form>
                        <!--
						<div class="login-links">
                            <a href="recuperar_senha.html">
                                Esqueceu sua senha?
                            </a>
                            <br>
                        </div>
						-->
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>
</html>