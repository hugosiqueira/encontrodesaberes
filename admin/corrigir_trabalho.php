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
    $id_trabalho = filter_input(INPUT_GET, 'id');
    $sql_projeto = "SELECT  es_area_especifica.id as id_area_especifica, es_area_especifica.descricao_area_especifica, 
                            es_ufop_areas.id_area, es_ufop_areas.descricao_area,
                            es_orgao_fomento.nome as nome_orgao_fomento, es_orgao_fomento.sigla as sigla_orgao_fomento, es_orgao_fomento.id as id_orgao_fomento,
                            es_trabalho.palavras_chave, es_trabalho.fgk_inscrito_responsavel, es_trabalho.resumo_revisado, es_trabalho.resumo_enviado, es_trabalho.titulo_enviado, es_trabalho.titulo_revisado, es_trabalho.fgk_projeto,
                            es_trabalho_status.descricao_status, es_trabalho.fgk_status, es_trabalho.palavras_chave_revisado
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
        $palavras_chave_revisado = $projeto->palavras_chave_revisado;
        $resumo_enviado = $projeto->resumo_enviado;
        $resumo_revisado = $projeto->resumo_revisado;
        $fgk_status = $projeto->fgk_status;
        $descricao_status = $projeto->descricao_status;
        $fgk_projeto = $projeto->fgk_projeto;   
        $fgk_inscrito_responsavel = $projeto->fgk_inscrito_responsavel;      
    }
    $dados_responsavel = $db->sql_query("SELECT nome FROM es_inscritos WHERE id = ?", array('id'=>$fgk_inscrito_responsavel));
    foreach ($dados_responsavel as $registro) {
        $nome_responsavel = $registro->nome;
    }
    
    $dados_avaliacao = $db->sql_query("SELECT * FROM es_avaliacao WHERE es_avaliacao.fgk_trabalho = ?", array("es_avaliacao.fgk_trabalho"=>$id_trabalho));
    foreach ($dados_avaliacao as $registro) {
        $parecer = $registro->parecer;
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
    if($fgk_inscrito_responsavel == $_SESSION['id_inscrito'] && $fgk_status == 7){
        $disabled= "";
        $exibir ="";
    } else {
        $disabled = "disabled";
        $exibir = '<div class="alert alert-danger" role="alert">
                                      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                      <span class="sr-only">Atenção:</span>
                                      Apenas o(s) autor(a) '.$nome_responsavel.', que submeteu o trabalho, é que poderá fazer as correções solicitadas.
                                    </div>';
    }
    
?>          
            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Corrigir Trabalho</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <?=$exibir;?>
                                    <div class="form-group">
                                        <label for="parecer"><strong>Parecer dos Avaliadores</strong></label>
                                        <textarea class="form-control" rows="15" id="parecer" disabled style="background:#fff;font-weight: bold;"><?=$parecer;?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-body">                                    
                                    <form id="form_trabalho" name="form_trabalho" action="javascript:void(0);">
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
                                        <div id="bloqueado" class="modal fade modal" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Encontro de Saberes</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        O trabalho só poderá ser editado pelo autor que o submeteu.
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">

                                            <input type="hidden" id="id_trabalho" value="<?=$id_trabalho;?>">
                                            <label for="area">Área de conhecimento</label>
                                            <select class="form-control" id="area" name="area" disabled>
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
                                            <label for="area_especifica">Área Específica</label>
                                            <select class="form-control" id="area_especifica" name="area_especifica" disabled>
                                                    <option>
                                                    </option>
                                                    <?php
                                                    
                                                        $stmt = $db->sql_query("SELECT *
                                                          FROM es_area_especifica
                                                          WHERE fgk_area = ?
                                                          ORDER BY descricao_area_especifica", array('fgk_area'=> $id_area));
                                                        foreach ($stmt as $peq_area) {
                                                            if($id_area_especifica == $peq_area->id)
                                                                $select_peqarea = "selected";
                                                            else 
                                                                $select_peqarea = "";
                                                            echo '<option value="'.$peq_area->id.'" '.$select_peqarea.' >'.$peq_area->descricao_area_especifica.'</option>';
                                                        }
                                                  
                                                    ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="orgao_fomento">Órgão de fomento</label>
                                            <select class="form-control" id="orgao_fomento" name="orgao_fomento" disabled>
                                                <option>
                                                </option>
                                                <?php
                                                $stmt = $db->sql_query("SELECT *
                                                  FROM es_orgao_fomento
                                                  ORDER BY sigla");
                                                foreach ($stmt as $orgao) {
                                                     if($id_orgao_fomento == $orgao->id)
                                                                $select_orgao = "selected";
                                                            else 
                                                                $select_orgao = "";
                                                    echo '<option value="'.$orgao->id.'" '.$select_orgao.' >'.$orgao->sigla.' - '.$orgao->nome.'</option>';
                                                }

                                                ?>
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Autores</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table id="autores" class="display table autores" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Tipo</th>
                                                    <th>Apresentador</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_autores = "SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
                                                $dados_autores = $db->sql_query($sql_autores, array('fgk_trabalho'=>$id_trabalho));
                                                foreach ($dados_autores as $autores) {
                                                    if($autores->bool_apresentador == 1)
                                                        $img = "<img src='assets/images/icons/ok.png'>";
                                                    else
                                                        $img = "";
                                                    echo "<tr>
                                                            <td>$autores->nome</td>
                                                            <td>$autores->descricao_tipo</td>
                                                            <td>$img</td>
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
                                         <div class="form-group">
                                            <label for="titulo">Título</label>
                                            <textarea class="form-control" rows="2" id="titulo" <?=$disabled;?>><?php if($fgk_status == 7) echo $titulo_enviado; else if($fgk_status == 13) echo $titulo_revisado;?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="palavras_chave">Palavras-Chave</label>
                                            <input type="text" class="form-control" id="palavras_chave" placeholder="" value="<?php if($fgk_status == 7) echo $palavras_chave; else if($fgk_status == 13) echo $palavras_chave_revisado;?>" <?=$disabled;?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="resumo">Resumo</label>
                                            <textarea class="form-control" pattern=".{1300,2000}" rows="30" id="resumo" maxlength="2000" onkeyup="mostrarResultado(this.value,2000,'spcontando');contarCaracteres(this.value,2000,'sprestante')" <?=$disabled;?>><?php if($fgk_status == 7) echo $resumo_enviado; else if($fgk_status == 13) echo $resumo_revisado;?></textarea>
                                            <span id="spcontando" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Mínimo:</strong> 1300 <strong>Máximo:</strong> 2000</span><br />
                                            <span id="sprestante" style="font-family:Georgia;"></span>
                                        </div> 
                                        <?php
                                            if (($_SESSION['id_inscrito'] == $fgk_inscrito_responsavel && ($fgk_status == 1 || $fgk_status ==9)) || $id_tipo_inscrito == 5)
                                                $button_disabled = "";
                                            else 
                                                $button_disabled = "disabled";
                                        ?>
                                        <button type="submit" id="submeter" class="btn btn-success"<?=$disabled;?>>Submeter Resumo</button>
                                        <a href="correcoes.php" class="btn btn-danger">Cancelar</a>
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

    <script src="assets/js/pages/corrigir_trabalho.js"></script>
</body>
</html>