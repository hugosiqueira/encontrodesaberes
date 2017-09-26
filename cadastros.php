<?php 
include "header.php"; 
$ip = $_SERVER["REMOTE_ADDR"];
?>

<!-- ======== @Region: #highlighted ======== -->

<div id="highlighted">

    <div class="container">

        <div class="header">

            <h2 class="page-title">

                <span>Inscri&ccedil;&otilde;es</span> 
                <small>Preecha os campos a seguir para fazer sua inscri&ccedil;&atilde;o</small>

            </h2>

        </div>

    </div>

</div>
<div id="content">
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <?php 
                    $today=date('Y-m-d');
                    /*if($today > $data_inscricao_fim || $today < $data_inscricao_ini){
                      echo " <div class='row'><p>Desculpe-nos, mas não estamos dentro do prazo de inscrições online.</p></div>";
                      exit();
                  }
                  else { */?>
                    <div id="rootwizard">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab4" data-toggle="tab"><i class="fa fa-user m-r-xs"></i> Informa&ccedil;&otilde;es para Cadastro</a></li>
                            <li role="presentation" class="#tab1"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i> Informa&ccedil;&otilde;es Pessoais</a></li>
                            <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-institution m-r-xs"></i> Informa&ccedil;&otilde;es Institucionais</a></li>
                            <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-check m-r-xs"></i> Finalizar</a></li>
                        </ul>
                        <div class="progress progress-sm m-t-sm">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            </div>
                        </div>
                        <form action="javascript:void(0)"  id="cadastro" name="cadastro">
                            <div class="tab-content">
                                <div class="tab-pane fade" id="tab1">
                                    <div class="row m-b-lg">
                                        <div class="col-md-6">
                                            <div id="aguarde" class="modal fade modal" role="dialog">
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
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="cpf">CPF</label>
                                                    <input type="hidden" class="form-control" id="ip" value="<?=$ip;?>" name="ip" >
                                                    <input type="hidden" class="form-control" id="bool_temp" name="bool_temp" value="">
                                                    <input type="hidden" class="form-control" id="bool_monitoria" value=0 name="bool_monitoria" >
                                                    <input type="text" class="form-control" data-mask="000.000.000-00" id="cpf" name ="cpf" >
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="nome">Nome Completo*</label>
                                                    <input type="text" class="form-control" minlength="4" id="nome" name ="nome" >
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="email">E-mail*</label>
                                                    <input type="email" class="form-control" name="email" id="email" required  autocomplete="off">
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="emaila">E-mail alternativo*</label>
                                                    <input type="email" class="form-control" name="emaila" id="emaila" autocomplete="off" >
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="tel" class="form-control" data-mask="(00) 0000-00000" id="telefone" name ="telefone" autocomplete="off">
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="telefone_celular">Celular*</label>
                                                    <input type="tel" class="form-control" data-mask="(00) 0000-00000" id="telefone_celular" name ="telefone_celular" autocomplete="off" required >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="cep">CEP*</label>
                                                    <input type="text" class="form-control"  name="cep" id="cep" data-mask="00000-000" required  >
                                                    <p class="help-block"></p>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="estado">Estado*</label>
                                                    <select class="form-control" id="estado" name="estado" >
                                                        <option>
                                                        </option>
                                                        <?php

                                                        $stmt = $db->sql_query("SELECT *
                                                          FROM desk_estados WHERE fgk_pais = ?
                                                          ORDER BY uf", array('fgk_pais' => 34));
                                                        foreach ($stmt as $estado) {
                                                            echo '<option value="'.$estado->uf.'" '.$selected_estado.'>'.$estado->descricao_estado.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="cidade">Cidade*</label>
                                                    <span class="carregando" style="display:none">Aguarde, carregando...</span>
                                                    <select class="form-control" id="cidade" name="cidade">
                                                        <option>
                                                        </option>
                                                    </select>
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="bairro">Bairro*</label>
                                                    <input type="text" class="form-control"  id="bairro" name ="bairro" required >
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="endereco">Endere&ccedil;o*</label>
                                                    <input type="text" class="form-control"  id="endereco" name ="endereco" required>
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="numero">N&uacute;mero*</label>
                                                    <input type="text" class="form-control"  id="numero" name ="numero" required>
                                                    <p class="help-block"></p>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="complemento">Complemento</label>
                                                    <input type="text" class="form-control"  id="complemento" name ="complemento" >
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12"> 
                                                <label for="instituicao">Institui&ccedil;&atilde;o*</label>
                                                <select class="form-control" id="instituicao" name="instituicao" >
                                                    <option>
                                                    </option>
                                                    <?php
                                                    $stmt = $db->sql_query("SELECT *
                                                      FROM es_instituicao 
                                                      ORDER BY nome");


                                                    foreach ($stmt as $instituicao) {
                                                        echo '<option value="'.$instituicao->id.'" '.$selected_instituicao.'>'.$instituicao->nome.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="departamento">Departamento</label>
                                                <input type="hidden" class="form-control"  id="id_departamento" name ="id_departamento" >
                                                <input type="text" class="form-control"  id="departamento" name ="departamento" >
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="curso">Curso</label>
                                                <input type="hidden" class="form-control"  id="id_curso" name ="id_curso" >
                                                <input type="text" class="form-control"  id="curso" name ="curso" >
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="hidden" class="form-control"  id="mobilidade_ano_passado" name ="mobilidade_ano_passado" >
                                                <input type="hidden" class="form-control"  id="mobilidade_ano_atual" name ="mobilidade_ano_atual" >
                                                <label for="matricula">Matr&iacute;cula</label>
                                                <input type="text" class="form-control"  id="matricula" name ="matricula" >
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="sucesso" style='display:none;'></div>
                                            <div id="processando" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Encontro de Saberes</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            Aguarde, processando...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="bool_necessidade_especial">Necessita de atendimento especial</label>
                                                <select class="form-control" id="bool_necessidade_especial" name="bool_necessidade_especial" >
                                                    <option value="0">Não</option>
                                                    <option value="1">Sim</option>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="necessidade_especial_descricao">Necessidade Especial</label>
                                                <input type="text" class="form-control"  id="necessidade_especial_descricao" name ="necessidade_especial_descricao">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="nome_cracha">Nome para o crachá*</label>
                                                <input type="text" class="form-control"  id="nome_cracha" name ="nome_cracha">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="senha">Senha*</label>
                                                <input type="password" class="form-control"  id="senha" name ="senha" minlength="8" placeholder="Digite uma senha de no mínimo 8 caracteres">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="csenha">Confirmar Senha*</label>
                                                <input type="password" class="form-control"  id="csenha" name ="csenha" placeholder="Confirme sua senha">
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="checkbox inline">
                                                    <input type="checkbox" name="autoriza_envio_emails" id="autoriza_envio_emails" checked> Autorizo receber informa&ccedil;&otilde;es sobre o Encontro de Saberes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label for="tipo_inscricao">Tipo da Inscri&ccedil;&atilde;o*</label>
                                                <select class="form-control" id="tipo_inscricao" name="tipo_inscricao" >
                                                    <option>
                                                    </option>
                                                    <?php

                                                    $stmt = $db->sql_query('SELECT * FROM es_inscritos_tipos WHERE fgk_evento = ? AND id_tipo_inscrito <> ?', array('fgk_evento'=>1, 'id_tipo_inscrito' => 5));  
                                                    foreach ($stmt as $inscritos) {
                                                        echo '<option value="'.$inscritos->id_tipo_inscrito.'" >'.$inscritos->descricao_tipo.'</option>';
                                                    }
                                                    ?>
                                                </select>
												<input type="hidden" name="descricao_servico" value="<?=$inscritos->descricao_tipo;?>" />
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="valor_inscricao">Valor</label>
                                                <input type="text" class="form-control"  id="valor_inscricao" name ="valor_inscricao" readonly>
                                                <p class="help-block"></p>
                                            </div>
                                            <div class="form-actions" style="background: #fff">
                                                <button class="btn btn-primary btn-large pull-right" id="button_enviar" type="submit">Cadastrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active fade in" id="tab4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-justify">A participação no Encontro de Saberes é aberta para toda comunidade acadêmica. Entretanto, para submissão de trabalhos é necessário realizar a inscrição no evento. A submissão do resumo/trabalho deve ser realizada pelo estudante que irá apresentá-lo como autor. </p>
                                            <p>Cada inscrição no Encontro de Saberes dará ao inscrito o direito de:</p>

                                            <ol>
                                                <li>1.  Submeter um resumo no XXV SEIC.</li>
                                                <li>2.  Submeter um resumo para a I Mostra da Pós-Graduação.</li>
                                                <li>3.  Submeter um trabalho referente a projetos de Extensão (UFOP) para o SEXT;</li>
                                                <li>4.  Submeter um trabalho referente a projeto do Programa Pró-ativa (UFOP) para a Mostra Pró-Ativa.</li>
                                                <li>5.  Submeter um trabalho referente à experiência no Programa Institucional de Bolsa de Iniciação à Docência (Pibid - UFOP) para a Mostra PIBID.</li>
                                                <li>6.  Submeter um trabalho referente à experiência no Programa de Monitoria (UFOP) para a Mostra Monitoria.</li>
                                                <li>7.  Submeter um trabalho referente à experiência em mobilidade acadêmica/Ciências sem Fronteiras (UFOP) para o III SEINTER.</li>
                                            </ol>

                                            <p class="text-justify">*ATENÇÃO: Alunos de outras instituições serão bem vindos e só poderão submeter ao SEIC e SEXT trabalhos cadastrados como Iniciação Científica ou Extensão em suas respectivas instituições. As demais mostras do Encontro dos Saberes receberão submissões somente de alunos da UFOP. </p>

                                            <p class="text-justify">O período de submissão de trabalhos no sítio do evento será de 26 de setembro a 11 de outubro de 2017</p>                                      

                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-justify"><strong>TAXA DE INSCRI&Ccedil;&Atilde;O</strong></p>
                                            <p class="text-justify">O pagamento da inscrição deverá ser realizado via boleto até o dia 16 de novembro. Basta acessar a sua área restrita e gerar o boleto para pagamento. Para confirmar a sua inscrição e a apresentação de trabalho no evento é necessário efetuar o pagamento.</p>

                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="danger">
                                                        <td class="text-center" colspan="2">
                                                            Valor das Inscri&ccedil;&otilde;es</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Graduandos da UFOP</td>
                                                            <td>R$30,00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pós-Graduandos da UFOP</td>
                                                            <td>R$45,00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estudante de outras institui&ccedil;&otilde;es</td>
                                                            <td>R$60,00</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Professores ou profissionais de outras institui&ccedil;&otilde;es</td>
                                                            <td>R$75,00</td>
                                                        </tr>
                                            </table>
                                            <p class="text-justify">* *Não haverá restituição da taxa de inscrição no evento. Só serão emitidos certificados de apresentação de trabalhos devidamente inscritos vinculados à apresentação oral, pôster, bancada ou apresentação artística na data e horário estabelecidos na programação com pagamento da taxa de inscrição efetuados.</p>
                                            <p class="text-justify">*Os professores e pós-graduandos que forem designados para revisar resumos online e/ou avaliar trabalhos durante o evento receberão certificados de avaliadores emitidos no próprio sistema do Encontro de Saberes. Os avaliadores não precisarão pagar a inscrição, mas deverão se cadastrar no site para avaliarem.</p>
                                            <p class="text-justify">A participação de discentes e pessoas da comunidade é gratuita e livre e não serão emitidos certificados de participação do evento. A carga horária de participação devidamente comprovada por meio eletrônico poderá ser contabilizada como ATV para os discentes da UFOP.</p>
                                            <p class="text-justify">Em caso de dúvida entrar em contato com a Topázio Imperial Organização de Eventos - Telefones: (31) 3551-4006 - Celular: (31) 99917-5683 - E-mail: encontrodesaberes@ufop.br</p>
                                        </div>
                                    </div>
                                </div>

                                <ul class="pager wizard">
                                    <li class="previous first" class="btn btn-danger" style="display:none;"><a href="#">Primeira</a></li>
                                    <li class="previous" id="voltar"><a href="#" class="btn btn-danger">Voltar</a></li>
                                    <li class="next last" class="btn btn-danger" style="display:none;"><a href="#">&Uacute;ltima</a></li>
                                    <li class="next" id="avancar"><a href="#" class="btn btn-danger">Avan&ccedil;ar</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <?php //}  ?>


                </div>
            </div>
        </div>
    </div>
</div>

<?php 

include "bibliotecas.php"; 

?>

<script src="js/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="js/cadastro.js"></script>

<?php include "footer.php"; ?>

