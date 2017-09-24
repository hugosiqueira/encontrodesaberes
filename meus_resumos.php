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
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Projetos da UFOP</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="resumo" class="table table-striped table-bordered display" style="width:99%">
                                            <?php
                                                if(TIPO_USUARIO == ADMINISTRADOR){
                                                     $stmt = $db->sql_query("SELECT  es_trabalho.id as id_trabalho, es_instituicao.sigla as sigla_instituicao, es_categorias.sigla_categoria,
                                                                            es_trabalho.titulo_enviado, es_trabalho_status.descricao_status
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
                                                $stmt = $db->sql_query("SELECT  es_trabalho.id as id_trabalho, es_instituicao.sigla as sigla_instituicao, es_categorias.sigla_categoria,
                                                                            es_trabalho.titulo_enviado, es_trabalho_status.descricao_status
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
                                                    <th>Autores</th> 
                                                    <th>Status</th> 
                                                    <th></th>                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $resumo) {
                                                        echo '
                                                        <tr>
                                                            <td><a href="exibir_trabalho.php?id='.$resumo->id_trabalho.'">'.$resumo->titulo_enviado.'</a></td>
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
                                                            echo '</td><td>'.$resumo->descricao_status.'</td><td><a href="exibir_trabalho.php?id='.$resumo->id_trabalho.'" class="btn btn-success">Detalhes</a></td></tr>';
                                                            
                                                            echo '';
                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                        <p>* Apresentador</p>
                                    </div>
                                </div>                            
                            </div>
<?php
    include "footer.php";
?>
    <script type="text/javascript">
    $( document ).ready(function() {
         $('#resumo').DataTable();
        // CounterUp Plugin
        <?php 
            if($status_boleto == 0) 
                echo " $('.counter').counterUp({
            delay: 10,
            time: 100000
        });
        
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut',
                timeOut: 0,
                extendedTimeOut: 0
            };
            toastr.error('Em nossos registros ainda não consta o pagamento de sua inscrição. Para realizá-lo clique no botão e pague o boleto gerado. Caso já tenha efetuado, desconsidere essa mensagem.<br /><br /><a href=\"".$link_boleto."\" class=\"btn btn-success\" target=\"_blank\">Pagar Inscrição</button>', 'Atenção');
        }, 1800);";
        ?>

       
    });
    </script>
    </body>
</html>
<?php } ?>