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
                                    <li><a href="cadastrar_minicursos.php">Enviar proposta de minicurso</a></li>
                                </ol>
                            </div>
                        </div>
                        <div id="main-wrapper">

                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <h3>Critérios para seleção dos minicursos e aprovação para fazer parte do evento: </h3>
                                    <p class="text-justify">Tendo em vista a realização do Encontro de Saberes, entre os dias 18 e 20 de novembro de 2015, no Centro de Artes e Convenções da UFOP, estamos convidando os docentes da UFOP a encaminharem suas propostas para a realização de minicursos ou oficinas que deverão ter a carga horária de 2 horas.  </p>
                                    <p class="text-justify">Serão no máximo 10 minicursos na grade de programação devido a disponibilidade de espaço. As propostas serão avaliadas por comissão interna do Encontro de Saberes com os seguintes critérios e nessa ordem: </p>
                                    <ul>
                                        <li> Tema abrangente e multidisciplinar;</li>
                                        <li> Proposta que tenha alguma rela&ccedil;&atilde;o com o tema do evento: Internacionaliza&ccedil;&atilde;o</li>
                                    </ul>

                                    <p class="text-justify">O evento fornecerá apenas o espaço, a sala no Centro de Convenções, datashow, tela e computador para as atividades. Os demais materiais e equipamentos necessários deverão ser providenciados pelo ministrante. </p>
                                    <p class="text-justify">A data e o horário do seu minicurso será pré-definida pela organização do Encontro de Saberes, de acordo com a disponibilidade das salas entre os dias 19/11 (manhã ou tarde) e 20/11 (manhã). Enviaremos para o seu email para aprovação o horário pré-agendado. </p>
                                </div>
                                

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="minicurso" class="table table-striped table-bordered display" style="width:99%">
                                            <?php
                                                if($bool_admin == 1){
                                                     $stmt = $db->sql_query("SELECT * FROM es_minicursos_propostos
                                                                            INNER JOIN es_area_especifica ON es_minicursos_propostos.fgk_area_especifica = es_area_especifica.id
                                                                            INNER JOIN es_inscritos ON es_minicursos_propostos.fgk_inscrito = es_inscritos.id");
                                                }
                                                else {
                                                $stmt = $db->sql_query("SELECT  * FROM es_minicursos_propostos
                                                                        INNER JOIN es_area_especifica ON es_minicursos_propostos.fgk_area_especifica = es_area_especifica.id
                                                                        INNER JOIN es_inscritos ON es_minicursos_propostos.fgk_inscrito = es_inscritos.id
                                                                        WHERE es_minicursos_propostos.fgk_inscrito = ? ", array('es_minicursos_propostos.fgk_inscrito'=>$id_inscrito));
                                                }
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th>Área Específica</th>
                                                    <th>Responsável</th>
                                                    <th>Assunto</th> 
                                                    <th>Status</th> 
                                                    <th></th>                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $minicurso) {
                                                        switch($minicurso->status){
                                                            case 0:
                                                                $status = "Em edição";
                                                            break;
                                                            case 1:
                                                                $status = "Em edição";
                                                            break;
                                                            case 2:
                                                                $status = "Submetido";
                                                            break;
                                                            case 3:
                                                                $status = "Aprovado";
                                                            break;
                                                            case 3:
                                                                $status = "Rejeitado";
                                                            break;

                                                        }
                                                        echo '
                                                        <tr>
                                                            <td>
                                                                '.$minicurso->descricao_area_especifica.'
                                                            </td>
                                                            <td>
                                                                '.$minicurso->nome.'
                                                            </td>
                                                            <td>
                                                                '.$minicurso->assunto.'
                                                            </td>
                                                            <td>
                                                                '.$status.'
                                                            </td>
                                                            <td>
                                                                <a href="cadastrar_proposta_minicurso.php?id_proposta='.$minicurso->id_minicurso_prop.'" class="btn btn-danger">Detalhes</a>
                                                            </td>
                                                        </tr>
                                                                ';

                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
<?php
    include "footer.php";
?>
    <script type="text/javascript">

    $( document ).ready(function() {
        <?php 
        if($id_tipo_inscrito == 5 || $id_tipo_inscrito == 2){
        ?>
        $('#minicurso').DataTable({
            "dom": '<"toolbar">frtip',
            "language": {
                    "emptyTable":     "Nenhuma proposta de minicurso foi submetida até o momento"
            }
        });
        $("div.toolbar").html('<a href="cadastrar_proposta_minicurso.php" class="btn btn-danger">Propor novo minicurso</a>');
        <?php } else { ?>
            $('#minicurso').DataTable({
                "language": {
                    "emptyTable":     "Nenhuma proposta de minicurso foi submetida até o momento"
            }
            });
        <?php } ?>       
    });
    <?php } ?>
    </script>
    </body>
</html>
    