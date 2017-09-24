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
                            es_trabalho_status.descricao_status, es_trabalho.fgk_status
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
        $fgk_status = $projeto->fgk_status;
        $descricao_status = $projeto->descricao_status;
        $fgk_projeto = $projeto->fgk_projeto;   
        $fgk_inscrito_responsavel = $projeto->fgk_inscrito_responsavel;      
    }
    
?>          
            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Avaliação de Trabalhos</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input type="text" class="form-control" id="titulo" placeholder="" value="<?=$titulo_enviado;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="resumo">Resumo</label>
                                        <textarea class="form-control" rows="30" id="resumo" maxlength="2000" disabled><?=$resumo_enviado;?></textarea>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <h3>Avaliação do Trabalho</h3>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="conclusao">Conclusão</label>
                                            <select class='form-control' id='conclusao' name='conclusao'>
                                                <option> - </option>
                                                <option value=5>Excelente </option>
                                                <option value=4>Bom </option>
                                                <option value=3>Regular </option>
                                                <option value=2>Ruim </option>
                                                <option value=1>Inadequado </option>
                                            </select>
                                        <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="resultado">Resultado</label>
                                            <select class='form-control' id='resultado' name='resultado'>
                                                <option> - </option>
                                                <option value=5>Excelente </option>
                                                <option value=4>Bom </option>
                                                <option value=3>Regular </option>
                                                <option value=2>Ruim </option>
                                                <option value=1>Inadequado </option>
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="metodologia">Metodologia</label>
                                            <select class='form-control' id='metodologia' name='metodologia'>
                                                <option> - </option>
                                                <option value=5>Excelente </option>
                                                <option value=4>Bom </option>
                                                <option value=3>Regular </option>
                                                <option value=2>Ruim </option>
                                                <option value=1>Inadequado </option>
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="titulo">Título</label>
                                           <select class='form-control' id='titulo' name='titulo'>
                                                <option> - </option>
                                                <option value=5>Excelente </option>
                                                <option value=4>Bom </option>
                                                <option value=3>Regular </option>
                                                <option value=2>Ruim </option>
                                                <option value=1>Inadequado </option>
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="redacao">Redação</label>
                                            <select class='form-control' id='redacao' name='redacao'>
                                                <option> - </option>
                                                <option value=5>Excelente </option>
                                                <option value=4>Bom </option>
                                                <option value=3>Regular </option>
                                                <option value=2>Ruim </option>
                                                <option value=1>Inadequado </option>
                                            </select>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nota">Nota</label>
                                            <input type="number" class="form-control" id="nota" name="nota" min=0 max=10>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <h3>Avaliação do Trabalho</h3>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="radio" id="q128" name="quality[21]" value="1" /> Aprovado
                                            </label> 
                                            <label class="checkbox-inline">
                                                <input type="radio" id="q129" name="quality[21]" checked="checked" value="2" /> Aprovado com Restrições
                                            </label> 
                                            <label class="checkbox-inline">
                                                <input type="radio" id="q130" name="quality[21]" value="3" /> Reprovado
                                            </label> 
                                        </div>
                                    </div>
                                       
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="justificativa">Justificativa</label>
                                            <textarea class="form-control" rows="10" id="justifivativa" ></textarea>
                                        </div> 
                                    </div>
                                    <p>Gostaria de enviar algum comentário específico ao coordenador? (Os autores não terão acesso a esta informação)</p>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="parecer">Parecer</label>
                                            <textarea class="form-control" rows="10" id="parecer" ></textarea>
                                        </div>
                                        <button type="submit" id="enviar" class="btn btn-danger">Salvar Avaliação</button>
                                        <button type="submit" id="enviar2" class="btn btn-success">Submeter Avaliação</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                

<?php
    include "footer.php";
 }
?>
    <script src="assets/js/pages/exibir_trabalho.js"></script>
</body>
</html>