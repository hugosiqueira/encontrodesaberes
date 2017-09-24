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
                                     <?php if(DATA_ADEQUACAO_INI <= date('Y-m-d H:i:s') && DATA_ADEQUACAO_FIM >= date('Y-m-d H:i:s')) { ?>
                                    <div class="table-responsive">
                                        <table id="resumo" class="table table-striped table-bordered display" style="width:99%">
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
                                                                            WHERE es_trabalho.fgk_evento = ? AND es_trabalho.fgk_status = ?
                                                                            GROUP BY es_trabalho_autor.fgk_trabalho
                                                                        ", array('es_trabalho.fgk_evento'=>EVENTO_ATUAL, 'es_trabalho.fgk_status' =>TRABALHO_APROVADO_RESTRICOES));
                                                }
                                                else {
                                                $stmt = $db->sql_query("SELECT  es_trabalho.*, es_trabalho.id as id_trabalho,
																		es_trabalho.apresentacao_obrigatoria, es_instituicao.sigla as sigla_instituicao,
																		es_categorias.sigla_categoria,
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
                                                                            WHERE es_trabalho.fgk_evento =".EVENTO_ATUAL." AND es_trabalho_autor.cpf = '".CPF_USUARIO."' AND 
																			(es_trabalho.fgk_status = ".TRABALHO_APROVADO_RESTRICOES." OR es_trabalho.fgk_status = ".TRABALHO_APROVADO_RESTRICOES_PARECER_F.")"	);
                                                }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    
                                                    <th>Título</th>
                                                    <th>Categoria</th>
                                                    <th>Autores</th> 
                                                    <th>Status</th>
                                                    <th>Obrigatório</th>

                                                                                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $resumo) {
                                                        echo '
                                                        <tr>
                                                            
                                                            <td><a href="corrigir_trabalho.php?id='.$resumo->id_trabalho.'">'.$resumo->titulo_enviado.'</a></td>
                                                            <td>'.$resumo->sigla_categoria.'</td><td>';
                                                            $query = $db->sql_query("SELECT nome,descricao_tipo, sigla, bool_apresentador FROM es_trabalho_autor 
                                                                                    INNER JOIN es_tipo_autor ON fgk_tipo_autor = id_tipo_autor 
                                                                                    WHERE fgk_trabalho = ? ORDER BY ordenacao ASC", array('fgk_trabalho'=>$resumo->id_trabalho));
                                                            foreach ($query as $autor) {
                                                                if($autor->bool_apresentador == 1)
                                                                    echo $autor->nome.'* ('.$autor->sigla.')<br>';
                                                                else
                                                                    echo $autor->nome.' ('.$autor->sigla.')<br>';
                                                            }
                                                            echo '</td><td>'.$resumo->descricao_status.'</td>';

                                                            if($resumo->apresentacao_obrigatoria == 1)
                                                                echo '<td><img src="assets/images/icons/obrigatorio.png" /></td>';
                                                            else 
                                                                echo '<td></td>';
                                                            
                                                            echo '</tr>';
                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                        <p>* Apresentador</p>
                                    </div>
                                </div>                            
                            </div>
                        </div>
<?php
 } else {
        echo "<p>Não é possível submeter correções, pois está fora do prazo.</p><p>Data Início: ".date('d/m/Y H:i:s', strtotime(DATA_ADEQUACAO_INI))." </p><p>Data Fim: ".date('d/m/Y H:i:s', strtotime(DATA_ADEQUACAO_FIM))." </p>".date('Y-m-d H:i:s')."</div>";
    }
    include "footer.php";

?>
    <script type="text/javascript">
    $( document ).ready(function() {
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
        if(!$db->existe('es_trabalho_autor', array('cpf'=>CPF_USUARIO)))
            echo " $('#inexistente').modal('show');";

        $total_trabalhos = $db->sql_query("SELECT count(cpf) as total FROM es_trabalho_autor WHERE es_trabalho_autor.cpf = ?", array('cpf'=>CPF_USUARIO));
        foreach ($total_trabalhos as $registros) {
            $total = $registros->total;
        }
 
        if(TIPO_USUARIO  == ADMINISTRADOR || ((TIPO_USUARIO  == ALUNO_EXTERNO || TIPO_USUARIO  == PROFESSOR_EXTERNO) )){
        ?>
        $('#resumo').DataTable({
            "dom": '<"toolbar">frtip',
            "language": {
                    "emptyTable":     "Nenhum trabalho cadastrado"
            },
            "columns": [
            { "width": "40%" },
            { "width": "8%" },
            { "width": "40%" },
            { "width": "10%" },
            { "width": "2%" },
          ]
        });
        
        <?php } else { ?>
            $('#resumo').DataTable();
        <?php } ?>       
    });
    </script>

    </body>
</html>
<?php } ?>
