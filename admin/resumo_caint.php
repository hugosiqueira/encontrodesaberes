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
    $id_trabalho = $_GET['id'];
    $sql_projeto = "SELECT  es_area_especifica.id as id_area_especifica, es_area_especifica.descricao_area_especifica, 
                            es_ufop_areas.id_area, es_ufop_areas.descricao_area,
                            es_orgao_fomento.nome as nome_orgao_fomento, es_orgao_fomento.sigla as sigla_orgao_fomento, es_orgao_fomento.id as id_orgao_fomento,
                            es_trabalho.palavras_chave, es_trabalho.fgk_inscrito_responsavel, es_trabalho.resumo_revisado, es_trabalho.resumo_enviado, es_trabalho.titulo_enviado, es_trabalho.titulo_revisado, es_trabalho.fgk_projeto,
                            es_trabalho_status.descricao_status
                    FROM es_trabalho
                    LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                    LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
                    LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
                    LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
                    LEFT JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
                    LEFT JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
                    WHERE es_trabalho.id = ?";
    $dados_projeto = $db->sql_query($sql_projeto, array('es_trabalho.id'=>$id_trabalho));
    foreach ($dados_projeto as $projeto) {
        $id_area_especifica= $projeto->id_area_especifica;
        $descricao_area_especifica = $projeto->descricao_area_especifica;
        $id_area= $projeto->id_area;
        $descricao_area = $projeto->descricao_area;
        $id_orgao_fomento = $projeto->id_orgao_fomento;
        $nome_orgao_fomento = $projeto->nome_orgao_fomento;
        $sigla_orgao_fomento = $projeto->sigla_orgao_fomento;
        $titulo_enviado = $projeto->titulo_enviado;
        $titulo_revisado = $projeto->titulo_revisado;
        $palavras_chave = $projeto->palavras_chave;
        $resumo_enviado = $projeto->resumo_enviado;
        $resumo_revisado = $projeto->resumo_revisado;
        $descricao_status = $projeto->descricao_status;
        $fgk_projeto = $projeto->fgk_projeto;   
        $fgk_inscrito_responsavel = $projeto->fgk_inscrito_responsavel;      
    }
    if($fgk_projeto){
        $disabled = "disabled";
    } else{
        $disabled = "";
    }

    $sql_autor = "SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
    $dados_autor = $db->sql_query($sql_autor, array('fgk_trabalho'=>$id_trabalho));
    foreach ($dados_autor as $autor) {
        if($autor->fgk_tipo_autor == 1){
            $nome_autor = $autor->nome;
        } else if ($autor->fgk_tipo_autor == 2){
            $nome_orientador = $autor->nome;
        }
    }
    
?>          
            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Submeter trabalhos</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <form>
                                         <div class="form-group">
                                            <label for="titulo">Área de conhecimento</label>
                                            <select class="form-control" id="area" name="area" >
                                                    <option>
                                                    </option>
                                                    <?php
                                                    $stmt = $db->sql_query("SELECT *
                                                      FROM es_ufop_areas
                                                      ORDER BY descricao_area");
                                                    foreach ($stmt as $grande_area) {
                                                        if($id_area == $grande_area->id_area)
                                                            $select_area = "selected";
                                                        else 
                                                            $select_area = "";
                                                        echo '<option value="'.$grande_area->id_area.'" '.$select_area.' >'.$grande_area->descricao_area.'</option>';
                                                    }

                                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Área Específica</label>
                                            <select class="form-control" id="area_especifica" name="area_especifica" >
                                                    <option>
                                                    </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="titulo">Professor/Orientador</label>
                                            <input type="text" class="form-control" id="titulo" placeholder="" value="<?=$nome_orientador;?>" <?=$disabled;?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Aluno/Bolsista</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" value="<?=$nome_autor;?>" <?=$disabled;?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Órgão de fomento</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" value="<?=$nome_orgao_fomento;?>" <?=$disabled;?>>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Autores</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        if($fgk_projeto){
                                    ?>
                                    <button type="button" class="btn btn-danger m-b-sm" data-toggle="modal" data-target="#myModal">Adicionar novo autor</button>
                                    <?php
                                        }
                                    ?>
                                    <!-- Modal -->
                                    <form id="add-row-form" action="javascript:void(0);">
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel" >Adicionar novo autor</h4>
                                                </div>
                                                <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="text" id="name-input" class="form-control" placeholder="CPF" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" id="position-input" class="form-control" placeholder="Nome" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="number" id="age-input" class="form-control" placeholder="Tipo" required>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" id="add-row" class="btn btn-danger">Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table id="autores" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Tipo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_autores = "SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
                                                $dados_autores = $db->sql_query($sql_autores, array('fgk_trabalho'=>$id_trabalho));
                                                foreach ($dados_autores as $autores) {
                                                    echo "<tr>
                                                            <td>$autores->nome</td>
                                                            <td>$autores->descricao_tipo</td>
                                                        </tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <form>
                                         <div class="form-group">
                                            <label for="titulo">Título</label>
                                            <input type="text" class="form-control" id="titulo" placeholder="" value="<?=$titulo_enviado;?>" <?=$disabled;?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="titulo">Palavras-Chave</label>
                                            <input type="text" class="form-control" id="titulo" placeholder="" value="<?=$palavras_chave;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="resumo">Resumo</label>
                                            <textarea class="form-control" pattern=".{1300,2000}" rows="30" id="resumo" maxlength="2000" onkeyup="mostrarResultado(this.value,2000,'spcontando');contarCaracteres(this.value,2000,'sprestante')"><?=$resumo_enviado;?></textarea>
                                            <span id="spcontando" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Mínimo:</strong> 1300 <strong>Máximo:</strong> 2000</span><br />
                                            <span id="sprestante" style="font-family:Georgia;"></span>
                                        </div> 
                                        <?php
                                            if ($_SESSION['id_inscrito'] == $fgk_inscrito_responsavel)
                                                $button_disabled = "";
                                            else 
                                                $button_disabled = "disabled";
                                        ?>
                                         <button type="submit" class="btn btn-danger" <?=$button_disabled;?>>Submeter Resumo</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <script type="text/javascript">
                    function mostrarResultado(box,num_max,campospan){
                        var contagem_carac = box.length;
                        if (contagem_carac != 0){
                            document.getElementById(campospan).innerHTML = contagem_carac + " caracteres digitados";
                            if (contagem_carac == 1){
                                document.getElementById(campospan).innerHTML = contagem_carac + " caracter digitado";
                            }
                            if (contagem_carac >= num_max){
                                document.getElementById(campospan).innerHTML = "Limite de caracteres excedido!";
                            }
                        }else{
                            document.getElementById(campospan).innerHTML = "Ainda não temos nada digitado..";
                        }
                    }
                    function contarCaracteres(box,valor,campospan){
                        var conta = valor - box.length;
                        document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
                        if(box.length >= valor){
                            document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
                            document.getElementById("campo").value = document.getElementById("campo").value.substr(0,valor);
                        }   
                    }
                    
                </script>

<?php
    include "footer.php";
 }
?>
<script type="text/javascript">
    $(function(){
        $('#area').change(function(){
            if( $(this).val() ) {
                /*$('#cidade').hide();
                $('.carregando').show();*/
                $.getJSON('area_ajax.php?search=',{area: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].nome + '">' + j[i].nome + '</option>';
                    }
                    $('#area_especifica').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#area_especifica').html('<option value="" placeholder="– Escolha uma área de conhecimento –"> </option>');
            }
        })
    });
</script>
</body>
</html>