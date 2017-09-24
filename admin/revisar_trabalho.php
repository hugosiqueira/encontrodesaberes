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
    $id_avaliacao = filter_input(INPUT_GET, 'id');
    $bool_caint = filter_input(INPUT_GET, 'bool_caint');

    if($bool_caint == 0){
        $verifica_trabalho = $db->sql_query("SELECT revisor1.id as id_revisor1, revisor2.id as id_revisor2, titulo_enviado, resumo_enviado, 
                                    descricao_area, descricao_area_especifica, inscrito1.id as id_inscrito1, inscrito2.id as id_inscrito2
                                            FROM es_avaliacao 
                                            LEFT JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho
                                            LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
                                            LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
                                            LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                            LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                            LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                            LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                            WHERE  es_avaliacao.id = ? AND es_trabalho.fgk_evento = ?",
                                            array('es_avaliacao.id' =>$id_avaliacao, 'es_trabalho.fgk_evento'=>EVENTO_ATUAL ));
        foreach ($verifica_trabalho as $trabalho) {
            $titulo_enviado = $trabalho->titulo_enviado;
            $resumo_enviado = $trabalho->resumo_enviado;
            $descricao_area = $trabalho->descricao_area;
            $descricao_area_especifica = $trabalho->descricao_area_especifica;
            $inscrito1 = $trabalho->id_inscrito1;
            $inscrito2 = $trabalho->id_inscrito2;
            $revisor1 = $trabalho->id_revisor1;
            $revisor2 = $trabalho->id_revisor2;
        }

        if($inscrito1 == ID_USUARIO)
            $id_revisor = $revisor1;
        else if($inscrito2 == ID_USUARIO)
            $id_revisor = $revisor2;

        $existe_avaliacao = $db->sql_query("SELECT * FROM es_avaliacao_revisao WHERE fgk_avaliacao = ? AND fgk_revisor = ?", array('fgk_avaliacao'=>$id_avaliacao, 'fgk_revisor'=>$id_revisor));
        if($existe_avaliacao){
		   foreach ($existe_avaliacao as $registro) {
				$id_avaliacao_revisao = $registro->id;
				$aval_conclusao = $registro->aval_conclusao;
				$aval_metodologia = $registro->aval_metodologia;
				$aval_redacao = $registro->aval_redacao;
				$aval_resultado = $registro->aval_resultado;
				$justificativa = $registro->justificativa;
				$nota = $registro->nota;
				$parecer = $registro->parecer;
				$resultado = $registro->resultado;
				$status = $registro->status;
			}
			if(isset($status) && $status == 2)
				$disabled = "disabled";
			else
				$disabled = "";
	   }

    
?>          
<div class="page-inner">
    <div class="page-title">
        <h3>Encontro de Saberes</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="index.php">Avaliar Trabalhos</a></li>
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
                                <label for="area"><strong>Área:</strong></label>
                                <p class="text-justify"><?=$descricao_area;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>Área Específica:</strong></label>
                                <p class="text-justify"><?=$descricao_area_especifica;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="titulo"><strong>Título:</strong></label>
                                <p class="text-justify"><?=$titulo_enviado;?></p>
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="resumo"><strong>Resumo:</strong></label>
                                <p class="text-justify"><?=$resumo_enviado;?></p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if(ID_USUARIO == $inscrito1 || ID_USUARIO == $inscrito2){
            ?>
            <div class="col-md-12">
                <input type="hidden" id="id_avaliacao_revisao" value="<?=(!isset($id_avaliacao_revisao)? '' : $id_avaliacao_revisao)?>"/>
                <input type="hidden" id="fgk_avaliacao" value="<?=(!isset($id_avaliacao)? '' : $id_avaliacao);?>"/>
                <input type="hidden" id="fgk_revisor" value="<?=ID_REVISOR;?>"/>
                <div class="panel panel-white">
                    
                    <div class="panel-body">
                        <h4>Avalie os seguintes itens do trabalho</h4>
                        <div class="col-md-4">
                            
                            <div class="form-group">
                                <label for="conclusao">Conclusão:</label>
                                <select class='form-control' id='conclusao' name='conclusao' required <?=(!isset($disabled)? '' : $disabled);?>>
                                    <option></option>
                                    <option value = 1 <?php if(isset($aval_conclusao) && $aval_conclusao == 1) echo "selected"; ?>>Inadequado</option>
                                    <option value = 2 <?php if(isset($aval_conclusao) && $aval_conclusao == 2) echo "selected"; ?>>Ruim</option>
                                    <option value = 3 <?php if(isset($aval_conclusao) && $aval_conclusao == 3) echo "selected"; ?>>Regular</option>
                                    <option value = 4 <?php if(isset($aval_conclusao) && $aval_conclusao == 4) echo "selected"; ?>>Bom</option>
                                    <option value = 5 <?php if(isset($aval_conclusao) && $aval_conclusao == 5) echo "selected"; ?>>Excelente</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="resultado">Resultado:</label>
                                <select class='form-control' id='resultado' name='resultado' required <?=(!isset($disabled)? '' : $disabled);?>>
                                    <option></option>
                                    <option value = 1 <?php if(isset($aval_resultado) && $aval_resultado == 1) echo "selected"; ?>>Inadequado</option>
                                    <option value = 2 <?php if(isset($aval_resultado) && $aval_resultado == 2) echo "selected"; ?>>Ruim</option>
                                    <option value = 3 <?php if(isset($aval_resultado) && $aval_resultado == 3) echo "selected"; ?>>Regular</option>
                                    <option value = 4 <?php if(isset($aval_resultado) && $aval_resultado == 4) echo "selected"; ?>>Bom</option>
                                    <option value = 5 <?php if(isset($aval_resultado) && $aval_resultado == 5) echo "selected"; ?>>Excelente</option>
                                </select>

                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="metodologia">Metodologia:</label>
                                <select class='form-control' id='metodologia' name='metodologia' required <?=(!isset($disabled)? '' : $disabled);?>>
                                    <option></option>
                                    <option value = 1 <?php if(isset($aval_metodologia) && $aval_metodologia == 1) echo "selected"; ?>>Inadequado</option>
                                    <option value = 2 <?php if(isset($aval_metodologia) && $aval_metodologia == 2) echo "selected"; ?>>Ruim</option>
                                    <option value = 3 <?php if(isset($aval_metodologia) && $aval_metodologia == 3) echo "selected"; ?>>Regular</option>
                                    <option value = 4 <?php if(isset($aval_metodologia) && $aval_metodologia == 4) echo "selected"; ?>>Bom</option>
                                    <option value = 5 <?php if(isset($aval_metodologia) && $aval_metodologia == 5) echo "selected"; ?>>Excelente</option>
                                </select>

                            </div> 
                            <div class="form-group">
                                <label for="redacao">Redação:</label>
                                <select class='form-control' id='redacao' name='redacao' required <?=(!isset($disabled)? '' : $disabled);?>>
                                    <option></option>
                                    <option value = 1 <?php if(isset($aval_redacao) && $aval_redacao == 1) echo "selected"; ?>>Inadequado</option>
                                    <option value = 2 <?php if(isset($aval_redacao) && $aval_redacao == 2) echo "selected"; ?>>Ruim</option>
                                    <option value = 3 <?php if(isset($aval_redacao) && $aval_redacao == 3) echo "selected"; ?>>Regular</option>
                                    <option value = 4 <?php if(isset($aval_redacao) && $aval_redacao == 4) echo "selected"; ?>>Bom</option>
                                    <option value = 5 <?php if(isset($aval_redacao) && $aval_redacao == 5) echo "selected"; ?>>Excelente</option>
                                </select>
                            </div>    
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <input type="hidden" id="fgk_avaliacao" value="<?=$id_avaliacao;?>"/>
                <input type="hidden" id="fgk_revisor" value="<?=ID_REVISOR;?>"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <h4>Dê uma nota de 1 a 10 e indique o resultado da avaliação</h4>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="titulo">Nota:</label>
                                <input type="number" class="form-control" id="nota" name="nota" min=0 max=10 value="<?=(!isset($nota)? '' : $nota);?>" required <?=(!isset($disabled)? '' : $disabled);?>>

                            </div>

                        </div> 
                        <div class="col-md-10">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Resultado</strong></label>
                                    <div class="col-md-10">
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="A" <?php if(isset($resultado) && $resultado == "A") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Aprovado</label>
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="AR" <?php if(isset($resultado) && $resultado == "AR") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Aprovado com Restrições</label>
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="R" <?php if(isset($resultado) && $resultado == "R") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Reprovado</label>
                                    </div>
                                </div>
                            </fieldset>
 
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo">Justificativa:</label>
                                <textarea class="form-control" rows="10" id="justificativa" <?=(!isset($disabled)? '' : $disabled);?>><?=(!isset($justificativa)? '' : $justificativa);?></textarea>

                            </div>

                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <input type="hidden" id="bool_caint" value="0"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                        
                        <div class="col-md-12">
                            <h4>Gostaria de fazer um comentário específico ao coordenador? (os autores não terão acesso a esta informação)</h4>
                            <div class="form-group">
                                <label for="area">Parecer:</label>
                                 <textarea class="form-control" rows="10" id="parecer" <?=(!isset($disabled)? '' : $disabled);?>><?=(!isset($parecer)? '' : $parecer);?></textarea>
                            </div> 

                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-danger" id="enviar" <?=(!isset($disabled)? '' : $disabled);?>>Salvar Avaliação</button>
                            <button class="btn btn-success" id="enviar2" data-toggle="modal" data-target="#confirm-submit" <?=(!isset($disabled)? '' : $disabled);?>>Submeter Avaliação</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else {
                echo '<div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="col-md-12">
                        <h4>Você não foi designado para revisar este trabalho. Caso deseje alterar esta informação, utilize o módulo de "Designação de Trabalhos" para trocar os atuais avaliadores.</h4>
                        </div>
                    </div>
                </div>
            </div>';
            } ?>
        </form>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->



    <?php    }
     } if($bool_caint == 1) {
          $verifica_trabalho = $db->sql_query("SELECT revisor1.id as id_revisor1, revisor2.id as id_revisor2, descricao_area,
                                              inscrito1.id as id_inscrito1, inscrito2.id as id_inscrito2,curso_aluno, es_trabalho_caint.curso_area_destaque,
                                              es_trabalho_caint.questoes_linguisticas, es_trabalho_caint.tipo_moradia, es_trabalho_caint.sistema_avaliacao, 
                                              es_trabalho_caint.dinamica_metodologia_aulas, es_trabalho_caint.custo_vida,es_trabalho_caint.infra_universidade,
                                              es_trabalho_caint.servico_acolhimento, es_trabalho_caint.estagio, es_trabalho_caint.atividades_universidade,
                                              es_trabalho_caint.processo_adaptacao,es_trabalho_caint.relato_pessoal, es_trabalho_caint.conselhos_calouro

                                            FROM es_avaliacao 
                                            LEFT JOIN es_trabalho_caint ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho
                                            LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho_caint.fgk_area
                                            LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                            LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                            LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                            LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                            WHERE  es_avaliacao.id = ? AND es_trabalho_caint.fgk_evento = ?",
                                            array('es_avaliacao.id' =>$id_avaliacao, 'es_trabalho_caint.fgk_evento'=>EVENTO_ATUAL ));
        foreach ($verifica_trabalho as $trabalho) {
            $curso_area_destaque = $trabalho->curso_area_destaque;
            $questoes_linguisticas = $trabalho->questoes_linguisticas;
            $tipo_moradia = $trabalho->tipo_moradia;
            $sistema_avaliacao = $trabalho->sistema_avaliacao;
            $dinamica_metodologia_aulas = $trabalho->dinamica_metodologia_aulas;
            $custo_vida = $trabalho->custo_vida;
            $infra_universidade = $trabalho->infra_universidade;
            $servico_acolhimento = $trabalho->servico_acolhimento;
            $estagio = $trabalho->estagio;
            $atividades_universidade = $trabalho->atividades_universidade;
            $processo_adaptacao = $trabalho->processo_adaptacao;
            $relato_pessoal = $trabalho->relato_pessoal;
            $conselhos_calouro = $trabalho->conselhos_calouro;
            $descricao_area = $trabalho->descricao_area;
            $inscrito1 = $trabalho->id_inscrito1;
            $inscrito2 = $trabalho->id_inscrito2;
            $revisor1 = $trabalho->id_revisor1;
            $revisor2 = $trabalho->id_revisor2;
        }

        if($inscrito1 == ID_USUARIO)
            $id_revisor = $revisor1;
        else if($inscrito2 == ID_USUARIO)
            $id_revisor = $revisor2;

        $existe_avaliacao = $db->sql_query("SELECT * FROM es_avaliacao_revisao WHERE fgk_avaliacao = ? AND fgk_revisor = ?",
		array('fgk_avaliacao'=>$id_avaliacao, 'fgk_revisor'=>$id_revisor));
        if($existe_avaliacao){
			foreach ($existe_avaliacao as $registro) {
				$id_avaliacao_revisao = $registro->id;
				$aval_conclusao = $registro->aval_conclusao;
				$aval_metodologia = $registro->aval_metodologia;
				$aval_redacao = $registro->aval_redacao;
				$aval_resultado = $registro->aval_resultado;
				$justificativa = $registro->justificativa;
				$nota = $registro->nota;
				$parecer = $registro->parecer;
				$resultado = $registro->resultado;
				$status = $registro->status;
			}
			if(isset($status) && $status == 2)
				$disabled = "disabled";
			else
				$disabled = "";
		}

      ?>
      <div class="page-inner">
    <div class="page-title">
        <h3>Encontro de Saberes</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="index.php">Avaliar Trabalhos</a></li>
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
                                <label for="area"><strong>01. Quais são áreas/cursos de destaque da Universidade em que você esteve?  </strong></label>
                                <p class="text-justify"><?=$curso_area_destaque;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>02. Fale sobre a questão linguística na Universidade de destino: se haviam cursos de idiomas, como funcionavam, se haviam disciplinas ofertadas em outros idiomas, a dificuldades enfrentadas.</strong></label>
                                <p class="text-justify"><?=$questoes_linguisticas;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="titulo"><strong>03. Descreva o tipo de moradia que você utilizou durante sua mobilidade (gratuita ou não, compartilhada, demais ofertas de imóveis e possibilidades, valores, estrutura...).</strong></label>
                                <p class="text-justify"><?=$tipo_moradia;?></p>
                            </div>
                            <div class="form-group">
                                <label for="resumo"><strong>04. Descreva como é o sistema de avaliação e notas da Universidade onde esteve (Formas de avaliação, grau de dificuldade, formas de preparação para as avaliações, curiosidades...)</strong></label>
                                <p class="text-justify"><?=$sistema_avaliacao;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>05. Descreva como é a dinâmica/metodologia das aulas na Universidade de destino. Fale sobre o formato das aulas, atividades práticas e teóricas, trabalhos em grupo, monitorias. Aproveite e faça um comparativo com o nosso modelo aqui na UFOP.</strong></label>
                                <p class="text-justify"><?=$dinamica_metodologia_aulas;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>06. Descreva o custo de vida para um estudante na cidade/país onde você morou. Fale sobre alguns preços, comparativos, principais despesas, vantagens, desvantagens...</strong></label>
                                <p class="text-justify"><?=$custo_vida;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>07. Fale sobre a infra estrutura da Universidade em que esteve: laboratórios, bibliotecas, centros esportivos, parte administrativa, salas de aula e estudo...</strong></label>
                                <p class="text-justify"><?=$infra_universidade;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>08. Como funciona o serviço de acolhimento e suporte a alunos estrangeiros na Universidade de destino?</strong></label>
                                <p class="text-justify"><?=$servico_acolhimento;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>09. Com relação ao estágio? Como ele é considerado e avaliado na Universidade onde estudou? E em relação à oferta? Como localizar um estágio? A Universidade dá algum suporte? Como foi a experiência ao realizar o estágio.</strong></label>
                                <p class="text-justify"><?=$estagio;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>10. Quais atividades são oferecidas pela Universidade de destino: Fale sobre grupos de estudos, atividades de pesquisa, esporte, atividades culturais, lazer...</strong></label>
                                <p class="text-justify"><?=$atividades_universidade;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>11. Como foi o seu processo de adaptação à cidade e ao país de destino? Dificuldades com clima, idioma, receptividade, inserção cultural.</strong></label>
                                <p class="text-justify"><?=$processo_adaptacao;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>12. Relato pessoal. Fale sobre a sua experiência pessoal de maneira geral, sobre demais atividades acadêmicas, esportivas, culturais que desenvolveu, experiências profissionais, amadurecimento, rede de contatos (tente priorizar as atividades relacionadas à sua formação pessoal, acadêmica e profissional, evitando expor elementos exclusivamente de entreterimento).</strong></label>
                                <p class="text-justify"><?=$relato_pessoal;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>13. Quais conselhos você poderia dar para um calouro que quer se preparar para fazer mobilidade na mesma Universidade/país que você esteve?</strong></label>
                                <p class="text-justify"><?=$conselhos_calouro;?></p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if(ID_USUARIO == $inscrito1 || ID_USUARIO == $inscrito2){
            ?>
            <div class="col-md-12">
                <input type="hidden" id="id_avaliacao_revisao" value="<?=$id_avaliacao_revisao;?>"/>
                <input type="hidden" id="fgk_avaliacao" value="<?=$id_avaliacao;?>"/>
                <input type="hidden" id="fgk_revisor" value="<?=ID_REVISOR;?>"/>
                
            </div>
            <div class="col-md-12">
                <input type="hidden" id="fgk_avaliacao" value="<?=$id_avaliacao;?>"/>
                <input type="hidden" id="fgk_revisor" value="<?=ID_REVISOR;?>"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <h4>Dê uma nota de 1 a 10 e indique o resultado da avaliação</h4>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="titulo">Nota:</label>
                                <input type="number" class="form-control" id="nota" name="nota" min=0 max=10 value="<?=(!isset($nota)? '' : $nota);?>" required <?=(!isset($disabled)? '' : $disabled);?>>

                            </div>

                        </div> 
                        <div class="col-md-10">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Resultado</strong></label>
                                    <div class="col-md-10">
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="A" <?php if(isset($resultado) && $resultado == "A") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Aprovado</label>
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="AR" <?php if(isset($resultado) && $resultado == "AR") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Aprovado com Restrições</label>
                                        <label class="radio-inline"><input type="radio" name="resultado_final" value="R" <?php if(isset($resultado) && $resultado == "R") echo "checked='checked'"; ?> <?=(!isset($disabled)? '' : $disabled);?>>Reprovado</label>
                                    </div>
                                </div>
                            </fieldset>
 
                        </div>
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo">Justificativa:</label>
                                <textarea class="form-control" rows="10" id="justificativa" <?=(!isset($disabled)? '' : $disabled);?>><?=(!isset($justificativa)? '' : $justificativa);?></textarea>

                            </div>

                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <input type="hidden" id="bool_caint" value="0"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                       
                        
                        <div class="col-md-12">
                            <h4>Gostaria de fazer um comentário específico ao coordenador? (os autores não terão acesso a esta informação)</h4>
                            <div class="form-group">
                                <label for="area">Parecer:</label>
                                 <textarea class="form-control" rows="10" id="parecer" <?=(!isset($disabled)? '' : $disabled);?>><?=(!isset($parecer)? '' : $parecer);?></textarea>
                            </div> 

                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-danger" id="enviar" <?=(!isset($disabled)? '' : $disabled);?>>Salvar Avaliação</button>
                            <button class="btn btn-success" id="enviar2" data-toggle="modal" data-target="#confirm-submit" <?=(!isset($disabled)? '' : $disabled);?>>Submeter Avaliação</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else {
                echo '<div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="col-md-12">
                        <h4>Você não foi designado para revisar este trabalho. Caso deseje alterar esta informação, utilize o módulo de "Designação de Trabalhos" para trocar os atuais avaliadores.</h4>
                        </div>
                    </div>
                </div>
            </div>';
            } ?>
        </form>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <?php } ?>
               

<?php
    include "footer.php";
?>

<script src="assets/js/pages/revisar_trabalho.js"></script>
</body>
</html>