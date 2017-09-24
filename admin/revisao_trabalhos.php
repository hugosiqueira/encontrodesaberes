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
                            <li><a href="index.php">Revisão de Trabalhos</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body text-center">
								
                                    <?php 
									$verifica_revisor = $db->sql_query("SELECT id FROM es_avaliacao_revisor WHERE fgk_inscrito = ?", array("fgk_inscrito"=>ID_USUARIO));
									foreach ($verifica_revisor as $value) {
										$id_revisor = $value->id;
									}
									if(!isset($id_revisor)){
										echo "Você não possui trabalhos para revisar.";
										exit();
									}
									if(DATA_AVALIACAO_INI <= date('Y-m-d H:i:s') && DATA_AVALIACAO_FIM >= date('Y-m-d H:i:s') ) { ?>
                                    <div class="table-responsive">
                                        <table id="resumos" class="table table-striped table-bordered display select" style="width:99%">
                                            <?php
                                                if(TIPO_USUARIO == ADMINISTRADOR){
                                                     $stmt = $db->sql_query("SELECT es_avaliacao_revisao.status as status_revisao, es_avaliacao.id as id_avaliacao, es_trabalho.id as id_trabalho,  fgk_revisor1,fgk_revisor2,
                                                        es_trabalho.titulo_enviado, es_area_especifica.descricao_area_especifica , inscrito1.nome as nome_revisor1, 
                                                        inscrito2.nome as nome_revisor2, es_avaliacao.status as status_avaliado, es_avaliacao.bool_caint
                                                            FROM es_avaliacao
                                                            LEFT JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho
                                                            LEFT JOIN es_avaliacao_revisao ON es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id
                                                            LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                                                            LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                            LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                            LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                            LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                            WHERE es_avaliacao.bool_caint =0 AND es_trabalho.fgk_evento = ?
                                                            GROUP BY id_trabalho
                                                            UNION
                                                            SELECT es_avaliacao_revisao.status as status_revisao, es_avaliacao.id as id_avaliacao, es_trabalho_caint.id as id_trabalho,fgk_revisor1,fgk_revisor2, 
                                                            CONCAT(IF(es_trabalho_caint.tipo_mobilidade=1,'CIÊNCIAS SEM FRONTEIRA - ','MOBILIDADE CAINT - '),
                                                            es_trabalho_caint.pais_destino) as titulo_enviado, 'CAINT' as descricao_area_especifica , inscrito1.nome as nome_revisor1,
                                                             inscrito2.nome as nome_revisor2 , es_avaliacao.status as status_avaliado, es_avaliacao.bool_caint
                                                            FROM es_avaliacao
                                                            INNER JOIN es_trabalho_caint ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho
                                                            LEFT JOIN es_avaliacao_revisao ON es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id
                                                            LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                                            LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                                            LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                                            LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                                            WHERE es_avaliacao.bool_caint =1 AND es_trabalho_caint.fgk_evento = ?
                                                            GROUP by id_trabalho", array("es_trabalho.fgk_evento"=>EVENTO_ATUAL, "es_trabalho_caint.fgk_evento"=>EVENTO_ATUAL));
                                                
                                                
                                               } else {

                                                        $stmt = $db->sql_query("Select es_avaliacao.id as id_avaliacao, fgk_trabalho as id_trabalho, es_trabalho.titulo_enviado, es_area_especifica.descricao_area_especifica,
                                                                                 COALESCE(es_avaliacao_revisao.status,0) as status_revisao, es_avaliacao.bool_caint

                                                                                from es_avaliacao
                                                                                INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho and es_avaliacao.bool_caint = 0
                                                                                LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                                                                                LEFT JOIN es_avaliacao_revisao ON es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id and es_avaliacao_revisao.fgk_revisor = ".$id_revisor."

                                                                                WHERE es_avaliacao.bool_caint = 0 AND ( fgk_revisor1 = ".$id_revisor." OR fgk_revisor2= ".$id_revisor." ) 

                                                                                UNION

                                                                                Select es_avaliacao.id as id_avaliacao, fgk_trabalho as id_trabalho, 
                                                                                CONCAT(IF(es_trabalho_caint.tipo_mobilidade=1,'CIÊNCIAS SEM FRONTEIRA - ','MOBILIDADE CAINT - '),es_trabalho_caint.pais_destino) as titulo_enviado, 'CAINT' as descricao_area_especifica,
                                                                                COALESCE(es_avaliacao_revisao.status,0) as status_revisao, es_avaliacao.bool_caint

                                                                                from es_avaliacao
                                                                                LEFT JOIN es_trabalho_caint ON es_trabalho_caint.id = es_avaliacao.fgk_trabalho and es_avaliacao.bool_caint = 1
                                                                                LEFT JOIN es_avaliacao_revisao ON es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id and es_avaliacao_revisao.fgk_revisor = ".$id_revisor."

                                                                                WHERE es_avaliacao.bool_caint = 1 AND ( fgk_revisor1 = ".$id_revisor." OR fgk_revisor2= ".$id_revisor." )"
                                                            );
                                                    
                                                }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th>Área</th>
                                                    <th>Título</th>
                                                    <th>Situação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $resumo) { 
                                                        if($resumo->status_revisao == 0)
                                                            $imagem_avaliado = "<img class = 'img-responsive' src='assets/images/icons/icon_aguarde.png' data-toggle='tooltip' title='Não avaliado!' alt='Não avaliado' >";

                                                        else if($resumo->status_revisao == 1)
                                                            $imagem_avaliado = "<img class = 'img-responsive' src='assets/images/icons/icon_aguarde.png' data-toggle='tooltip' title='Avaliação em edição' alt='Avaliado por um revisor' >";

                                                        else if($resumo->status_revisao == 2)
                                                            $imagem_avaliado = "<img class = 'img-responsive' src='assets/images/icons/icon_ok.png' data-toggle='tooltip' title='Avaliação submetida' alt='Avaliado pelos dois revisores' >";

                                                                                                     
                                                        echo '
                                                        <tr>
                                                            
                                                            <td id="area">'.$resumo->descricao_area_especifica.'</td>
                                                            <td align="left"><a href="revisar_trabalho.php?id='.$resumo->id_avaliacao.'&bool_caint='.$resumo->bool_caint.'">'.$resumo->titulo_enviado.'</a></td>
                                                            <td>'.$imagem_avaliado.'</td>
                                                        </tr>';
                                                            

                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                       
                                    </form>
                                    </div>
                                    <?php } else { echo "Não estamos no período de avaliações.<br> Início: ".date('d/m/Y - H:i:s',strtotime(DATA_AVALIACAO_INI))."<br>Fim: ".date('d/m/Y - H:i:s',strtotime(DATA_AVALIACAO_FIM));}?>
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
    <script>
    $( document ).ready(function() {
        $('#resumos').DataTable({
            dom: 'T<"top"i>frt<"clear">lp',
            "columns": [

                { "width": "15%" },
                { "width": "80%" },
                { "width": "5%" }

            ],
            "language": {
                        "emptyTable":     "Até este momento você não possui trabalhos para revisar."
            }
           
        });
   });
   
    </script>
  
   

</html>
<?php } ?>
