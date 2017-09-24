<?php 
include "../config.php";
$id_trabalho = filter_input(INPUT_GET, 'id'); 
$sql_projeto = "SELECT  es_area_especifica.id as id_area_especifica, es_area_especifica.descricao_area_especifica, 
                            es_ufop_areas.id_area, es_ufop_areas.descricao_area,
                            es_orgao_fomento.nome as nome_orgao_fomento, es_orgao_fomento.sigla as sigla_orgao_fomento,
                            es_sessao.nome as nome_sessao,
                            IF( es_programa_ic.nome IS NULL , 'Não possui', es_programa_ic.nome ) AS nome_ic,
                            IF( palavras_chave_revisado IS NULL , palavras_chave, palavras_chave_revisado ) AS palavras_chave,
                            IF( titulo_revisado IS NULL , titulo_enviado, titulo_revisado ) AS titulo,
                            IF( resumo_revisado IS NULL , resumo_enviado, resumo_revisado ) AS resumo
                    FROM es_trabalho
                    LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                    LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
                    LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
                    LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
                    LEFT JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
                    LEFT JOIN es_projeto ON es_trabalho.fgk_projeto = es_projeto.id
                    LEFT JOIN es_programa_ic ON es_programa_ic.id = es_projeto.fgk_programa_ic
                    LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_trabalho = es_trabalho.id
                    LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
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
        $titulo = $projeto->titulo;
        $palavras_chave = $projeto->palavras_chave;
        $resumo = $projeto->resumo;
        $fgk_status = $projeto->fgk_status;
        $nome_ic = $projeto->nome_ic; 
        $nome_sessao = $projeto->nome_sessao;    
    }

?>
<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
    <div class="container">
        <div class="header">
            <h2 class="page-title">
                <span>Detalhes do Trabalho</span> 
            </h2>
        </div>
    </div>
</div>

<div id="content">
    <div class="container" style="overflow: hidden;">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detalhes</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="apresentador"><strong>Área/Área Específica</strong></label>
                                    <p><?=$descricao_area.' | '.$descricao_area_especifica;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="apresentador"><strong>Programa IC</strong></label>
                                    <p><?=$nome_ic;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="apresentador"><strong>Órgão de Fomento</strong></label>
                                    <p><?=$nome_orgao_fomento;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="apresentador"><strong>Sessão</strong></label>
                                    <p><?=$nome_sessao;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-danger">
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
                <div class="panel panel-danger">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Título</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <p><?=$titulo;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Palavras-chave</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <p class="text-justify"><?=$palavras_chave;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Resumo</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <p class="text-justify"><?=$resumo;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
        </div>
        <?php include ("bibliotecas.php"); ?>
        <?php include ("footer.php"); ?>
