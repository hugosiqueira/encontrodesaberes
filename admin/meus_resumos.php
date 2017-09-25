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
                            <div class="modal fade" id="inexistente" tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Ops!</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="assets/images/triste.png" class="img-responsive" style="margin: 0 auto;">
                                            <p>Desculpe! Não existem trabalhos relacionados em nossa base de dados onde você conste como autor, orientador ou colaborador.</p>
                                            <p>Caso exista equívoco nesta informação, favor encaminhar um email para a equipe de organização do evento (encontrodesaberes@ufop.br) informando sobre este problema.</p>
                                            <p>Att.,</p>
                                            <p>Organizadores do Encontro de Saberes</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="page-inner">
                            <div class="page-title">
                                <h3>Encontro de Saberes</h3>
                                <div class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li><a href="meus_resumos.php">Meus Trabalhos</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="panel panel-white">
                                
                                <div class="panel-body">
							
                                    <div class="table-responsive">
                                        <table id="resumo" class="table table-striped table-bordered display" style="width:100%">
                                            <?php
                                                if(TIPO_USUARIO == ADMINISTRADOR){
                                                     $stmt = $db->sql_query("SELECT  es_trabalho.*, es_trabalho.id as id_trabalho, es_trabalho.apresentacao_obrigatoria, es_instituicao.sigla as sigla_instituicao, es_categorias.sigla_categoria,
                                                                            es_trabalho.titulo_enviado, es_trabalho_status.descricao_status, es_trabalho_status.id_status
                                                                            FROM es_trabalho_autor
                                                                            LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho_autor.fgk_instituicao
                                                                            LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_autor.fgk_trabalho
                                                                            LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
                                                                            LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                                                                            LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
                                                                            LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
                                                                            LEFT JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
                                                                            LEFT JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status 
                                                                            WHERE es_trabalho.fgk_evento = ?
                                                                            GROUP BY es_trabalho_autor.fgk_trabalho
                                                                        ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL));
                                                }
                                                else {
                                                $stmt = $db->sql_query("SELECT  es_trabalho.*, es_trabalho.id as id_trabalho, es_trabalho.apresentacao_obrigatoria, es_instituicao.sigla as sigla_instituicao, es_categorias.sigla_categoria,
                                                                            es_trabalho.titulo_enviado, es_trabalho_status.descricao_status, es_trabalho_status.id_status
                                                                            FROM es_trabalho_autor
                                                                            LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho_autor.fgk_instituicao
                                                                            LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_autor.fgk_trabalho
                                                                            LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
                                                                            LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                                                                            LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
                                                                            LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
                                                                            LEFT JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
                                                                            LEFT JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status 
                                                                            WHERE es_trabalho.fgk_evento =? AND es_trabalho_autor.cpf = ? 
                                                                           ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho_autor.cpf'=>CPF_USUARIO));
                                                }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    
                                                    <th>Título</th>
                                                    <th>Categoria</th>
                                                    <th>Autores (* Apresentador)</th> 
                                                    <th>Status</th>
                                                    <!--th>Obrigatório</th-->
													<th>Excluir</th>
                                                    <?php
                                                    if(DATA_SUBMISSAO_FIM < date('Y-m-d'))
                                                        echo '<th></th>';
                                                    ?>

                                                                                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $resumo) {
                                                        echo '
                                                        <tr>
                                                            
                                                            <td><a href="exibir_trabalho.php?id='.$resumo->id_trabalho.'">'.$resumo->titulo_enviado.'</a></td>
                                                            <td>'.$resumo->sigla_categoria.'</td><td>';
                                                            $query = $db->sql_query("SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao", array('fgk_trabalho'=>$resumo->id_trabalho));
                                                            foreach ($query as $autor) {
                                                                if($autor->bool_apresentador == 1)
                                                                    echo $autor->nome.'* ('.$autor->sigla.')<br>';
                                                                else
                                                                    echo $autor->nome.' ('.$autor->sigla.')<br>';
                                                            }
                                                            echo '</td><td>'.$resumo->descricao_status.'</td>';

                                                           // if($resumo->apresentacao_obrigatoria == 1)
                                                           //     echo '<td><img src="assets/images/icons/obrigatorio.png" /></td>';
                                                           // else 
                                                           //      echo '<td></td>';
															$id_trabalho = urlencode(base64_encode($resumo->id_trabalho));
															if(ID_USUARIO == $resumo->fgk_inscrito_responsavel && ($resumo->fgk_status == TRABALHO_NAO_ENVIADO ))
																echo '<td><a class="btn btn-danger"  data-href="cancelar_trabalho.php?id='.$id_trabalho.'" data-toggle="modal" data-target="#confirm-delete">Excluir Submissão</a></td>';
															else 
																echo "<td>Você não possui permissão para excluir este trabalho.</td>";
                                                            if($resumo->apresentacao_obrigatoria == 1 && ($resumo->fgk_status == TRABALHO_NAO_ENVIADO || $resumo->fgk_status == TRABALHO_EM_EDICAO) && DATA_SUBMISSAO_FIM < date('Y-m-d'))
                                                                echo '<td><a href="justificar_nao_envio.php?id_trabalho='.$resumo->id_trabalho.'" class="btn btn-danger">Justificar NÃO Envio </a></td>';
                                                            else if(DATA_SUBMISSAO_FIM < date('Y-m-d'))
                                                                echo '<td></td>';
                                                            
                                                            echo '</tr>';
                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                        
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Atenção
                                    </div>
                                    <div class="modal-body">
                                        Você tem certeza que deseja excluir essa submissão? Essa ação será irreversível.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a class="btn btn-danger btn-ok">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
    include "footer.php";
?>
    <script type="text/javascript">

    $( document ).ready(function() {
       $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

        <?php 
        if(MOBILIDADE_ANO_ATUAL){
            ?>
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Consta no sistema que você se encontra em mobilidade acadêmica. Neste caso, não será necessário fazer a submissão nesta edição do Encontro de Saberes e o seu trabalho que deveria ser submetido este ano, deverá ser apresentado na próxima edição do evento.',
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
       <?php
        }
       /* if(!$db->existe('es_trabalho_autor', array('cpf'=>$_SESSION['cpf'])) && ( $_SESSION['id_tipo_inscrito']==1 || $_SESSION['id_tipo_inscrito'] == 2))
            echo " $('#inexistente').modal('show');";

        $total_trabalhos = $db->sql_query("SELECT count(cpf) as total FROM es_trabalho_autor inner join es_trabalho on fgk_trabalho = es_trabalho.id WHERE es_trabalho_autor.cpf = ? AND fgk_evento = ?", array('cpf'=>CPF_USUARIO, 'fgk_evento'=>EVENTO_ATUAL));
        foreach ($total_trabalhos as $registros) {
            $total = $registros->total;
        }*/
 
        if( DATA_SUBMISSAO_INI <= date('Y-m-d') && DATA_SUBMISSAO_FIM >= date("Y-m-d")){
        ?>
        $('#resumo').DataTable({
            "dom": '<"toolbar">frtip',
            "language": {
                    "emptyTable":     "Nenhum trabalho cadastrado"
            },
            "columns": [
            { "width": "40%" },
            { "width": "10%" },
            { "width": "38%" },
            { "width": "10%" },
			{ "width": "2%" },
          ]
        });
       /* $("div.toolbar").html('<a href="cadastrar_trabalho.php" class="btn btn-danger">Adicionar novo trabalho</a>');*/
        <?php } else { ?>
            $('#resumo').DataTable({"dom": '<"toolbar">frtip',
            "language": {
                    "emptyTable":     "Você ainda não possui nenhum trabalho cadastrado"
            }});
        <?php } ?>  
         
    });

    </script>
    </body>
</html>
<?php } ?>