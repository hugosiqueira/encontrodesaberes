<?php

// Inclui o arquivo de configuração

include('../login/config.php');


// Inclui o arquivo de verificação de login

include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo

// Inclua o trecho abaixo, ele redireciona o usuário para 

// o formulário de login

include('../login/redirect.php');
  
if ( $_SESSION['logado'] === true ) {

    include "header.php";

    include "menu.php";



?> 

<style type="text/css">

    .box {

        margin: 10px 20px;

        display: inline-block;

    }

</style>

        <div class="modal fade" id="pagamento"  role="dialog" data-backdrop="static" aria-hidden="false">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">Conta não ativada - <?=CONTA_ATIVADA;?></h4>

                    </div>

                    <div class="modal-body">

                        <p>O Encontro de Saberes envia uma confirmação de cadastro no e-mail que você informou no ato cadastral. Acesse-o e clique no link para ativar o cadastro.</p>



                        <p>Se você não recebeu o e-mail de confirmação, clique no botão "Reenviar e-mail de ativação".</p>



                        <p>Importante: Alguns servidores de e-mails classificam as mensagens automáticas como "Lixo Eletrônico". </p>



                        <p>Caso esteja no lixo eletrônico, modifique as configurações de recebimento de mensagens automáticas para receber nosso e-mail de confirmação.</p>

                        <!--p>Se mesmo assim, você não receber o e-mail de confirmação, clique no botão "Não recebi o e-mail, enviar por sms".</p-->

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-success btn-large pull-left" id="button_ativar_email" type="submit">Reenviar e-mail de ativação</button>

                       <!--button class="btn btn-danger btn-large pull-left" id="button_ativar_sms" type="submit">Não recebi o e-mail, enviar por sms</button-->

                    </div>

                </div>

            </div>

        </div>



            <div class="page-inner">

                <div class="page-title">

                    <h3>Encontro de Saberes</h3>

                    <div class="page-breadcrumb">

                        <ol class="breadcrumb">

                            <li><a href="index.php">Página Inicial</a></li>

                        </ol>

                    </div>

                </div>

                <div id="main-wrapper">

                    <div class="row">



                        <div class="col-md-12">

                            <div class="panel panel-white">

                                <div class="panel-body text-center">

                                    <div class="box"><a href="perfil.php"><img src="assets/images/menu/ad.png" class="img-responsive" alt="Alterar dados pessoais" /></a></div>

                                    <?php if(TIPO_USUARIO != ADMINISTRADOR) { ?>

                                    <div class="box"><a href="pagamentos.php"><img src="assets/images/menu/pi.png" class="img-responsive" alt="Pagar Inscrição" /></a></div>

                                    <?php } ?>

                                     
                                    <div class="box"><a href="meus_resumos.php"><img src="assets/images/menu/trabalhos_submetidos.png" class="img-responsive" alt="Trabalhos Submetidos" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=1"><img src="assets/images/menu/seic.png" class="img-responsive" alt="Submeter resumo no SEIC" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho_sext.php"><img src="assets/images/menu/sext.png" class="img-responsive" alt="Submeter resumo no SEXT" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=7"><img src="assets/images/menu/pibid.png" class="img-responsive" alt="Submeter Resumos" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=6"><img src="assets/images/menu/monitoria.png" class="img-responsive" alt="Submeter Resumos" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=3"><img src="assets/images/menu/pro_ativa.png" class="img-responsive" alt="Submeter Resumos" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=9"><img src="assets/images/menu/pos_graduacao.png" class="img-responsive" alt="Submeter Resumos" /></a></div>
                                    <div class="box"><a href="cadastrar_trabalho.php?categoria=10"><img src="assets/images/menu/material.png" class="img-responsive" alt="Submeter Resumos" /></a></div>

                                    <?php if(TIPO_USUARIO  == ADMINISTRADOR || ( TIPO_USUARIO  == ALUNO_UFOP)|| ( TIPO_USUARIO  == TECNICO_UFOP) || ( TIPO_USUARIO  == PROFESSOR_UFOP)){ ?>

                                    <div class="box"><a href="mobilidade_cadastro.php"><img src="assets/images/menu/ss.png" class="img-responsive" alt="Mobilidade Academica" /></a></div>

									<?php } ?>

                                    <div class="box"><a href="correcoes.php"><img src="assets/images/menu/ct.png" class="img-responsive" alt="Corrigir Trabalhos" /></a></div>

                                    <?php  if(TIPO_USUARIO  == ADMINISTRADOR){ ?>

                                    <div class="box"><a href="proposta_minicurso.php"><img src="assets/images/menu/er.png" class="img-responsive" alt="Enviar propostas de minicursos" /></a></div>

                                    

                                     <?php } if(BOOL_COORDENADOR || TIPO_USUARIO  == ADMINISTRADOR){ ?>

                                    <div class="box"><a href="designar_avaliadores.php"><img src="assets/images/menu/da.png" class="img-responsive" alt="Designar Avaliadores" /></a></div>

                                    <?php } if(BOOL_COORDENADOR || TIPO_USUARIO  == ADMINISTRADOR || BOOL_REVISOR ) { ?>

                                    <div class="box"><a href="revisao_trabalhos.php"><img src="assets/images/menu/ep.png" class="img-responsive" alt="Revisar Trabalho" /></a></div>

                                    <?php } if(BOOL_COORDENADOR || TIPO_USUARIO  == ADMINISTRADOR){ ?>

                                    <div class="box"><a href="parecer.php"><img src="assets/images/menu/par.png" class="img-responsive" alt="Emitir parecer" /></a></div>

                                    <div class="box"><a href="parecer_final.php"><img src="assets/images/menu/epf.png" class="img-responsive" alt="Emitir parecer final" /></a></div>



                                    <?php } if(TIPO_USUARIO  == ADMINISTRADOR) { ?>

                                    <div class="box"><a href="../intranet/"><img src="assets/images/menu/aa.png" class="img-responsive" alt="Área Administrativa" /></a></div>

                                    <div class="box"><a href="minicursos.php"><img src="assets/images/menu/im.png" class="img-responsive" alt="Inscrever em minicursos" /></a></div>

                                    <?php } ?>

                                    <div class="box"><a href="duvidas.php"><img src="assets/images/menu/duvidas.png" class="img-responsive" alt="Dúvidas" /></a></div>



                                    

                                </div>

                                
                            </div>



                        </div>

                    </div><!-- Row -->

                </div><!-- Main Wrapper -->



<?php

    include "footer.php";

?>

    <script type="text/javascript">

    $( document ).ready(function() {

        $("#button_ativar_email").click(function() {

          $.get("enviar_ativar_conta.php", {tipo: 'email', email: "<?=EMAIL_USUARIO; ?>", email_alternativo: "<?=EMAIL_ALTERNATIVO_USUARIO; ?>"},

            function(resposta) {

              if (resposta == "sucesso") {

                $("#pagamento").modal("hide");

                 BootstrapDialog.show({

                    type: BootstrapDialog.TYPE_DANGER,

                    title: "Sucesso",

                    closable: false,

                    message: "Foi enviado um e-mail para <?=EMAIL_USUARIO; ?> e <?=EMAIL_ALTERNATIVO_USUARIO;;?> um link para ativação de sua conta. Por favor acesse-o para ter acesso completo ao sistema.",

                    buttons: [{

                        label: "OK",

                        cssClass: "btn-primary",

                        icon: "glyphicon glyphicon-lock",

                        action: function(){

                           window.location="../login/logout.php";

                         }

                       }]

                     });

              } 

              else {

                $("#pagamento").modal("hide");

                  BootstrapDialog.show({

                    type: BootstrapDialog.TYPE_DANGER,

                    title: "Erro",

                    closable: false,

                    message: "Aconteceu um erro ao tentar enviar o e-mail.",

                    buttons: [{

                        label: "ok",

                        cssClass: "btn-primary",

                        icon: "glyphicon glyphicon-lock",

                        action: function(){

                           window.location="../login/logout.php";

                         }

                       }]

                     });

              }

            });

        });



        $("#button_ativar_sms").click(function() {

          $.get("ativar_conta_sms.php", {cpf: '<?=CPF_USUARIO;?>'},

            function(resposta) {

            if (resposta == "sucesso") {

                $("#pagamento").modal("hide");

                BootstrapDialog.show({

                    type: BootstrapDialog.TYPE_DANGER,

                    title: "Sucesso",

                    closable: false,

                    message: "<p>Foi enviado um sms para <?=CELULAR_USUARIO;;?> com um código para a ativação da sua conta.</p><p><input type='text' id='codigo' name='codigo' placeholder='Digite seu código'/> ",

                    buttons: [{

                        label: "OK",

                        cssClass: "btn-primary",

                        icon: "glyphicon glyphicon-lock",

                        action: function(){

                            var codigo = $("#codigo").val();

                            $.post("verifica_codigo.php", {cpf: '<?=CPF_USUARIO;?>', codigo: codigo},

                                function(resposta) {

                                  if (resposta == "sucesso") {

                                      BootstrapDialog.show({

                                        type: BootstrapDialog.TYPE_DANGER,

                                        closable: false,

                                        title: "Sucesso",

                                        message: "Conta ativada com sucesso. Faça o login novamente para acessar todas funcionalidades do sistema",

                                        buttons: [{

                                            label: "Logar novamente",

                                            cssClass: "btn-primary",

                                            action: function(dialogRef){    

                                               window.location="../login/logout.php";

                                            }

                                           

                                           }]

                                         });



                                  } 

                                  else {

                                      BootstrapDialog.show({

                                        type: BootstrapDialog.TYPE_DANGER,

                                        title: "Erro",

                                        message: "Codigo incorreto.",

                                        buttons: [{

                                            label: "Tentar novamente",

                                            cssClass: "btn-primary",

                                            action: function(dialogRef){    

                                                dialogRef.close();

                                            }

                                           },{

                                            label: "Enviar outro código",

                                            cssClass: "btn-primary",

                                            icon: "glyphicon glyphicon-phone",

                                            action: function(dialogRef){    

                                                $.get("ativar_conta_sms.php", {cpf: '<?=CPF_USUARIO;?>'},

                                                    function(resposta) {

                                                    if (resposta == "sucesso") {

                                                        dialogRef.close();

                                                    }

                                                });

                                            }

                                           }]

                                         });

                                }

                            });

                        }

                    }]

                });

            } 

            else {

                $("#pagamento").modal("hide");

                  BootstrapDialog.show({

                    type: BootstrapDialog.TYPE_DANGER,

                    title: "Erro",

                    closable: false,

                    message: "Aconteceu um erro ao tentar enviar o sms.",

                    buttons: [{

                        label: "ok",

                        cssClass: "btn-primary",

                        icon: "glyphicon glyphicon-lock",

                        action: function(){

                           window.location="../login/logout.php";

                         }

                       }]

                     });

              }

            });

        });



        <?php 
		$link_boleto = 0;

            if(CONTA_ATIVADA) 

                echo " $('.counter').counterUp({

                            delay: 10,

                            time: 100000

                        });

                        

                        setTimeout(function() {

                            toastr.options = {

                                closeButton: true,

                                progressBar: true,

                                showMethod: 'fadeIn',

                                hideMethod: 'fadeOut',

                                timeOut: 0,

                                extendedTimeOut: 0

                            };

                            toastr.error('Em nossos registros ainda não consta o pagamento de sua inscrição. Para realizá-lo clique no botão e pague o boleto gerado. Caso já tenha efetuado, desconsidere essa mensagem.<br /><br /><a href=\"".$link_boleto."\" class=\"btn btn-success\" target=\"_blank\">Pagar Inscrição</button>', 'Atenção');

                        }, 1800);";

            if(CONTA_ATIVADA == 0){
				
                echo " $('#pagamento').modal('show');

                ";

            }

        ?>

    });

    </script>

    </body>

</html>

<?php } ?>