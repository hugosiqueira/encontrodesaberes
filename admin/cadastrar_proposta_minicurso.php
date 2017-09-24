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
    if(isset($_GET['id_proposta'])){
        $id_proposta = $_GET['id_proposta'];
        $dados_proposta = $db->sql_query("SELECT * FROM es_minicursos_propostos
                                        INNER JOIN es_area_especifica ON es_area_especifica.id = es_minicursos_propostos.fgk_area_especifica
                                        INNER JOIN es_inscritos ON es_minicursos_propostos.fgk_inscrito = es_inscritos.id
                                        WHERE id_minicurso_prop = ?", array('id_minicurso_prop'=>$id_proposta));
        foreach ($dados_proposta as $registro) {
            $assunto = $registro->assunto;
            $resumo = $registro->resumo;
            $status = $registro->status;
            $fgk_area_especifica = $registro->fgk_area_especifica;
            $inscricao_professor = $registro->fgk_inscrito;
            $nome_professor = $registro->nome;
            $email_professor = $registro->email;
            $telefone_professor = $registro->telefone_celular;
            $departamento_professor = $registro->departamento;
            $cpf_professor = $registro->cpf;


        }


    } else {
        $id_proposta = "";
        $resumo = "";
        $status = "";
        $assunto = "";
        $fgk_area_especifica = "";
        $inscricao_professor = $id_inscrito;
        $nome_professor = $nome;
        $email_professor = $email;
        $telefone_professor = $telefone_celular;
        $departamento_professor = $departamento;
        $cpf_professor = $cpf;

    };
    if($status >=2)
        $disable = "disabled";
    else
        $disable = "";
    

?>

                <div class="page-inner">
                    <div class="page-title">
                        <h3>Encontro de Saberes</h3>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="cadastrar_proposta_minicurso.php">Nova proposta de minicurso</a></li>
                            </ol>
                        </div>
                    </div>
                    <div id="main-wrapper">
                        <?php
                        if($id_tipo_inscrito == 2 || $id_tipo_inscrito == 5){
                        ?>
                	
                		<div class="row">
                            <div class="panel panel-white">
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
                                
                                <div class="panel-body">
                                    <form id="proposta_minicurso" name="proposta_minicurso" action="javascript:func();">
	                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden"  id="fgk_inscrito" value="<?=$inscricao_professor;?>">
                                                <input type="hidden"  id="id_proposta" value="<?=$id_proposta;?>">
                                                <label for="nome_professor">Nome: </label>
                                                <input type="text" class="form-control" id="nome_professor" name="nome_professor" value="<?=$nome_professor;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf">CPF: </label>
                                                <input type="text" class="form-control" id="cpf" name="cpf" value="<?=$cpf_professor;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
	                                        <div class="form-group">
	                                            <label for="email_professor">E-mail: </label>
	                                            <input type="email" class="form-control" id="email_professor" name="email_professor" value="<?=$email_professor;?>" disabled>
	                                            <p class="help-block"></p>
                                            </div>
	                                                                                    
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="departamento">Departamento</label>
                                                <input type="text" class="form-control" id="departamento_professor" name="departamento_professor" placeholder="" value="<?=$departamento_professor;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="departamento">Telefone</label>
                                                <input type="text" class="form-control" id="telefone_professor" name="telefone_professor" placeholder="" value="<?=$telefone_professor;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="area">Área Específica</label>
                                                <select class="form-control" id="area" name="area" required <?=$disable;?>>
                                                    <option>
                                                    </option>
                                                    <?php
                                                    $stmt = $db->sql_query("SELECT *
                                                      FROM es_area_especifica
                                                      ORDER BY descricao_area_especifica");
                                                    foreach ($stmt as $grande_area) {
                                                        if($grande_area->id == $fgk_area_especifica)
                                                            $select = "selected";
                                                        else 
                                                            $select = "";
                                                        echo '<option value="'.$grande_area->id.'" '.$select.' >'.$grande_area->descricao_area_especifica.'</option>';
                                                    }

                                                    ?>
                                                </select>
                                                <p class="help-block"></p>                                         
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="assunto">Assunto</label>
                                                <input type="text" class="form-control" id="assunto" name ="assunto" value="<?=$assunto;?>" <?=$disable;?> required />
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="resumo">Resumo </label>
                                                <textarea class="form-control" rows="20" maxlength="2000" name = "resumo" id="resumo" <?=$disable;?> required><?=$resumo;?></textarea>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                        	<button type="submit" id="enviar" class="btn btn-danger" <?=$disable;?>>Salvar Alterações</button>
                                            <button type="submit" id="enviar2" class="btn btn-success" <?=$disable;?>>Submeter Proposta</button>
                                        </div>
                                    </form>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    } 
                ?>
                
<?php
    include "footer.php";
?>  
<script src="assets/js/pages/proposta_minicurso.js"></script>
    
    </body>
</html>
<?php } ?>