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
<style type="text/css">.botao { width: 100px;}</style>

            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inscrever em Minicursos</a></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body text-center">
                                    <div class="table-responsive">
                                        <table id="pagamentos" class="table table-striped table-bordered display select" style="width:99%">
                                            <?php
                                                
                                                $stmt = $db->sql_query("SELECT es_inscritos_servicos.valor_servico, data_vencimento, descricao_servico, link, es_inscritos_servicos.bool_pago
                                                                        FROM `es_inscritos_servicos`
                                                                        LEFT JOIN es_inscritos_boletos ON es_inscritos_boletos.id_boleto = es_inscritos_servicos.fgk_boleto
                                                                        LEFT JOIN es_servicos ON es_servicos.id_servico = es_inscritos_servicos.fgk_servico
                                                                        WHERE es_inscritos_servicos.fgk_inscrito = ? AND es_inscritos_boletos.fgk_evento = ?", array('es_inscritos_servicos.fgk_inscrito'=>$_SESSION['id_inscrito'], 'es_inscritos_boletos.fgk_evento'=>EVENTO_ATUAL));
                                                    
                                                
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th>Descrição</th>
                                                    <th>Data Vencimento</th>
                                                    <th>Valor</th>
                                                    <th>Pagamento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $boletos) {
                                                        if($boletos->bool_pago == 0){
                                                            $pagamento = '<a href="'.$boletos->link.'" target="_blank"><img src="assets/images/icons/boleto.png" /></a>';
                                                        } else{
                                                            $pagamento = '<img src="assets/images/icons/pago.png" />';
                                                        }
           
                                                        echo '
                                                        <tr>
                                                            <td style="text-align: left;"><a href="'.$boletos->link.'" target="_blank">'.$boletos->descricao_servico.'</a></td>
                                                            <td>'.date('d/m/Y', strtotime($boletos->data_vencimento)).'</td>
                                                            <td>R$' . number_format($boletos->valor_servico/100, 2, ',', '.').'</td>
                                                            <td>'. $pagamento. '</td>
                                                        </tr>';
                                                            

                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                    </div>

                                </div>                            
                                </div>
                                    
                            </div>
                        <?php  
                        } else { 
                            echo "<p>Não estamos no período de inscrições de minicursos.</p><p>Data Inicial: ".date('d/m/Y H:i', strtotime($data_ini_submissao_minicurso))."</p><p>Data Final: ".date('d/m/Y H:i', strtotime($data_ini_submissao_minicurso))."</p>"; 
                        }
                        ?>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->

<?php 
    include "footer.php";
?>
    </body>
    <link rel="stylesheet" type="text/css" href="assets/countdown/jquery.countdown.css">
    <script src="assets/countdown/jquery.countdown.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
    $( document ).ready(function() {
        $('#pagamentos').DataTable({
            dom: 'T<"top"i>frt<"clear">lp',
            "columns": [

                { "width": "70%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" }


            ],
            "language": {
                        "emptyTable":     "Nenhum boleto foi encontrado."
            }
           
        });
   });
   
    </script>

</html>
