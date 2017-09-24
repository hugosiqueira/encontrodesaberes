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
                                <div class="panel-body">
                                    <?php if($data_ini_submissao_minicurso <= date('Y-m-d') && $data_fim_submissao_minicurso >= date('Y-m-d')) { ?>
                                    <div class="alert alert-warning" role="alert">
                                      <span class="sr-only">Atenção:</span>
                                      <p class="text-justify">O pagamento das inscrições dos minicursos é feito através de boleto bancário que será gerado após a inscrição.</p>
                                      <p class="text-justify">*As inscrições online estarão disponíveis até o dia 01 de novembro de 2015. Após essa data não receberemos inscrições pelo sistema, portanto, aqueles que não garantirem a sua vaga até essa data deverão efetivar a inscrição no dia do evento, se ainda houver disponibilidade.</p>

                                      <p class="text-justify">Atenção: a inscrição no minicurso só será confirmada se o participante estiver com a inscrição confirmada no evento. Portanto, a inscrição no evento deverá ser confirmada para que a vaga no minicurso seja garantida.</p>

                                      <p class="text-justify">* não há reembolso, em nenhuma hipótese.</p>
                                      <p class="text-justify">* a opção de minicurso escolhida só poderá ser alterada se o horário da apresentação de trabalho (que será divulgada dia 5 de novembro) coincidir com o horário do minicurso.</p>

                                      <p class="text-justify">Atenciosamente,</p>

                                      <p class="text-justify">Equipe organizadora Encontro de Saberes UFOP 2015</p>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body text-center">
                                    <div class="table-responsive">
                                        <table id="resumos" class="table table-striped table-bordered display select" style="width:99%">
                                            <?php
                                                
                                                $stmt = $db->sql_query("SELECT * FROM es_minicursos WHERE bool_publicado = ? AND fgk_evento = ?", array('bool_publicado'=>1, 'fgk_evento'=>1));
                                                    
                                                
                                            ?>
                                            <thead>
                                                <tr class="danger">
                                                    <th>Minicurso</th>
                                                    <th>Apresentador</th>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Local</th>
                                                    <th>Status</th>
                                                    <th>Boleto</th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($stmt as $minicurso) {
                                                        $verificar_inscricao = $db->sql_query("SELECT es_minicursos_inscritos.*, es_inscritos_servicos.bool_pago, link
                                                                                                FROM es_minicursos_inscritos
                                                                                                inner join es_inscritos_servicos on es_minicursos_inscritos.fgk_inscrito_servico = es_inscritos_servicos.id_inscrito_servico
                                                                                                left join es_inscritos_boletos on es_inscritos_boletos.id_boleto = es_inscritos_servicos.fgk_boleto
                                                                                                WHERE es_minicursos_inscritos.fgk_minicurso = ? and es_inscritos_servicos.fgk_inscrito = ?" , 
                                                                                                array('es_minicursos_inscritos.fgk_minicurso' => $minicurso->id, 'es_inscritos_servicos.fgk_inscrito'=>$_SESSION['id_inscrito']) );
                                                        $link = "";
                                                        $status_inscricao = "Não inscrito";
                                                        $botao_inscrever = '<a href="inscrever_minicurso.php?id='.$minicurso->id.'" class="btn btn-primary botao">Inscrever-se</a>';
                                                        foreach ($verificar_inscricao as $value) {
                                                            $bool_pago = $value->bool_pago;
                                                            $link = $value->link;
                                                            $link = '<a href="'.$link.'"><img src="assets/images/icons/boleto.png" /></a>';
                                                           
                                                                if($bool_pago == 1){
                                                                    $link = "<img src='assets/images/icons/pago.png' />";
                                                                    $status_inscricao = "Inscrição confirmada";
                                                                    $botao_inscrever = '<a href="inscrever_minicurso.php?id='.$minicurso->id.'" class="btn btn-success botao">Detalhes</a>';

                                                                } else if($bool_pago == 0){
                                                                     $status_inscricao = "Aguardando Pagamento";
                                                                     $botao_inscrever = '<a href="inscrever_minicurso.php?id='.$minicurso->id.'" class="btn btn-success botao">Detalhes</a>';
                                                                }
                                                            
                                                            
                                                            
                                                            

                                                            
                                                        }
                                                        echo '
                                                        <tr>
                                                            
                                                            <td style="text-align: left;">'.$minicurso->titulo.'</td>
                                                            <td>'.$minicurso->apresentador.'</td>
                                                            <td>'.date('d/m/Y', strtotime($minicurso->data)).'</td>
                                                            <td>'.date('H:i', strtotime($minicurso->hora_ini)).' - '.date('H:i', strtotime($minicurso->hora_fim)).'</td>
                                                            <td>'.$minicurso->local.'</td>
                                                            <td>'.$status_inscricao.'</td>
                                                            <td>'.$link.'</td>
                                                            <td>'.$botao_inscrever.'</td>


                                                        </tr>';
                                                            

                                                    }
                                                ?>
                                            </tbody> 
                                        </table>
                                       
                                    </form>
                                    </div>

                                </div>                            
                                </div>
                                    
                            </div>
                            <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tr>
                                                    <th>Tipo de inscrição</th>
                                                    <th>Valor</th>
                                                </tr>
                                                <?php 
                                                $buscar_servicos = $db->sql_query("SELECT * FROM es_servicos WHERE id_servico >= ?", array('id_servico'=>6));
                                                foreach ($buscar_servicos as $registro) {
                                                    echo "  <tr>
                                                                <td>".$registro->descricao_servico."</td>
                                                                <td>R$" . number_format($registro->valor_servico/100, 2, ',', '.')."</td>
                                                            </tr>";
                                                }

                                                ?>
                                            </table>
                                        </div>
                                    </div>
                        <?php  
                        } else { 
                            echo "<p>Não estamos no período de inscrições de minicursos.</p><p>Data Inicial: ".date('d/m/Y H:i', strtotime($data_ini_submissao_minicurso))."</p><p>Data Final: ".date('d/m/Y H:i', strtotime($data_fim_submissao_minicurso))."</p>"; 
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
        $('#resumos').DataTable({
            dom: 'T<"top"i>frt<"clear">lp',
            "columns": [

                { "width": "30%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "10%" }


            ],
            "language": {
                        "emptyTable":     "Nenhum minicurso para inscrever-se até o momento. Retorne mais tarde"
            }
           
        });
   });
   
    </script>

</html>
<?php } ?>
