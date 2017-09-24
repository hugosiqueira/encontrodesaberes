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
    <div class="page-inner">
        <div class="page-title">
            <h3><?=$nome_evento;?></h3>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="index.php">Dúvidas</a></li>
                </ol>
            </div>
        </div>

        <div id="processando" class="modal fade modal" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><?=$nome_evento;?></h4>
                    </div>
                    <div class="modal-body">
                        Aguarde, enviando sua dúvida...
                    </div>
                </div>

            </div>
        </div>
        <form id="form_duvidas" name="form_duvidas" action="javascript:void(0)">
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="aluno">Nome</label>
                                        <input type="hidden" id="cpf" name="cpf" value="<?=$cpf;?>" />
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?=$nome;?>" readonly />
                                        <p class="help-block"></p>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="aluno">E-mail</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?=$email;?>" readonly />
                                        <p class="help-block"></p>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="assunto">Assunto</label>
                                        <input type="text" class="form-control" id="assunto" name="assunto" />
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="mensagem">Mensagem</label>
                                        <textarea class="form-control" id="mensagem" name="mensagem" rows=15 ></textarea>
                                        <p class="help-block"></p>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <button type="submit" id="enviar" class="btn btn-success" >Enviar mensagem</button>
                        <a href="index.php" class="btn btn-danger" >Cancelar</a>
                    </div>
                </div>
            </div>
        </form>


<?php
include "footer.php";
}
?>
<script src="assets/js/pages/duvidas.js" ></script>
</body>
</html>