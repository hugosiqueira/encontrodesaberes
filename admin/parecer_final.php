<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ($_SESSION['logado'] === true) {
    include "header.php";
    include "menu.php";

    ?> 
<link rel="stylesheet" href="assets/css/dataTables.tableTools.css"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<style>
    .myButton {
        width: 170px;
    }
    .myButton2 {
        width: 190px;
    }


    table.dataTable.select tbody tr,
        table.dataTable thead th:first-child {
          cursor: pointer;
    }

</style>


    <div class="page-inner">
        <div class="page-title">
            <h3>Encontro de Saberes</h3>
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="index.php">Revisão de Trabalhos</a></li>
                </ol>
            </div>
        </div>
        <div id="main-wrapper">
           
            <div class="row">
                <div class="col-md-12">
                 <?php  if(TIPO_USUARIO  == 5 || (AREA_COORDENACAO != 8 && BOOL_COORDENADOR == 1 && DATA_PARECER_FINAL_INI <= date('Y-m-d H:i:s') && DATA_PARECER_FINAL_FIM >= date('Y-m-d H:i:s'))){ ?>

                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">Confirmar Avaliações</h3>
                        </div>

                        <div class="panel-body">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <br/>
                                        <label for="alocados">Trabalhos</label>
                                        <select class='form-control' id='alocados' name='alocados' required>
                                            <option></option>
                                            <option value="6">Aprovados no primeiro parecer</option>
                                            <option value="8">Reprovados no primeiro parecer</option>
                                            <option value="13">Aprovados com Restrições (Aguardando Parecer Final)</option>
                                            <option value="7">Aprovados com Restrições (Não enviou correções)</option>
                                            <option value="14">Aprovados no parecer final</option>
                                            <option value="15">Reprovados no parecer final</option>
                                           
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="area_especifica">Área Específica</label>
                                        <select class='form-control' id='area_especifica' name='area_especifica'>
                                            <option></option>
                                            <?php
                                            if (TIPO_USUARIO == ADMINISTRADOR) {
                                                $stmt = $db->sql_query('SELECT * FROM es_area_especifica');
                                            } else {
                                                $stmt = $db->sql_query('SELECT * FROM es_area_especifica WHERE fgk_area = ?', array('fgk_area' => $_SESSION['area_coordenacao']));
                                            }
                                            foreach ($stmt as $registro) {
                                                echo '<option value="' . $registro->descricao_area_especifica . '"  >' . $registro->descricao_area_especifica . ' </option>';
                                            }
                                            ?>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="titulo">Título</label>
                                        <input type="text" id="titulo" class="form-control"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="revisor">Revisor</label>
                                        <select class='form-control' id='revisor' name='revisor'>
                                            <option></option>
                                            <?php
                                            
                                                $stmt = $db->sql_query('SELECT nome
                                                                        FROM es_avaliacao_revisor
                                                                          LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                                                                          ORDER BY nome ASC');
                                            
                                            foreach ($stmt as $registro) {
                                                echo '<option value="' . $registro->nome . '"  >' . $registro->nome . ' </option>';
                                            }
                                            ?>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7">
                                        <button class="btn btn-success myButton" id="aprovar">Aprovar</button>
                                        <button class="btn btn-danger myButton" id="reprovar">Reprovar</button>
                                    </div>
                                </div>
                                
                            </div>
                            
                                    
                                        <table id="resumo" class="table table-striped table-bordered display select" style="width:99%">
                                            <?php
                                            if (TIPO_USUARIO == ADMINISTRADOR) {
                                                $stmt = $db->sql_query('Select es_trabalho.fgk_categoria, es_trabalho.fgk_status as status_trabalho,  es_avaliacao.id, es_avaliacao.fgk_trabalho, es_avaliacao.status, es_avaliacao.nota, es_avaliacao.parecer, es_avaliacao.parecer_ar, es_avaliacao.resultado, es_avaliacao.bool_caint,
                                                                        case es_avaliacao.status
                                                                           WHEN 0 THEN "NÃO AVALIADO"
                                                                           WHEN 1 THEN "AVALIADO SOMENTE POR 1 REVISOR"
                                                                           WHEN 2 THEN "AVALIADO"
                                                                        END as avaliacao_status_descricao, revisao1.status as status_revisao1, revisao2.status as status_revisao2,es_trabalho.fgk_status as trabalho_status,

                                                                        es_trabalho.id as trabalho_id, es_trabalho.titulo_enviado as trabalho_titulo, es_trabalho.palavras_chave as trabalho_palavras_chaves, es_trabalho.resumo_enviado as trabalho_resumo_enviado, es_area_especifica.descricao_area_especifica as trabalho_area,
                                                                        fgk_revisor1, nome_inscrito1.nome as nome_revisor1, coalesce(area_especifica_revisor1.descricao_area_especifica,"") as area_especifica_revisor1, revisao1.aval_conclusao as aval_conclusao1, revisao1.aval_metodologia as aval_metodologia1, revisao1.aval_redacao as aval_redacao1, revisao1.aval_resultado as aval_resultado1, revisao1.status as status1, revisao1.justificativa as justiticativa1, revisao1.nota as nota1, revisao1.parecer as parecer1, revisao1.resultado as resultado1,

                                                                        fgk_revisor2, nome_inscrito2.nome as nome_revisor2, coalesce(area_especifica_revisor2.descricao_area_especifica,"") as area_especifica_revisor2, revisao2.aval_conclusao as aval_conclusao2, revisao2.aval_metodologia as aval_metodologia2, revisao2.aval_redacao as aval_redacao2, revisao2.aval_resultado as aval_resultado2, revisao2.status as status2, revisao2.justificativa as justiticativa2, revisao2.nota as nota2, revisao2.parecer as parecer2, revisao2.resultado as resultado2

                                                                        from es_avaliacao

                                                                        INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
                                                                        LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor1 ON es_avaliacao.fgk_revisor1 = avaliacao_revisor1.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor1 ON avaliacao_revisor1.fgk_area_especifica = area_especifica_revisor1.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito1 ON nome_inscrito1.id = avaliacao_revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao1 ON revisao1.fgk_avaliacao = es_avaliacao.id and revisao1.fgk_revisor = es_avaliacao.fgk_revisor1
                                                                        LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = revisao1.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor2 ON es_avaliacao.fgk_revisor2 = avaliacao_revisor2.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor2 ON avaliacao_revisor2.fgk_area_especifica = area_especifica_revisor2.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito2 ON nome_inscrito2.id = avaliacao_revisor2.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao2 ON revisao2.fgk_avaliacao = es_avaliacao.id and revisao2.fgk_revisor = es_avaliacao.fgk_revisor2
                                                                        LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = revisao2.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                        WHERE es_trabalho.fgk_categoria <= 3');
                                            } else {
                                                if(AREA_COORDENACAO<=5){
                                                    $stmt = $db->sql_query('SELECT es_trabalho.fgk_categoria, es_trabalho.fgk_status as status_trabalho, es_avaliacao.id, es_avaliacao.fgk_trabalho, es_avaliacao.status, es_avaliacao.nota, es_avaliacao.parecer, es_avaliacao.parecer_ar, es_avaliacao.resultado, es_avaliacao.bool_caint,
                                                                        case es_avaliacao.status
                                                                           WHEN 0 THEN "NÃO AVALIADO"
                                                                           WHEN 1 THEN "AVALIADO SOMENTE POR 1 REVISOR"
                                                                           WHEN 2 THEN "AVALIADO"
                                                                        END as avaliacao_status_descricao, revisao1.status as status_revisao1, revisao2.status as status_revisao2,es_trabalho.fgk_status as trabalho_status,

                                                                        es_trabalho.id as trabalho_id, es_trabalho.titulo_enviado as trabalho_titulo, es_trabalho.palavras_chave as trabalho_palavras_chaves, es_trabalho.resumo_enviado as trabalho_resumo_enviado, es_area_especifica.descricao_area_especifica as trabalho_area,
                                                                        fgk_revisor1, nome_inscrito1.nome as nome_revisor1, coalesce(area_especifica_revisor1.descricao_area_especifica,"") as area_especifica_revisor1, revisao1.aval_conclusao as aval_conclusao1, revisao1.aval_metodologia as aval_metodologia1, revisao1.aval_redacao as aval_redacao1, revisao1.aval_resultado as aval_resultado1, revisao1.status as status1, revisao1.justificativa as justiticativa1, revisao1.nota as nota1, revisao1.parecer as parecer1, revisao1.resultado as resultado1,

                                                                        fgk_revisor2, nome_inscrito2.nome as nome_revisor2, coalesce(area_especifica_revisor2.descricao_area_especifica,"") as area_especifica_revisor2, revisao2.aval_conclusao as aval_conclusao2, revisao2.aval_metodologia as aval_metodologia2, revisao2.aval_redacao as aval_redacao2, revisao2.aval_resultado as aval_resultado2, revisao2.status as status2, revisao2.justificativa as justiticativa2, revisao2.nota as nota2, revisao2.parecer as parecer2, revisao2.resultado as resultado2

                                                                        from es_avaliacao

                                                                        INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
                                                                        LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor1 ON es_avaliacao.fgk_revisor1 = avaliacao_revisor1.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor1 ON avaliacao_revisor1.fgk_area_especifica = area_especifica_revisor1.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito1 ON nome_inscrito1.id = avaliacao_revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao1 ON revisao1.fgk_avaliacao = es_avaliacao.id and revisao1.fgk_revisor = es_avaliacao.fgk_revisor1
                                                                        LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = revisao1.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor2 ON es_avaliacao.fgk_revisor2 = avaliacao_revisor2.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor2 ON avaliacao_revisor2.fgk_area_especifica = area_especifica_revisor2.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito2 ON nome_inscrito2.id = avaliacao_revisor2.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao2 ON revisao2.fgk_avaliacao = es_avaliacao.id and revisao2.fgk_revisor = es_avaliacao.fgk_revisor2
                                                                        LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = revisao2.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito 
                                                                        WHERE es_trabalho.fgk_evento = '. EVENTO_ATUAL .' AND es_trabalho.fgk_area =' . AREA_COORDENACAO . ' AND es_trabalho.fgk_categoria = 1'
                                                    );
                                                } else {
                                                         switch(AREA_COORDENACAO){
                                                             case 6:
                                                                $id_categoria = 3;
                                                                $where = " OR es_trabalho.fgk_categoria = 6 OR es_trabalho.fgk_categoria = 7 OR es_trabalho.fgk_categoria =8 ";
                                                            break;
                                                            case 7:
                                                                $id_categoria = 2;
                                                                $where = "";
                                                            break;
                                                            case 9:
                                                                $id_categoria = 6;
                                                                $where = "";
                                                            break;
                                                            case 10:
                                                                $id_categoria = 7;
                                                                $where = "";
                                                            break;
                                                             case 11:
                                                                $id_categoria = 8;
                                                                $where = "";
                                                            break;


                                                         }
                                                          $stmt = $db->sql_query('SELECT es_trabalho.fgk_categoria, es_trabalho.fgk_status as status_trabalho, es_avaliacao.id, es_avaliacao.fgk_trabalho, es_avaliacao.status, es_avaliacao.nota, es_avaliacao.parecer, es_avaliacao.parecer_ar, es_avaliacao.resultado, es_avaliacao.bool_caint,
                                                                        case es_avaliacao.status
                                                                           WHEN 0 THEN "NÃO AVALIADO"
                                                                           WHEN 1 THEN "AVALIADO SOMENTE POR 1 REVISOR"
                                                                           WHEN 2 THEN "AVALIADO"
                                                                        END as avaliacao_status_descricao, revisao1.status as status_revisao1, revisao2.status as status_revisao2,

                                                                        es_trabalho.id as trabalho_id, es_trabalho.titulo_enviado as trabalho_titulo, es_trabalho.palavras_chave as trabalho_palavras_chaves, es_trabalho.resumo_enviado as trabalho_resumo_enviado, es_area_especifica.descricao_area_especifica as trabalho_area, es_trabalho.fgk_status as trabalho_status,
                                                                        fgk_revisor1, nome_inscrito1.nome as nome_revisor1, coalesce(area_especifica_revisor1.descricao_area_especifica,"") as area_especifica_revisor1, revisao1.aval_conclusao as aval_conclusao1, revisao1.aval_metodologia as aval_metodologia1, revisao1.aval_redacao as aval_redacao1, revisao1.aval_resultado as aval_resultado1, revisao1.status as status1, revisao1.justificativa as justiticativa1, revisao1.nota as nota1, revisao1.parecer as parecer1, revisao1.resultado as resultado1,

                                                                        fgk_revisor2, nome_inscrito2.nome as nome_revisor2, coalesce(area_especifica_revisor2.descricao_area_especifica,"") as area_especifica_revisor2, revisao2.aval_conclusao as aval_conclusao2, revisao2.aval_metodologia as aval_metodologia2, revisao2.aval_redacao as aval_redacao2, revisao2.aval_resultado as aval_resultado2, revisao2.status as status2, revisao2.justificativa as justiticativa2, revisao2.nota as nota2, revisao2.parecer as parecer2, revisao2.resultado as resultado2

                                                                        from es_avaliacao

                                                                        INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
                                                                        LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor1 ON es_avaliacao.fgk_revisor1 = avaliacao_revisor1.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor1 ON avaliacao_revisor1.fgk_area_especifica = area_especifica_revisor1.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito1 ON nome_inscrito1.id = avaliacao_revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao1 ON revisao1.fgk_avaliacao = es_avaliacao.id and revisao1.fgk_revisor = es_avaliacao.fgk_revisor1
                                                                        LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = revisao1.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor2 ON es_avaliacao.fgk_revisor2 = avaliacao_revisor2.id
                                                                        LEFT JOIN es_area_especifica as area_especifica_revisor2 ON avaliacao_revisor2.fgk_area_especifica = area_especifica_revisor2.id
                                                                        LEFT JOIN es_inscritos as nome_inscrito2 ON nome_inscrito2.id = avaliacao_revisor2.fgk_inscrito

                                                                        LEFT JOIN es_avaliacao_revisao as revisao2 ON revisao2.fgk_avaliacao = es_avaliacao.id and revisao2.fgk_revisor = es_avaliacao.fgk_revisor2
                                                                        LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = revisao2.fgk_revisor
                                                                        LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito 
                                                                        WHERE es_trabalho.fgk_evento = '.EVENTO_ATUAL.'  AND (es_trabalho.fgk_categoria = ' . $id_categoria  . $where .')'
                                                    );
                                                }
                                                         
                                            }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th><input name="select_all" value="1" type="checkbox"></th>
                                                    <th>Área</th>
                                                    <th>Título</th>
                                                    <th>Revisor 1</th>
                                                    <th>Revisor 2</th>
                                                    <th>Situação</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=0;
                                                foreach ($stmt as $resumo) {
                                                    if($resumo->resultado1 == 'R' && $resumo->status_revisao1 == 2) $status1 = "<span class='btn btn-danger myButton2' style='font-size: 15px;'>Reprovado</span>";
                                                    else if($resumo->resultado1 == 'AR' && $resumo->status_revisao1 == 2) $status1 = "<span class='btn btn-warning myButton2' style='font-size: 14px;'>Aprovado com Restrições</span>";
                                                    else if($resumo->resultado1 == 'A' && $resumo->status_revisao1 == 2) $status1 = "<span class='btn btn-success myButton2' style='font-size: 15px;'>Aprovado</span>";
                                                    else $status1 = "<span class='btn btn-primary myButton2' style='font-size: 15px;'>Aguardando Revisão</span>";
                                                    if($resumo->resultado2 == 'R' && $resumo->status_revisao2 == 2) $status2 = "<span class='btn btn-danger myButton2' style='font-size: 15px;'>Reprovado</span>";
                                                    else if($resumo->resultado2 == 'AR' && $resumo->status_revisao2 == 2) $status2 = "<span class='btn btn-warning myButton2' style='font-size: 14px;'>Aprovado com Restrições</span>";
                                                    else if($resumo->resultado2 == 'A' && $resumo->status_revisao2 == 2) $status2 = "<span class='btn btn-success myButton2' style='font-size: 15px;'>Aprovado</span>";
                                                    else $status2 ="<span class='btn btn-primary myButton2' style='font-size: 15px;'>Aguardando Revisão</span>";
                                                    if ($resumo->status_trabalho == 13 || $resumo->status_trabalho == 7)
                                                        $imagem_avaliado = "<img class = 'img-responsive' src='assets/images/icons/icon_aguarde.png'  >";
                                                    else 
														$imagem_avaliado = "<img class = 'img-responsive' src='assets/images/icons/ok.png'  >";

                                                    switch ($resumo->trabalho_status) {
                                                        case '6':
                                                            echo '<tr><td><span class="label label-success myButton2" style="font-size: 15px;">'.$resumo->resultado.'</td>';
                                                            break;
                                                        case '7':
                                                            echo '<tr><td><input type="checkbox" name="id_avaliacao" id="id_avaliacao'.$i.'" value="'.$resumo->id.'" /></td>';
                                                            break;
                                                        case '8':
                                                            echo '<tr><td><span class="label label-danger myButton2" style="font-size: 15px;">'.$resumo->resultado.'</td>';
                                                            break;
                                                        case '13':
                                                            echo '<tr><td><input type="checkbox" name="id_avaliacao" id="id_avaliacao'.$i.'" value="'.$resumo->id.'" /></td>';
                                                            break;
                                                        case '14':
                                                            echo '<tr><td><span class="label label-success myButton2" style="font-size: 15px;">'.$resumo->resultado.'</td>';
                                                            break;
                                                        case '15':
                                                            echo '<tr><td><span class="label label-danger myButton2" style="font-size: 15px;">'.$resumo->resultado.'</td>';
                                                            break;
                                                        
                                                        default:
                                                            echo '<tr><td></td>';
                                                            break;
                                                    }
													
													if($resumo->fgk_categoria == 7)
														$resumo->trabalho_area = 'PIBID';
                                                   
                                                    echo '
                                                            
                                                            <td id="area">' . $resumo->trabalho_area . '</td>
                                                            <td align="left"><a href="cadastrar_parecer_final.php?id=' . $resumo->id. '">' . $resumo->trabalho_titulo . '</a></td>
                                                            <td><a href="#" data-toggle="tooltip" data-html="true" title="Revisor: '.$resumo->nome_revisor1.'<br>Nota: '.$resumo->nota1.'<br> Resultado: '.$resumo->resultado1.'">'.$status1.'</a></td>
                                                            <td><a href="#" data-toggle="tooltip" data-html="true" title="Revisor: '.$resumo->nome_revisor2.'<br>Nota: '.$resumo->nota2.'<br> Resultado: '.$resumo->resultado2.'">'.$status2.'</a></td>
                                                            <td>' . $imagem_avaliado . '</td>
                                                            <td><span style="display:none">' . $resumo->trabalho_status . '</span></td>
                                                            <td><span style="display:none">'.$resumo->nome_revisor1.'</span></td>
                                                            <td><span style="display:none">'.$resumo->nome_revisor2.'</span></td>
                                                        </tr>';
                                                    $i++;
                                                }
                                                ?>
                                            </tbody> 
                                        </table>

    <?php } else {
        echo " <div class='panel-body'>Não estamos no período de emissões de pareceres.<br> Início: " . date('d/m/Y - H:i:s', strtotime(DATA_PARECER_FINAL_INI)) . "<br>Fim: " . date('d/m/Y - H:i:s', strtotime(DATA_PARECER_FINAL_FIM)) . "</div>";
    }
     ?>
                                                        
                        </div>

                    </div>

                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->

        <?php
         include "footer.php";

        ?>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
        
            $('#revisor').select2();
            var rows_selected = [];
            var table = $('#resumo').DataTable({
                "bSort": false,
                "bProcessing": true,
                "bdeferRender": true,
                dom: 'T<"top"i>frt<"clear">lp',
                "columns": [
                    {"width": "5%"},
                    {"width": "15%"},
                    {"width": "55%"},
                    {"width": "10%"},
                    {"width": "10%"},
                    {"width": "5%"},
                    null,
                    null,
                    null

                ],
                 columnDefs: [{
                        "targets": [ 6 ],
                        "visible": false
                    },{
                       "targets": [ 7 ],
                        "visible": false 
                    },{
                       "targets": [ 8 ],
                        "visible": false 
                    }],
                "language": {
                    "emptyTable": "Até este momento você não possui trabalhos para revisar."
                },
                'rowCallback' : function(row, data, dataIndex){
                    // Get row ID
                    var rowId = data[0];

                    // If row ID is in the list of selected row IDs
                    if($.inArray(rowId, rows_selected) !== -1){
                       $(row).find('input[type="checkbox"]').prop('checked', true);
                       $(row).addClass('selected');
                    }
                }

            });
            $("#alocados").val('13');
            table.column(6).search( "13" ).draw();
            $('#area_especifica').on( 'change', function () {
                table.column(1).search( this.value ).draw();
            } );
            $('#titulo').on( 'keyup', function () {
                table.column(2).search( this.value ).draw();
            } );
            $('#alocados').on( 'change', function () {
                table.column(6).search( this.value ).draw();
            } );
             $('#revisor').on( 'change', function () {
                table.search( this.value ).draw();
            } );
            
            function updateDataTableSelectAllCtrl(table){
                var $table             = table.table().node();
                var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
                var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
                var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

                // If none of the checkboxes are checked
                if($chkbox_checked.length === 0){
                   chkbox_select_all.checked = false;
                   if('indeterminate' in chkbox_select_all){
                      chkbox_select_all.indeterminate = false;
                   }

                // If all of the checkboxes are checked
                } else if ($chkbox_checked.length === $chkbox_all.length){
                   chkbox_select_all.checked = true;
                   if('indeterminate' in chkbox_select_all){
                      chkbox_select_all.indeterminate = false;
                   }

                // If some of the checkboxes are checked
                } else {
                   chkbox_select_all.checked = true;
                   if('indeterminate' in chkbox_select_all){
                      chkbox_select_all.indeterminate = true;
                   }
                }
             }

             $('#resumo tbody').on('click', 'input[type="checkbox"]', function(e){
               var $row = $(this).closest('tr');

               // Get row data
               var data = table.row($row).data();

               // Get row ID
               var rowId = data[0];

               // Determine whether row ID is in the list of selected row IDs 
               var index = $.inArray(rowId, rows_selected);

               // If checkbox is checked and row ID is not in list of selected row IDs
               if(this.checked && index === -1){
                  rows_selected.push(rowId);

               // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
               } else if (!this.checked && index !== -1){
                  rows_selected.splice(index, 1);
               }

               if(this.checked){
                  $row.addClass('selected');
               } else {
                  $row.removeClass('selected');
               }

               // Update state of "Select all" control
               updateDataTableSelectAllCtrl(table);

               // Prevent click event from propagating to parent
               e.stopPropagation();
            });

             $('#resumo thead input[name="select_all"]').on('click', function(e){
               if(this.checked){
                  $('#resumo tbody input[type="checkbox"]:not(:checked)').trigger('click');
               } else {
                  $('#resumo tbody input[type="checkbox"]:checked').trigger('click');
               }

               // Prevent click event from propagating to parent
               e.stopPropagation();
            });
             $('#resumo').on('click', 'tbody td, thead th:first-child', function(e){
               $(this).parent().find('input[type="checkbox"]').trigger('click');
            });
             table.on('draw', function(){
               // Update state of "Select all" control
               updateDataTableSelectAllCtrl(table);
            });
            
            $('#aprovar').on( 'click', function () {

                $("input[name='id_avaliacao']:checked").each(function(){
                    var $row = $(this).closest('tr');

                    var data = table.row($row).data();

                    $.post('a_avaliacao_final.php', {
                            id_avaliacao:$(this).val(), resultado:'A'}, 
                            function(resposta) {
                                if (resposta == "sucesso") {
                                    // Exibe o erro na div

                                    $("#processando").modal("hide");

                                    BootstrapDialog.show({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        closable: false,
                                        title: 'Obrigado',
                                        message: '<p>Parecer submetido com sucesso.</p>',
                                        buttons: [{
                                            id: 'btn-ok',   
                                            icon: 'glyphicon glyphicon-check',       
                                            label: 'Fechar.',
                                            cssClass: 'btn-primary', 
                                            autospin: false,
                                            action: function(dialogRef){    
                                                dialogRef.close();
                                                location.href="parecer_final.php";
                                            }
                                        }]
                                    });
                                } 
                                // Se resposta for false, ou seja, não ocorreu nenhum erro
                                else {
                                    // Exibe mensagem de sucesso

                                    $("#processando").modal("hide");
                                    BootstrapDialog.show({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        title: 'Erro',
                                        message: 'Houve um erro ao avaliar o trabalho, contate a organização do Encontro de Saberes.',
                                        buttons: [{
                                            id: 'btn-ok',   
                                            icon: 'glyphicon glyphicon-check',       
                                            label: 'Fechar.',
                                            cssClass: 'btn-primary', 
                                            autospin: false,
                                            action: function(dialogRef){    
                                                dialogRef.close();
                                            }
                                        }]
                                    });

                                }
                            }
                        );
                });

            });
            
            $('#reprovar').on( 'click', function () {

                $("input[name='id_avaliacao']:checked").each(function(){
                    var $row = $(this).closest('tr');

                    var data = table.row($row).data();

                    $.post('a_avaliacao_final.php', {
                            id_avaliacao:$(this).val(),  resultado:'R'}, 
                            function(resposta) {
                                if (resposta == "sucesso") {
                                    // Exibe o erro na div

                                    $("#processando").modal("hide");

                                    BootstrapDialog.show({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        closable: false,
                                        title: 'Obrigado',
                                        message: '<p>Parecer submetido com sucesso.</p>',
                                        buttons: [{
                                            id: 'btn-ok',   
                                            icon: 'glyphicon glyphicon-check',       
                                            label: 'Fechar.',
                                            cssClass: 'btn-primary', 
                                            autospin: false,
                                            action: function(dialogRef){    
                                                dialogRef.close();
                                                location.href="parecer_final.php";
                                            }
                                        }]
                                    });
                                } 
                                // Se resposta for false, ou seja, não ocorreu nenhum erro
                                else {
                                    // Exibe mensagem de sucesso

                                    $("#processando").modal("hide");
                                    BootstrapDialog.show({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        title: 'Erro',
                                        message: 'Houve um erro ao avaliar o trabalho, informe a organização.',
                                        buttons: [{
                                            id: 'btn-ok',   
                                            icon: 'glyphicon glyphicon-check',       
                                            label: 'Fechar.',
                                            cssClass: 'btn-primary', 
                                            autospin: false,
                                            action: function(dialogRef){    
                                                dialogRef.close();
                                            }
                                        }]
                                    });

                                }
                            }
                        );
                });

            });

        });

    </script>
    </body>

    </html>
<?php } ?>
>
