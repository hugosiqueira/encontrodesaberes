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
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="perfil.php">Relatório de Mobilidade Acadêmica</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <?php
                    
                    if((TIPO_USUARIO == 1 || TIPO_USUARIO == 5) && (DATA_SUBMISSAO_INI <=date('Y-m-d') && DATA_SUBMISSAO_FIM >=date('Y-m-d'))){
                        if($db->existe('es_trabalho_caint', array('cpf' => CPF_USUARIO, 'fgk_evento'=>EVENTO_ATUAL)) ){ 
                            $dados_trabalho = $db->sql_query("SELECT * FROM es_trabalho_caint WHERE cpf = ? AND fgk_evento = ?", array('cpf'=>CPF_USUARIO, 'fgk_evento' => EVENTO_ATUAL));
                            foreach ($dados_trabalho as $registro) {
                                $id_trabalho_caint = $registro->id;
                                $fgk_status = $registro->fgk_status;
                                $cpf_aluno = $registro->cpf;
                                $nome_aluno = $registro->nome_aluno;
                                $curso_aluno = $registro->curso_aluno;
                                $periodo_cursava = $registro->periodo_cursava;
                                $tempo_afastamento = $registro->tempo_afastamento;
                                $tipo_mobilidade = $registro->tipo_mobilidade;
                                $universidade_destino = $registro->universidade_destino;
                                $cidade_destino = $registro->cidade_destino;
                                $pais_destino = $registro->pais_destino;
                                $curso_destino = $registro->curso_destino;
                                $curso_area_destaque = $registro->curso_area_destaque;
                                $questoes_linguisticas = $registro->questoes_linguisticas;
                                $tipo_moradia = $registro->tipo_moradia;
                                $sistema_avaliacao = $registro->sistema_avaliacao;
                                $dinamica_metodologia_aulas = $registro->dinamica_metodologia_aulas;
                                $custo_vida = $registro->custo_vida;
                                $infra_universidade = $registro->infra_universidade;
                                $servico_acolhimento = $registro->servico_acolhimento;
                                $estagio = $registro->estagio;
                                $atividades_universidade = $registro->atividades_universidade;
                                $processo_adaptacao = $registro->processo_adaptacao;
                                $relato_pessoal = $registro->relato_pessoal;
                                $conselhos_calouro = $registro->conselhos_calouro;
                            } 
                            switch ($fgk_status) {
                                case '6':
                                    $resultado_final = "Aprovado";
                                    break;
                                case '7':
                                    $resultado_final = "Aprovado com Restrições";
                                    break;
                                case '8':
                                    $resultado_final = "Reprovado";
                                    break;
                                
                                default:
                                    $resultado_final ="";
                                    break;
                            }
                            $verifica_avaliacao = $db->sql_query("SELECT nota FROM es_avaliacao WHERE bool_caint = ? AND fgk_trabalho =?",
                             array('bool_caint'=>1, 'fgk_trabalho'=>$id_trabalho_caint));
                            foreach ($verifica_avaliacao as $value) {
                                $nota = $value->nota;
                            }

                            if($fgk_status >= 2)
                                $disabled = "disabled";
                            else
                                $disabled = "";
                        }  else {
                            $cpf_aluno = CPF_USUARIO;
                            $nome_aluno = NOME_USUARIO;
                            $curso_aluno = CURSO_USUARIO;
                        }

                    ?>
                    <form id="mobilidade" name="mobilidade" action="javascript:void(0)">
                        <input type="hidden" id="cpf" value="<?=CPF_USUARIO;?>">
                        <input type="hidden" id="id_trabalho_caint" value="<?=$id_trabalho_caint;?>">
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
                                <div id="resultado" class="modal fade modal" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Encontro de Saberes</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Resultado do relatório: <?=$resultado_final;?> </p>
                                                <p>Nota: <?=$nota;?> </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel panel-white">

                                <div class="panel-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome_aluno">Nome: </label>
                                                <input type="text" class="form-control" id="nome_aluno" value="<?=$nome_aluno;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="curso_aluno">Curso: </label>
                                                <input type="text" class="form-control" id="curso_aluno" value="<?=$curso_aluno;?>" disabled>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="periodo_cursava">Período que cursava quando saiu em mobilidade: </label>
                                                <input type="number" class="form-control" id="periodo_cursava" min = 1 value="<?=(!isset($periodo_cursava)) ? '' : $periodo_cursava;?>" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="tempo_afastamento">Tempo de afastamento em meses</label>
                                                <input type="number" class="form-control" id="tempo_afastamento" min = 1 value="<?=(!isset($tempo_afastamento)) ? '' : $tempo_afastamento;?>" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_mobilidade">Tipo de Mobilidade</label>
                                                <select id="tipo_mobilidade" class="form-control" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                    <option></option>
                                                    <option value="1">Ciência sem Fronteiras</option>
                                                    <option value="2">Mobilidade CAINT</option>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="universidade_destino">Universidade de Destino</label>
                                                <input type="text" class="form-control" id="universidade_destino" name ="universidade_destino" value="<?=(!isset($universidade_destino)) ? '' : $universidade_destino;?>" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="cidade_destino">Cidade</label>
                                                <input type="text" class="form-control" name="cidade_destino" id="cidade_destino" value="<?=(!isset($cidade_destino)) ? '' : $cidade_destino;?>" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="pais_destino">País</label>
                                                <select id="pais_destino" class="form-control" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                    <option></option>
                                                    <?php

                                                        $stmt = $db->listar_todos('desk_pais');
                                                        foreach ($stmt as $pais) {
                                                            if($pais_destino == $pais->descricao_pais)
                                                                $select_pais = "selected";
                                                            else
                                                                $select_pais = "";
                                                            echo '<option value="'.$pais->descricao_pais.'" '.$select_pais.'>'.$pais->descricao_pais.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="curso_destino">Curso de Destino</label>
                                                <input type="text" class="form-control"  id="curso_destino" name ="curso_destino" value="<?=(!isset($curso_destino)) ? '' : $curso_destino;?>" <?=(!isset($disabled)) ? '' : $disabled;?>>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                </div>
                                <div class="panel-heading clearfix">
                                </div>
                                <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="curso_area_destaque">01. Quais são áreas/cursos de destaque da Universidade em que você esteve? </label>
                                                <textarea class="form-control" rows="2" maxlength="70" id="curso_area_destaque" onkeyup="mostrarResultado(this.value,70,'spcontando1');contarCaracteres(this.value,70,'sprestante1')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($curso_area_destaque)) ? '' : $curso_area_destaque;?></textarea>
                                                <span id="spcontando1" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 70</span><br />
                                                <span id="sprestante1" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="questoes_linguisticas">02. Fale sobre a questão linguística na Universidade de destino: se haviam cursos de idiomas, como funcionavam, se haviam disciplinas ofertadas em outros idiomas, a dificuldades enfrentadas.</label>
                                                <textarea class="form-control" rows="5" maxlength="500" id="questoes_linguisticas" onkeyup="mostrarResultado(this.value,500,'spcontando2');contarCaracteres(this.value,500,'sprestante2')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($questoes_linguisticas)) ? '' : $questoes_linguisticas;?></textarea>
                                                <span id="spcontando2" style="font-family:Georgia;">Ainda não temos nada digitado.<strong>Máximo:</strong> 500</span><br />
                                                <span id="sprestante2" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_moradia">03. Descreva o tipo de moradia que você utilizou durante sua mobilidade (gratuita ou não, compartilhada, demais ofertas de imóveis e possibilidades, valores, estrutura...).</label>
                                                <textarea class="form-control" rows="5" maxlength="500" id="tipo_moradia" onkeyup="mostrarResultado(this.value,500,'spcontando3');contarCaracteres(this.value,500,'sprestante3')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($tipo_moradia)) ? '' : $tipo_moradia;?></textarea>
                                                <span id="spcontando3" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 500</span><br />
                                                <span id="sprestante3" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="sistema_avaliacao">04. Descreva como é o sistema de avaliação e notas da Universidade onde esteve (Formas de avaliação, grau de dificuldade, formas de preparação para as avaliações, curiosidades...)</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="sistema_avaliacao" onkeyup="mostrarResultado(this.value,700,'spcontando4');contarCaracteres(this.value,700,'sprestante4')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($sistema_avaliacao)) ? '' : $sistema_avaliacao;?></textarea> 
                                                <span id="spcontando4" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante4" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="dinamica_metodologia_aulas">05. Descreva como é a dinâmica/metodologia das aulas na Universidade de destino. Fale sobre o formato das aulas, atividades práticas e teóricas, trabalhos em grupo, monitorias. Aproveite e faça um comparativo com o nosso modelo aqui na UFOP.</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="dinamica_metodologia_aulas" onkeyup="mostrarResultado(this.value,700,'spcontando5');contarCaracteres(this.value,700,'sprestante5')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($dinamica_metodologia_aulas)) ? '' : $dinamica_metodologia_aulas;?></textarea> 
                                                <span id="spcontando5" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante5" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="custo_vida">06. Descreva o custo de vida para um estudante na cidade/país onde você morou. Fale sobre alguns preços, comparativos, principais despesas, vantagens, desvantagens...</label>
                                                <textarea class="form-control" rows="5" maxlength="500" id="custo_vida" onkeyup="mostrarResultado(this.value,500,'spcontando6');contarCaracteres(this.value,500,'sprestante6')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($custo_vida)) ? '' : $custo_vida;?></textarea>                                 
                                                <span id="spcontando6" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 500</span><br />
                                                <span id="sprestante6" style="font-family:Georgia;"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="infra_universidade">07. Fale sobre a infra estrutura da Universidade em que esteve: laboratórios, bibliotecas, centros esportivos, parte administrativa, salas de aula e estudo...</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="infra_universidade" onkeyup="mostrarResultado(this.value,700,'spcontando7');contarCaracteres(this.value,700,'sprestante7')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($infra_universidade)) ? '' : $infra_universidade;?></textarea>
                                                <span id="spcontando7" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante7" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="servico_acolhimento">08. Como funciona o serviço de acolhimento e suporte a alunos estrangeiros na Universidade de destino?</label>
                                                <textarea class="form-control" rows="5" maxlength="500" id="servico_acolhimento" onkeyup="mostrarResultado(this.value,500,'spcontando8');contarCaracteres(this.value,500,'sprestante8')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($servico_acolhimento)) ? '' : $servico_acolhimento;?></textarea> 
                                                <span id="spcontando8" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 500</span><br />
                                                <span id="sprestante8" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="destagio">09. Com relação ao estágio? Como ele é considerado e avaliado na Universidade onde estudou? E em relação à oferta? Como localizar um estágio? A Universidade dá algum suporte? Como foi a experiência ao realizar o estágio.</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="estagio" onkeyup="mostrarResultado(this.value,700,'spcontando9');contarCaracteres(this.value,700,'sprestante9')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($estagio)) ? '' : $estagio;?></textarea> 
                                                <span id="spcontando9" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante9" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="atividades_universidade">10. Quais atividades são oferecidas pela Universidade de destino: Fale sobre grupos de estudos, atividades de pesquisa, esporte, atividades culturais, lazer...</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="atividades_universidade" onkeyup="mostrarResultado(this.value,700,'spcontando10');contarCaracteres(this.value,700,'sprestante10')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($atividades_universidade)) ? '' : $atividades_universidade;?></textarea>                                                
                                                <span id="spcontando10" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante10" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="processo_adaptacao">11. Como foi o seu processo de adaptação à cidade e ao país de destino? Dificuldades com clima, idioma, receptividade, inserção cultural.</label>
                                                <textarea class="form-control" rows="5" maxlength="500" id="processo_adaptacao" onkeyup="mostrarResultado(this.value,500,'spcontando11');contarCaracteres(this.value,500,'sprestante11')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($processo_adaptacao)) ? '' : $processo_adaptacao;?></textarea>                                               
                                                <span id="spcontando11" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 500</span><br />
                                                <span id="sprestante11" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="relato_pessoal">12. Relato pessoal. Fale sobre a sua experiência pessoal de maneira geral, sobre demais atividades acadêmicas, esportivas, culturais que desenvolveu, experiências profissionais, amadurecimento, rede de contatos (tente priorizar as atividades relacionadas à sua formação pessoal, acadêmica e profissional, evitando expor elementos exclusivamente de entreterimento).</label>
                                                <textarea class="form-control" rows="7" maxlength="700" id="relato_pessoal" onkeyup="mostrarResultado(this.value,700,'spcontando12');contarCaracteres(this.value,700,'sprestante12')" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($relato_pessoal)) ? '' : $relato_pessoal;?></textarea> 
                                                <span id="spcontando12" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Máximo:</strong> 700</span><br />
                                                <span id="sprestante12" style="font-family:Georgia;"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="conselhos_calouro">13. Quais conselhos você poderia dar para um calouro que quer se preparar para fazer mobilidade na mesma Universidade/país que você esteve?</label>
                                                <textarea class="form-control" rows="7"  id="conselhos_calouro" <?=(!isset($disabled)) ? '' : $disabled;?>><?=(!isset($conselhos_calouro)) ? '' : $conselhos_calouro;?></textarea>   
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" id="enviar" class="btn btn-danger" <?=(!isset($disabled)) ? '' : $disabled;?>>Salvar Alterações</button>
                                            <button type="submit" id="enviar2" class="btn btn-success" <?=(!isset($disabled)) ? '' : $disabled;?>>Submeter Resumo</button>
                                        </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </form>
                <?php
                    } else if (DATA_SUBMISSAO_INI >date('Y-m-d') || DATA_SUBMISSAO_FIM <date('Y-m-d')){
                ?>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <p>Não estamos no período de submissões.</p>
                    </div>
                </div>
                <?php

                    } else if(MOBILIDADE_ANO_ATUAL && TIPO_USUARIO != 5){
                ?>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <p>Você não precisa emitir seu relatório esse ano.</p>
                    </div>
                </div>
                <?php
                 } else{ 
                ?>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <p>Você não participou de mobilidade acadêmica no ano passado. </p>
                    </div>
                </div>
                <?php } ?>
                </div>
<?php
    include "footer.php";
?>  
    <script src="../js/jquery-validation/jquery.validate.min.js"></script>
    <script src="assets/js/pages/mobilidade.js"></script>
    <script type="text/javascript">
    <?php
    if($tipo_mobilidade){
    ?>
    $(document).ready(function() {
        $("#tipo_mobilidade option[value='<?=$tipo_mobilidade;?>']").prop('selected', true);
        //$('#resultado').modal('show');
    });

    <?php } ?>
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

    </body>
</html>
<?php } ?>