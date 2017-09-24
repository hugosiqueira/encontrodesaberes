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
    $id_trabalho = filter_input(INPUT_GET, 'id_trabalho');
 ?>
<div class="page-inner">
    <div class="page-title">
        <h3>Encontro de Saberes</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="justificar_nao_envio.php.php">Justificar não envio</a></li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div id="processando" class="modal fade modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Encontro de Saberes</h4>
                        </div>
                        <div class="modal-body">
                            Aguarde, carregando...
                        </div>
                    </div>

                </div>
            </div>
            
           <form id="form_avaliacao" name="form_avaliacao" action="javascript:void(0);">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo">Justificativa:</label>
                                <input type="hidden" value="<?=$id_trabalho;?>" id="id_trabalho" />
                                <textarea class="form-control" rows="10" id="justificativa" <?=$disabled;?>><?=$justificativa;?></textarea>

                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-success" id="enviar" data-toggle="modal" data-target="#confirm-submit">Submeter Justificativa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->



    <?php    }   ?>
               

<?php
    include "footer.php";
?>

<script src="assets/js/pages/justificativa.js"></script>
</body>
</html>
