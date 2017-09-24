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
    $sql_avaliacao = "Select es_avaliacao.id, es_avaliacao.parecer_ar, es_avaliacao.resultado, es_avaliacao.fgk_trabalho, es_avaliacao.status, es_avaliacao.nota, es_avaliacao.parecer, es_avaliacao.parecer_ar, es_avaliacao.resultado, es_avaliacao.bool_caint as avaliacao_bool_caint,
case es_avaliacao.status
   WHEN 0 THEN 'NÃO AVALIADO'
   WHEN 1 THEN 'AVALIADO SOMENTE POR 1 REVISOR'
   WHEN 2 THEN 'AVALIADO'
END as avaliacao_status_descricao, revisao1.status as status_revisao1, revisao2.status as status_revisao2, es_trabalho.fgk_status as trabalho_status,

es_trabalho.id as trabalho_id, es_trabalho.titulo_enviado as trabalho_titulo, es_trabalho.titulo_revisado as trabalho_titulo_revisado, es_trabalho.palavras_chave as trabalho_palavras_chaves, es_trabalho.palavras_chave_revisado as trabalho_palavras_chave_revisado,  es_trabalho.resumo_enviado as trabalho_resumo_enviado, es_trabalho.resumo_revisado as trabalho_resumo_revisado, es_ufop_areas.codigo_area as trabalho_area, es_area_especifica.descricao_area_especifica as trabalho_area_especifica, es_trabalho.datahora_submissao as trabalho_datahora_submissao, responsavel_submissao.nome as trabalho_responsavel_submissao,

fgk_revisor1, nome_inscrito1.nome as nome_revisor1, coalesce(area_especifica_revisor1.descricao_area_especifica,'') as area_especifica_revisor1, revisao1.aval_conclusao as aval_conclusao1, revisao1.aval_metodologia as aval_metodologia1, revisao1.aval_redacao as aval_redacao1, revisao1.aval_resultado as aval_resultado1, revisao1.status as status1, revisao1.justificativa as justiticativa1, revisao1.nota as nota1, revisao1.parecer as parecer1, revisao1.resultado as resultado1,

fgk_revisor2, nome_inscrito2.nome as nome_revisor2, coalesce(area_especifica_revisor2.descricao_area_especifica,'') as area_especifica_revisor2, revisao2.aval_conclusao as aval_conclusao2, revisao2.aval_metodologia as aval_metodologia2, revisao2.aval_redacao as aval_redacao2, revisao2.aval_resultado as aval_resultado2, revisao2.status as status2, revisao2.justificativa as justiticativa2, revisao2.nota as nota2, revisao2.parecer as parecer2, revisao2.resultado as resultado2,
concat(es_orgao_fomento.sigla, ' - ', es_orgao_fomento.nome) as trabalho_orgao_fomento

from es_avaliacao

LEFT JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
LEFT JOIN es_ufop_areas ON  es_ufop_areas.id_area = es_trabalho.fgk_area
LEFT JOIN es_inscritos as responsavel_submissao on es_trabalho.fgk_inscrito_responsavel = responsavel_submissao.id
LEFT JOIN es_orgao_fomento on es_trabalho.fgk_orgao_fomento = es_orgao_fomento.id


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

WHERE es_avaliacao.id = ?";
    $execute_avaliacao = $db->sql_query($sql_avaliacao, array('es_avaliacao.id'=>$id_avaliacao));
    foreach ($execute_avaliacao as $registro) {
        $avaliacao_bool_caint = $registro->avaliacao_bool_caint;
        $avaliacao_status = $registro->status;
        $avaliacao_nota = $registro->nota;
        $avaliacao_parecer = $registro->parecer;
        $avaliacao_parecer_ar = $registro->parecer_ar;
        $avaliacao_resultado = $registro->resultado;
        $avaliacao_status_descricao = $registro->avaliacao_status_descricao;
        $fgk_revisor1 = $registro->fgk_revisor1;
        $nome_revisor1 = $registro->nome_revisor1;
        $aval_conclusao1 = $registro->aval_conclusao1;
        $aval_metodologia1 = $registro->aval_metodologia1;
        $aval_redacao1 = $registro->aval_redacao1;
        $aval_resultado1 = $registro->aval_resultado1;
        $status1 = $registro->status1;
        $justiticativa1 = $registro->justiticativa1;
        $nota1 = $registro->nota1;
        $parecer1 = $registro->parecer1;
        $resultado = $registro->resultado;
        $status_revisao1 = $registro->status_revisao1;
        $status_revisao2 = $registro->status_revisao2;
        $trabalho_resumo_revisado = $registro->trabalho_resumo_revisado;
        $trabalho_palavras_chave_revisado = $registro->trabalho_palavras_chave_revisado;
        $resultado1 = $registro->resultado1;
        $fgk_revisor2 = $registro->fgk_revisor2;
        $nome_revisor2 = $registro->nome_revisor2;
        $aval_conclusao2 = $registro->aval_conclusao2;
        $aval_metodologia2 = $registro->aval_metodologia2;
        $aval_redacao2 = $registro->aval_redacao2;
        $aval_resultado2 = $registro->aval_resultado2;
        $status2 = $registro->status2;
        $justiticativa2 = $registro->justiticativa2;
        $nota2 = $registro->nota2;
        $parecer2 = $registro->parecer2;
        $resultado2 = $registro->resultado2;
        $trabalho_id = $registro->trabalho_id;
        $trabalho_titulo = $registro->trabalho_titulo;
		$trabalho_titulo_revisado = $registro->trabalho_titulo_revisado;
        $trabalho_palavras_chaves = $registro->trabalho_palavras_chaves;
        $trabalho_resumo_enviado = $registro->trabalho_resumo_enviado;
        $trabalho_area_especifica = $registro->trabalho_area_especifica;
        $trabalho_area = $registro->trabalho_area;
        $trabalho_datahora_submissao = $registro->trabalho_datahora_submissao;
        $trabalho_responsavel_submissao = $registro->trabalho_responsavel_submissao;
        $trabalho_orgao_fomento = $registro->trabalho_orgao_fomento;
        $trabalho_status = $registro->trabalho_status;
        $parecer = $registro->parecer;
        $parecer_ar = $registro->parecer_ar;
        $nota = $registro->nota;
        $resultado = $registro->resultado;
        
    }

    function descricao_nota($valor_nota){
        switch($valor_nota){
            case 1:
                $descricao_nota = "Inadequado";
            break;
            case 2:
                $descricao_nota = "Ruim";
            break;
            case 3:
                $descricao_nota = "Regular";
            break;
            case 4:
                $descricao_nota = "Bom";
            break;
            case 5:
                $descricao_nota = "Excelente";
            break;
        }
        return $descricao_nota;
    }
     function descricao_conceito($conceito){
        switch($conceito){
            case 'A':
                $descricao_conceito = "Aprovado";
            break;
            case "AR":
                $descricao_conceito = "Aprovado com Restrições";
            break;
            case 'R':
                $descricao_conceito = "Reprovado";
            break;
        }
        return $descricao_conceito;
    }
?>    
    <style type="text/css">
    .frameResults { border-style: solid; border-width: 1px; height: 400px;}
    </style>
    <script type="text/javascript" src="assets/js/diff.js"></script>
    </head>
    <script type="text/javascript"><!--
        var diff = new ML.Text.Diff();
        var htmlSpecialChars = function(text)
        {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function updateDifference()
        {
            var theform, difference, before, after, afterPatch;

            theform = document.getElementById('theform');
            difference = {
                mode: 'w',
                patch: true
            };
            before = document.getElementById('after').value;
            after = document.getElementById('before').value;
            afterPatch = {};
            if(diff.formatDiffAsHtml(before, after, difference)
            && diff.patch(before, difference.difference, afterPatch)) 
            {
                document.getElementById('difference').innerHTML = difference.html;
                //document.getElementById('patch').innerHTML = (after === afterPatch.after ? 'Não houve alterações no resumo' : 'There is a BUG: The patched text (<b>' + htmlSpecialChars(afterPatch.after) + '</b>) does not match the text after (<b>' + htmlSpecialChars(after) + '</b>).');
            }
        }
// --></script>

<div class="page-inner">
    <div class="page-title">
        <h3>Parecer</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="index.php">Parecer do Trabalho Submetido</a></li>
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
            
           
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Trabalho Submetido</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <br>
                                <label for="area"><strong>Submetido por:</strong></label>
                                <p class="text-justify"><?=$trabalho_responsavel_submissao;?> em <?=date('d/m/Y - H:i:s',strtotime($trabalho_datahora_submissao));?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>Área | Área Específica:</strong></label>
                                <p class="text-justify"><?=$trabalho_area;?> | <?=$trabalho_area_especifica;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="titulo"><strong>Órgão Fomento:</strong></label>
                                <p class="text-justify"><?=$trabalho_orgao_fomento;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">Avaliações</h3>
                    </div>
                    <br>
                
                    <div class="panel-body">
                         <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width:20%">Resultado: </td>
                                    <td style="width:80%"><strong><?= descricao_conceito($resultado);?></strong></td>
                                </tr>
                                <tr>
                                    <td style="width:20%">Parecer Final: </td>
                                    <td style="width:80%"><strong><?=$parecer_ar;?></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="danger">
                                        <th width="20%">Itens da Avaliação</th>
                                        <th width="40%"><?=$nome_revisor1;?></th>
                                        <th width="40%"><?=$nome_revisor2;?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Avaliação Conclusão</td>
                                        <td><?php if($status_revisao1 == 2) echo descricao_nota($aval_conclusao1);?></td>
                                        <td><?php if($status_revisao2 == 2) echo descricao_nota($aval_conclusao2);?></td>
                                    </tr>
                                    <tr>
                                        <td>Avaliação Metodologia</td>
                                        <td><?php if($status_revisao1 == 2) echo descricao_nota($aval_metodologia1);?></td>
                                        <td><?php if($status_revisao2 == 2) echo descricao_nota($aval_metodologia2);?></td>
                                    </tr>
                                    <tr>
                                        <td>Avaliação Resultados</td>
                                        <td><?php if($status_revisao1 == 2) echo descricao_nota($aval_resultado1);?></td>
                                        <td><?php if($status_revisao2 == 2) echo descricao_nota($aval_resultado2);?></td>
                                    </tr>
                                    <tr>
                                        <td>Nota</td>
                                        <td><?php if($status_revisao1 == 2) echo $nota1;?></td>
                                        <td><?php if($status_revisao2 == 2) echo $nota2;?></td>
                                    </tr>
                                    <tr>
                                        <td>Resultado Final</td>
                                        <td><?php if($status_revisao1 == 2) echo descricao_conceito($resultado1);?></td>
                                        <td><?php if($status_revisao2 == 2) echo descricao_conceito($resultado2);?></td>
                                    </tr>
                                    <tr>
                                        <td>Justificativa</td>
                                        <td><?php if($status_revisao1 == 2) echo $justiticativa1;?></td>
                                        <td><?php if($status_revisao2 == 2) echo $justiticativa2;?></td>
                                    </tr>
                                    <tr>
                                        <td>Parecer ao Coordenador</td>
                                        <td><?php if($status_revisao1 == 2) echo $parecer1;?></td>
                                        <td><?php if($status_revisao2 == 2) echo $parecer2;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading">
                        <h3 class="panel-title">Título</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <p> 1ª Versão: <?=$trabalho_titulo;?></p><br/>
						<p> Revisado: <?=$trabalho_titulo_revisado; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading">
                        <h3 class="panel-title">Autores</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <?php
                        $sql_autores = "SELECT nome FROM es_trabalho_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
                        $execute_autores = $db->sql_query($sql_autores, array("fgk_trabalho"=>$trabalho_id));
                        $i = 1;
                        foreach($execute_autores as $autor){
                            echo $i.". ".$autor->nome."<br>";
                            $i++;
                        }
                        ?>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading">
                        <h3 class="panel-title">Palavras-chave</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <p>1ª Versão: <strong><?=$trabalho_palavras_chaves;?></strong></p>
                        <br>
                        <p>Revisado: <strong><?=$trabalho_palavras_chave_revisado;?></strong></p>
                    </div>
                </div>
            </div>
               
            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading">
                        <h3 class="panel-title">Resumo</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#revisado">Revisado</a></li>
                            <li><a data-toggle="tab" href="#1versao">1ª Versão</a></li>
                            <li><a data-toggle="tab" href="#diferencas">Diferenças</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="revisado" class="tab-pane fade in active">
                                <textarea id="before" cols="135" rows="20" onchange="updateDifference();" onkeyup="updateDifference();"><?=$trabalho_resumo_revisado;?></textarea>
                            </div>
                            <div id="1versao" class="tab-pane fade">
                                <textarea id="after" cols="135" rows="20" onchange="updateDifference();" onkeyup="updateDifference();"><?=$trabalho_resumo_enviado;?></textarea>
                            </div>
                            <div id="diferencas" class="tab-pane fade">
                                <div id="difference" class="frameResults">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($trabalho_status == 7 || $trabalho_status == 13 ){ ?>
            
            <div class="col-md-12">
                <div class="panel panel-danger"> 
                    <div class="panel-heading">
                        <h3 class="panel-title">Parecer Final: (Apenas as informações abaixo serão vistas pelos autores dos trabalhos)</h3>
                    </div>
                    <form class="form-horizontal" id="form_avaliacao" name="form_avaliacao" action="javascript:void(0);">
                        <div class="panel-body"> 
                            
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-1" for="nota">Nota:</label>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" id="nota" name="nota" min=0 max=10 value="<?=(!isset($nota_final) ? '' : $nota_final);?>" required >
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="col-sm-1"></div>
        
                                        <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Resultado</label>
                                            <div class="col-sm-8">
                                                <label class="radio-inline"><input type="radio" name="resultado_final" value="A" <?php if ($resultado == 'AR_A' || $resultado == 'A') echo "checked"; ?>>Aprovado</label>
                                                <label class="radio-inline"><input type="radio" name="resultado_final" value="R"<?php if ($resultado == 'R' || $resultado == 'AR_R') echo "checked"; ?>>Reprovado</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-1" for="nota">Parecer:</label>
                                        <div class="col-sm-11">
                                            <textarea class="form-control" rows="20"  id="parecer"><?=(!isset($parecer_final) ? '' : $parecer_final);?></textarea>  
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-success" id="enviar"<?=(!isset($disabled) ? '' : $disabled);?>>Submeter Parecer</button>
                                <a href="parecer_final.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
        
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <?php } ?>
               

<?php
    include "footer.php";
?>
    <script type="text/javascript">
    $(document).ready(function () {
        updateDifference();
       
        
        $("#enviar").click(function() {    
        if($("#nota").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe uma nota para o trabalho.',
                buttons: [{
                    id: 'btn-ok',   
                    icon: 'glyphicon glyphicon-check',       
                    label: 'OK',
                    cssClass: 'btn-primary', 
                    autospin: false,
                    action: function(dialogRef){    
                        dialogRef.close();
                    }
                }]
            });
            return;
        }
        if(!$("#form_avaliacao input[type='radio']:checked").val()){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o resultado final sobre o trabalho.',
                buttons: [{
                    id: 'btn-ok',   
                    icon: 'glyphicon glyphicon-check',       
                    label: 'OK',
                    cssClass: 'btn-primary', 
                    autospin: false,
                    action: function(dialogRef){    
                        dialogRef.close();
                    }
                }]
            });
            return;
        }

        $("#processando").modal("show");
        $("#form_avaliacao").submit(function() {
            var nota = $("#nota").val();
            var resultado_final = $("#form_avaliacao input[type='radio']:checked").val();
            var parecer = $("#parecer").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_parecer_final.php', {id_avaliacao: <?=$id_avaliacao;?>, nota: nota, resultado_final: resultado_final, parecer: parecer }, 
                function(resposta) {
                    if (resposta === "sucesso") {                           
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Parecer final submetido com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="parecer_final.php";
                                }
                            }]
                        });
                    } else {                            
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: resposta,
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                }
                            }]
                        });
                        return false;
                    }
                }
            );
        });
    });

    });
</script>
</body>
</html>