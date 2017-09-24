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
    $existe_monitoria_aluno = $db->existe('es_trabalho_seminario', array('aluno_cpf'=>$cpf, 'fgk_evento'=>EVENTO_ATUAL));
    $existe_monitoria_orientador = $db->existe('es_trabalho_seminario', array('orientador_cpf'=>$cpf,'fgk_evento'=>EVENTO_ATUAL));
    
    if(!$existe_monitoria_aluno && !$existe_monitoria_orientador){
        echo '<div class="page-inner">
        <div class="page-title">
            <h3>Encontro de Saberes</h3>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="">II Semin&aacute;rio de Monitoria</a></li>
                </ol>
            </div>
        </div>
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <p> Não existe trabalho de monitoria para submissão.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        $existe_monitoria = $db->sql_query("SELECT *, es_trabalho_seminario.id as id_seminario FROM es_trabalho_seminario
                                            WHERE (es_trabalho_seminario.aluno_cpf = ? OR es_trabalho_seminario.orientador_cpf  =?) 
                                            AND es_trabalho_seminario.fgk_evento = ?",
                                            array('es_trabalho_seminario.aluno_cpf' => $cpf, 'es_trabalho_seminario.orientador_cpf'=> $cpf, 'es_trabalho_seminario.fgk_evento'=>EVENTO_ATUAL));
        foreach ($existe_monitoria as $registro) {
            $id_seminario = $registro->id_seminario;
            $nome_aluno = $registro->aluno_nome;
            $nome_orientador = $registro->orientador_nome;
            $email_aluno = $registro->aluno_email;
            $email_orientador = $registro->orientador_email;
            $aluno_cpf = $registro->aluno_cpf;
            $orientador_cpf = $registro->orientador_cpf;
            $fgk_area = $registro->fgk_area;
            $titulo = $registro->titulo;
            $resumo = $registro->resumo;
            $fgk_status = $registro->fgk_status;
        }
        if($fgk_status == 2){
            $disabled = "disabled";
        } else{
            $disabled = "";
        }
    

?>          
    <div class="page-inner">
        <div class="page-title">
            <h3>Encontro de Saberes</h3>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="">II Semin&aacute;rio de Monitoria</a></li>
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
                <form id="monitoria" name="monitoria" action="javascript:void(0);">
                    <div class="col-md-6">
                        <div class="panel panel-white">
                            <div class="panel-body">                                
                                <div class="form-group">
                                    <label for="aluno">CPF do Aluno</label>
                                    <input type="hidden" class="form-control" id="id_seminario" value="<?=$id_seminario;?>">
                                    <input type="hidden" class="form-control" id="email_aluno" value="<?=$email_aluno;?>">
                                    <input type="text" class="form-control" id="aluno_cpf" value="<?=$aluno_cpf;?>" readonly>
                                    <p class="help-block"></p>
                                </div>
                                <div class="form-group">
                                    <label for="aluno">Nome do Aluno</label>
                                    <input type="text" class="form-control" id="nome_aluno" value="<?=$nome_aluno;?>" readonly>
                                    <p class="help-block"></p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                 <div class="form-group">
                                        <label for="aluno">CPF do Orientador</label>
                                        <input type="hidden" class="form-control" id="email_orientador" value="<?=$email_orientador;?>">
                                        <input type="text" class="form-control" id="orientador_cpf"  value="<?=$orientador_cpf;?>" readonly>
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="aluno">Nome do Orientador</label>
                                        <input type="text" class="form-control" id="nome_orientador" value="<?=$nome_orientador;?>" readonly>
                                        <p class="help-block"></p>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <textarea class="form-control" rows=2 id="titulo" required <?=$disabled;?>><?=$titulo;?></textarea>
                                    <p class="help-block"></p>
                                </div>
                            
                                <div class="form-group">
                                    <label for="resumo">Resumo</label>
                                    <textarea class="form-control" rows="30" id="resumo" maxlength="2000" required <?=$disabled;?>><?=$resumo;?></textarea>
                                    <p class="help-block"></p>
                                </div> 

                                <button type="submit" id="enviar" class="btn btn-danger" disabled>Salvar Alterações</button>
                                <button type="submit" id="enviar2" class="btn btn-success" disabled>Submeter Resumo</button>
                    
                            </div>
                        </div>
                    </div>
                </form>

                

        </div><!-- Row -->
    </div><!-- Main Wrapper -->

    <?php
    }
    include "footer.php";
    }
    ?>
<script src="assets/js/pages/cadastrar_monitoria.js"></script>

</body>
</html>