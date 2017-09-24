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
<link rel="stylesheet" href="assets/css/dataTables.tableTools.css"/>
<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.base.css" type="text/css">
<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.classic.css" type="text/css">



<style>

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
                            <li><a href="index.php">Designar Avaliadores</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">  
                                <div class="panel-body">
                                    <h3>Pesquisar</h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="programa_ic">Trabalhos</label>
                                         <select class='form-control' id='alocados' name='alocados' required>
                                            <option></option>
                                            <option value="nao">Não Alocados</option>
                                            
                                            <option value="sim">Alocados</option>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                       
                                    <div class="form-group">
                                        <label for="programa_ic">Órgão fomento</label>
                                         <select class='form-control' id='programa_ic' name='programa_ic' required>
                                            <option></option>
                                            <?php 
                                            $stmt = $db->sql_query('SELECT * FROM es_orgao_fomento');
                                            foreach ($stmt as $registro) {
                                                echo '<option value="'.$registro->sigla.'"  >'.$registro->sigla.' </option>';
                                            }?>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="area_especifica">Área Específica</label>
                                         <select class='form-control' id='area_especifica' name='area_especifica'>
                                        <option></option>
                                        <?php 
                                        if(TIPO_USUARIO  == ADMINISTRADOR){
                                            $stmt = $db->sql_query('SELECT * FROM es_area_especifica');
                                        } else {
                                            $stmt = $db->sql_query('SELECT * FROM es_area_especifica WHERE fgk_area = ?',  array('fgk_area' => AREA_COORDENACAO ));
                                        }
                                        foreach ($stmt as $registro) {
                                            echo '<option value="'.$registro->descricao_area_especifica.'"  >'.$registro->descricao_area_especifica.' </option>';
                                        }?>
                                    </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="programa_ic">Instituição</label>
                                         <select class='form-control' id='instituicao' name='instituicao'>
                                            <option></option>
                                            <?php 
                                            $stmt = $db->sql_query('SELECT * FROM es_instituicao');
                                            foreach ($stmt as $registro) {
                                                echo '<option value="'.$registro->sigla.'"  >'.$registro->sigla.' </option>';
                                            }?>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="area_especifica">Título</label>
                                        <input type="text" id="titulo" class="form-control"/>
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="departamento">Departamento</label>
                                         <select class='form-control' id='departamento' name='departamento'>
                                            <option></option>
                                            <?php 
                                             if(TIPO_USUARIO  == ADMINISTRADOR){
                                            $stmt = $db->sql_query('SELECT * FROM es_ufop_departamentos');
                                        } else {
                                            $stmt = $db->sql_query('SELECT * FROM es_ufop_departamentos WHERE fgk_area = ?',  array('fgk_area' => AREA_COORDENACAO ));
                                        }
                                            foreach ($stmt as $registro) {
                                                echo '<option value="'.$registro->id_departamento.'"  >'.$registro->id_departamento.' - '.$registro->nome_departamento.' </option>';
                                            }?>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-white">  
                            <div class="panel-body input-group">
                                <h3>Selecionar Avaliadores</h3>
                                <div class="col-md-5">     
                                    <div class="form-group" id="fgk_revisor1">

                                        
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" id="fgk_revisor2">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger" id="alocar_avaliadores" style="margin-top: 20px;">Alocar Avaliadores</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body text-center">
                                    <div class="table-responsive">
                                        <form id="frm-example" action="/nosuchpage" method="POST">
                                        <table id="resumo" class="table table-striped table-bordered display select" style="width:99%">
                                            <?php
                                                if(TIPO_USUARIO  == 5){


                                                     $stmt = $db->sql_query("SELECT es_trabalho.id as id_trabalho, es_trabalho.titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, es_projeto.fgk_departamento as id_departamento,
                                                                        es_trabalho_status.descricao_status, es_area_especifica.descricao_area_especifica, '0' as is_caint, '' as autor_caint,
                                                                        inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                        inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                        FROM es_trabalho

                                                                        INNER JOIN es_trabalho_status ON es_trabalho.fgk_status = es_trabalho_status.id_status
                                                                        LEFT JOIN es_orgao_fomento on es_trabalho.fgk_orgao_fomento = es_orgao_fomento.id

                                                                        LEFT JOIN es_projeto ON es_trabalho.fgk_projeto = es_projeto.id

                                                                        LEFT JOIN es_avaliacao ON es_trabalho.id = es_avaliacao.fgk_trabalho
                                                                        LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                        LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                        LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                        LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                        LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                        LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                        LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo

                                                                        WHERE es_trabalho.fgk_evento =? AND (es_trabalho.fgk_status = ? OR es_trabalho.fgk_status = 3) GROUP BY es_trabalho.id

                                                                        UNION

                                                                        SELECT es_trabalho_caint.id as id_trabalho, CONCAT(IF(es_trabalho_caint.tipo_mobilidade=1,'CIÊNCIAS SEM FRONTEIRA - ','MOBILIDADE CAINT - '),es_trabalho_caint.pais_destino) as titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, '' as id_departamento, es_trabalho_status.descricao_status, 
                                                                        'CAINT' as descricao_area_especifica, '1' as is_caint, es_trabalho_caint.nome_aluno as autor_caint, 
                                                                        inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                        inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                        FROM es_trabalho_caint

                                                                        INNER JOIN es_trabalho_status ON es_trabalho_caint.fgk_status = es_trabalho_status.id_status
                                                                        LEFT JOIN es_orgao_fomento on es_trabalho_caint.fgk_orgao_fomento = es_orgao_fomento.id


                                                                        LEFT JOIN es_avaliacao ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho

                                                                        LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                        LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                        LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                        LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                        LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                        LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo
                                                                        WHERE es_trabalho_caint.fgk_evento =? AND (es_trabalho_caint.fgk_status = ? OR es_trabalho_caint.fgk_status = 3) GROUP BY es_trabalho_caint.id
                                                                        ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho.fgk_status'=>2, 'es_trabalho_caint.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho_caint.fgk_status'=>2));
                                                }
                                                else {
                                                    if(AREA_COORDENACAO<=5 ||AREA_COORDENACAO == 8 ){
                                                        $stmt = $db->sql_query("SELECT es_trabalho.id as id_trabalho, es_trabalho.titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, es_projeto.fgk_departamento as id_departamento,
                                                                                es_trabalho_status.descricao_status, es_area_especifica.descricao_area_especifica, '0' as is_caint, '' as autor_caint,
                                                                                inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                                inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                                FROM es_trabalho

                                                                                INNER JOIN es_trabalho_status ON es_trabalho.fgk_status = es_trabalho_status.id_status
                                                                                LEFT JOIN es_orgao_fomento on es_trabalho.fgk_orgao_fomento = es_orgao_fomento.id

                                                                                LEFT JOIN es_projeto ON es_trabalho.fgk_projeto = es_projeto.id

                                                                                LEFT JOIN es_avaliacao ON es_trabalho.id = es_avaliacao.fgk_trabalho and es_avaliacao.bool_caint = 0

                                                                                LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                                LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                                LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo

                                                                                WHERE es_trabalho.fgk_evento =? AND (es_trabalho.fgk_status = ? OR es_trabalho.fgk_status = 3 ) AND es_trabalho.fgk_area =? AND es_trabalho.fgk_categoria = 1

                                                                                UNION

                                                                                SELECT es_trabalho_caint.id as id_trabalho, CONCAT(IF(es_trabalho_caint.tipo_mobilidade=1,'CIÊNCIAS SEM FRONTEIRA - ','MOBILIDADE CAINT - '),
                                                                                    es_trabalho_caint.pais_destino) as titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, '' as id_departamento, es_trabalho_status.descricao_status,
                                                                                    'CAINT' as descricao_area_especifica, '1' as is_caint, es_trabalho_caint.nome_aluno as autor_caint,
                                                                                    inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                                    inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                                    FROM es_trabalho_caint

                                                                                    INNER JOIN es_trabalho_status ON es_trabalho_caint.fgk_status = es_trabalho_status.id_status
                                                                                    LEFT JOIN es_orgao_fomento on es_trabalho_caint.fgk_orgao_fomento = es_orgao_fomento.id


                                                                                    LEFT JOIN es_avaliacao ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho and es_avaliacao.bool_caint = 1

                                                                                    LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                                    LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                                    LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                                    LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                                    LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                                    LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo
                                                                                WHERE es_trabalho_caint.fgk_evento =? AND es_trabalho_caint.fgk_area = ? AND (es_trabalho_caint.fgk_status = ? OR es_trabalho_caint.fgk_status = 3) 
                                                                           ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho.fgk_status'=>2 ,'es_trabalho.fgk_area'=>AREA_COORDENACAO, 'es_trabalho_caint.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho_caint.fgk_area'=>AREA_COORDENACAO, 'es_trabalho_caint.fgk_status'=>2));
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

                                                        $stmt = $db->sql_query("SELECT es_trabalho.id as id_trabalho, es_trabalho.titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, es_projeto.fgk_departamento as id_departamento,
                                                                                es_trabalho_status.descricao_status, es_area_especifica.descricao_area_especifica, '0' as is_caint, '' as autor_caint,
                                                                                inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                                inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                                FROM es_trabalho

                                                                                INNER JOIN es_trabalho_status ON es_trabalho.fgk_status = es_trabalho_status.id_status
                                                                                LEFT JOIN es_orgao_fomento on es_trabalho.fgk_orgao_fomento = es_orgao_fomento.id

                                                                                LEFT JOIN es_projeto ON es_trabalho.fgk_projeto = es_projeto.id

                                                                                LEFT JOIN es_avaliacao ON es_trabalho.id = es_avaliacao.fgk_trabalho
                                                                                LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                                LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                                LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo

                                                                                WHERE es_trabalho.fgk_evento =? AND (es_trabalho.fgk_status = ? OR es_trabalho.fgk_status = 3 ) AND (es_trabalho.fgk_categoria =? $where )

                                                                                UNION

                                                                                SELECT es_trabalho_caint.id as id_trabalho, CONCAT(IF(es_trabalho_caint.tipo_mobilidade=1,'CIÊNCIAS SEM FRONTEIRA - ','MOBILIDADE CAINT - '),es_trabalho_caint.pais_destino) as titulo_enviado, es_orgao_fomento.sigla as orgao_fomento, '' as id_departamento, es_trabalho_status.descricao_status, 
                                                                                'CAINT' as descricao_area_especifica, '1' as is_caint, es_trabalho_caint.nome_aluno as autor_caint, 
                                                                                inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1,
                                                                                inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2

                                                                                FROM es_trabalho_caint

                                                                                INNER JOIN es_trabalho_status ON es_trabalho_caint.fgk_status = es_trabalho_status.id_status
                                                                                LEFT JOIN es_orgao_fomento on es_trabalho_caint.fgk_orgao_fomento = es_orgao_fomento.id


                                                                                LEFT JOIN es_avaliacao ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                                                LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo

                                                                                LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                                                LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                                                LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo
                                                                                WHERE es_trabalho_caint.fgk_evento =? AND es_trabalho_caint.fgk_area = ? AND (es_trabalho_caint.fgk_status = ? OR es_trabalho_caint.fgk_status = 3)
                                                                           ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho.fgk_status'=>2 ,'es_trabalho.fgk_categoria'=>$id_categoria, 'es_trabalho_caint.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho_caint.fgk_area'=>AREA_COORDENACAO, 'es_trabalho_caint.fgk_status'=>2));
                                                    }
                                                }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th><input name="select_all" value="1" type="checkbox"></th>
                                                    <th>Área</th>
                                                    <th>Título</th>
                                                    <th>Instituição</th> 
                                                    <th>Autores</th>
                                                    <th>Alocado</th>
                                                    <th></th>                                              
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=0;
                                                    foreach ($stmt as $resumo) {
                                                        $alocamento = $db->existe('es_avaliacao', array('fgk_trabalho'=> $resumo->id_trabalho, 'bool_caint'=>$resumo->is_caint ) );
                                                        if($alocamento)
                                                            $disable = "disabled";
                                                        else
                                                            $disable = "";
                                                        
                                                        echo '
                                                        <tr>
                                                            <td><input type="checkbox" name="id_trabalho" id="id_trabalho'.$i.'" value="'.$resumo->id_trabalho.'" '.$disable.' /></td>
                                                            <td id="area">'.$resumo->descricao_area_especifica.'</td>';
                                                            if($alocamento)
                                                                echo '
                                                            <td align="left"><a href="editar_avaliador.php?id='.$resumo->id_trabalho.'&bool_caint='.$resumo->is_caint.'&atualizar=1">'.$resumo->titulo_enviado.'</a>                                                          
                                                            <br>Revisores: '.$resumo->nome_revisor1.', '.$resumo->nome_revisor2.'</td>';
                                                            else
                                                            
                                                                echo '<td align="left"><a href="editar_avaliador.php?id='.$resumo->id_trabalho.'&bool_caint='.$resumo->is_caint.'&atualizar=0">'.$resumo->titulo_enviado.'</a></td>';

                                                            $id_trabalho = $resumo->id_trabalho;
                                                            if($resumo->is_caint == 0){
                                                                $dados_instituicao = $db->sql_query('SELECT sigla FROM es_trabalho_autor 
                                                                                                    LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho_autor.fgk_instituicao  
                                                                                                    WHERE fgk_trabalho = ?
                                                                                                    GROUP by fgk_trabalho', array('fgk_trabalho' => $id_trabalho));
                                                                foreach ($dados_instituicao as $registro) {
                                                                    echo '<td>'.$registro->sigla.'</td>';
                                                                }
                                                                } else {
                                                                echo '<td>UFOP</td>';
                                                            }
                                                                echo '<td>';

                                                            
                                                            if($resumo->is_caint == 0){
                                                                $query = $db->sql_query("SELECT nome,descricao_tipo, sigla, bool_apresentador FROM es_trabalho_autor 
                                                                                        INNER JOIN es_tipo_autor ON fgk_tipo_autor = id_tipo_autor 
                                                                                        WHERE fgk_trabalho = ? ORDER BY ordenacao ASC", array('fgk_trabalho'=>$resumo->id_trabalho));
                                                                foreach ($query as $autor) {
                                                                    if($autor->bool_apresentador == 1)
                                                                        echo $autor->nome.'* ('.$autor->sigla.')<br>';
                                                                    else
                                                                        echo $autor->nome.' ('.$autor->sigla.')<br>';
                                                                }
                                                            } else {
                                                                echo $resumo->autor_caint;
                                                            }

                                                            
                                                            if(!$alocamento)
                                                                echo '</td>
                                                                <td><img src="assets/images/icons/no.png" /></td><td><span style="display:none">nao</span></td>
                                                                ';
                                                            else
                                                                echo '</td>
                                                                <td><img src="assets/images/icons/ok.png" /></td><td><span style="display:none">sim</td></td>
                                                                
                                                                ';
                                                            echo '<td>'.$resumo->is_caint.'</td><td>'.$resumo->id_departamento.'</td>
                                                            <td>'.$resumo->orgao_fomento.'</td></tr>';

                                                            
                                                            $i++;
                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                       
                                    </form>
                                    </div>
                                </div>                            
                                </div>
                                    
                            </div>

                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->

<?php
    include "footer.php";
?>
    </body>
    <!--script src="assets/js/dataTables.tableTools.js"></script-->
    <script>
    $(function () {
      $('[data-toggle="popover"]').popover()
    })

    var rows_selected = [];
    var table = $('#resumo').DataTable({
        dom: 'T<"top"i>rt<"clear">lp',
        "columns": [
            { "width": "1%" },
            { "width": "5%" },
            { "width": "40%" },
            { "width": "10%" },
            { "width": "40%" },
            { "width": "4%" },
            null,
            null,
            null,
			null
        ],
        "language": {
                    "emptyTable":     "Nenhum trabalho submetido para avaliação"
        },
        columnDefs: [
            
            {
                "targets": [ 5 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "visible": false
            },
            {
                "targets": [ 7 ],
                "visible": false
            },
             {
                "targets": [ 8 ],
                "visible": false
            }
        ],
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

    $('#alocados').on( 'change', function () {
        table.column(6).search( this.value ).draw();
    } );
    $('#area_especifica').on( 'change', function () {
        table.column(1).search( this.value ).draw();
    } );
    $('#programa_ic').on( 'change', function () {
        table.column(9).search( this.value ).draw();
    } );
    $('#titulo').on( 'keyup', function () {
        table.column(2).search( this.value ).draw();
    } );
    $('#instituicao').on( 'change', function () {
        table.column(4).search( this.value ).draw();
    } );
    $('#departamento').on( 'change', function () {
        table.column(8).search( this.value ).draw();
    } );
	$("#alocados").val("nao");
        table.column(6).search( "nao" ).draw();

    $('#alocar_avaliadores').on( 'click', function () {
       // var selectedRec="";
        $("input[name='id_trabalho']:checked").each(function(){
            var $row = $(this).closest('tr');

          // Get row data
          var data = table.row($row).data();

          // Get row ID
          var bool_caint = data[7];

             $.post('alocar_revisor.php', {
                    fgk_revisor1:$('#fgk_revisor1').val(), fgk_revisor2:$('#fgk_revisor2').val(), fgk_trabalho:$(this).val(), bool_caint: bool_caint, status:0}, 
                    function(resposta) {
                        if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");

                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                closable: false,
                                title: 'Obrigado',
                                message: '<p>Revisor do  trabalho alocado com sucesso.</p>',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="designar_avaliadores.php";
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
                                message: resposta,
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
          //alert('avaliador_1: '+$('#avaliador_1').val()+' avaliador_2: '+$('#avaliador_2').val()+' id_trabalho:  '+$(this).val() )
        });
        //alert(selectedRec);
       
    });

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
    </script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        
        $('#area_especifica').on( 'change', function () {
             var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'nome' },
                    { name: 'departamento' },
                    { name: 'id_revisor' },
                    { name: 'descricao_area_especifica' },
                    { name: 'total'}
                ],
                url: 'data.php?area_especifica='+this.value+'&id_tipo_inscrito='+<?=TIPO_USUARIO ;?>
            };
           var dataAdapter = new $.jqx.dataAdapter(source);
            $("#fgk_revisor1").jqxComboBox(
                {
                    source: dataAdapter,
                    theme: 'classic',
                    width: 400,
                    height: 50,
                    itemHeight: 70,
                    selectedIndex: 0,
                    displayMember: 'nome',
                    valueMember: 'id_revisor',
                    renderer: function (index, label, value) {
                            var datarecord = dataAdapter.records[index];
                            var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                            var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                            var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>  ' + datarecord.nome + '</td></tr><tr><td>' + datarecord.descricao_area_especifica +'</td></tr></table>';
                            return table;
                        }
                });
             $("#fgk_revisor2").jqxComboBox(
                {
                    source: dataAdapter,
                    theme: 'classic',
                    width: 400,
                    height: 50,
                    itemHeight: 70,
                    selectedIndex: 0,
                    displayMember: 'nome',
                    valueMember: 'id_revisor',
                    renderer: function (index, label, value) {
                            var datarecord = dataAdapter.records[index];
                            var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                            var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                            var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td style="font-size:10">' + datarecord.descricao_area_especifica +'</td></tr></table>';
                            return table;
                        }
                });
        } );

        $('#departamento').on( 'change', function () {
             var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'nome' },
                    { name: 'departamento' },
                    { name: 'id_revisor' },
                    { name: 'descricao_area_especifica' },
                    { name: 'total'}
                ],
                url: 'data.php?id_departamento='+this.value+'&id_tipo_inscrito='+<?=TIPO_USUARIO ;?>
            };
           var dataAdapter = new $.jqx.dataAdapter(source);
            $("#fgk_revisor1").jqxComboBox(
                {
                    source: dataAdapter,
                    theme: 'classic',
                    width: 400,
                    height: 50,
                    itemHeight: 70,
                    selectedIndex: 0,
                    displayMember: 'nome',
                    valueMember: 'id_revisor',
                    renderer: function (index, label, value) {
                            var datarecord = dataAdapter.records[index];
                            var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                            var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                            var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>  ' + datarecord.nome + '</td></tr><tr><td>' + datarecord.descricao_area_especifica +'</td></tr></table>';
                            return table;
                        }
                });
             $("#fgk_revisor2").jqxComboBox(
                {
                    source: dataAdapter,
                    theme: 'classic',
                    width: 400,
                    height: 50,
                    itemHeight: 70,
                    selectedIndex: 0,
                    displayMember: 'nome',
                    valueMember: 'id_revisor',
                    renderer: function (index, label, value) {
                            var datarecord = dataAdapter.records[index];
                            var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                            var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                            var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td style="font-size:10">' + datarecord.descricao_area_especifica +'</td></tr></table>';
                            return table;
                        }
                });
        } );

        var source =
        {
            datatype: "json",
            datafields: [
                { name: 'nome' },
                { name: 'departamento' },
                { name: 'id_revisor' },
                { name: 'descricao_area_especifica' },
                { name: 'total'}
            ],
            url: 'data.php?id_tipo_inscrito='+<?=TIPO_USUARIO ;?>
        };


        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#fgk_revisor1").jqxComboBox(
        {
            source: dataAdapter,
            theme: 'classic',
            width: 400,
            height: 50,
            itemHeight: 70,
            selectedIndex: 0,
            displayMember: 'nome',
            valueMember: 'id_revisor',
            renderer: function (index, label, value) {
                    var datarecord = dataAdapter.records[index];
                    var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                    var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                    var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>  ' + datarecord.nome + '</td></tr><tr><td>' + datarecord.descricao_area_especifica +'</td></tr></table>';
                    return table;
                }
        });
        $("#fgk_revisor2").jqxComboBox(
        {
            source: dataAdapter,
            theme: 'classic',
            width: 400,
            height: 50,
            itemHeight: 70,
            selectedIndex: 0,
            displayMember: 'nome',
            valueMember: 'id_revisor',
            renderer: function (index, label, value) {
                    var datarecord = dataAdapter.records[index];
                    var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                    var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                    var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td style="font-size:10">' + datarecord.descricao_area_especifica +'</td></tr></table>';
                    return table;
                }
        });
    });
</script>

</html>
<?php } ?>
