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
                                            <p class="text-justify">A inscri&ccedil;&atilde;o no Encontro de Saberes dar&aacute; ao inscrito o direito de:</p>

                                            <ol>
                                                <li>Submeter resumos ao SEIC, desde que referentes a projetos de Inicia&ccedil;&atilde;o Cient&iacute;fica vinculados &agrave; Pr&oacute;-reitora de Pesquisa e P&oacute;s-gradua&ccedil;&atilde;o (da UFOP ou de outras institui&ccedil;&otilde;es). Cada projeto poder&aacute; submeter 01 resumo;</li>
                                                <li>Submeter um trabalho referente a projetos de Extens&atilde;o (UFOP) para o SEXT;</li>
                                                <li>Submeter um trabalho referente a projeto do Programa Pr&oacute;-ativa (UFOP) para a Mostra Pr&oacute;-Ativa.</li>
                                                <li>Submeter um trabalho referente a experi&ecirc;ncia no Programa Institucional de Bolsa de Inicia&ccedil;&atilde;o &agrave; Doc&ecirc;ncia (Pibid - UFOP) para a Mostra PIBID.</li>
                                                <li>Submeter um trabalho referente a experi&ecirc;ncia no Programa de Educa&ccedil;&atilde;o Tutorial (PET - UFOP) para a Mostra PET.</li>
                                                <li>Submeter um trabalho referente a experi&ecirc;ncia no Programa de Monitoria (UFOP) para a Mostra Monitoria.</li>
                                                <li>Submeter um trabalho referente a experi&ecirc;ncia em mobilidade acad&ecirc;mica/ci&ecirc;ncia sem fronteiras (UFOP) para o SEINTER.</li>
                                            </ol>

                                            <p class="text-justify">*Alunos de outras institui&ccedil;&otilde;es s&oacute; poder&atilde;o submeter trabalhos relacionados a seus projetos de Inicia&ccedil;&atilde;o Cient&iacute;fica no SEIC. Aten&ccedil;&atilde;o: apenas se for trabalho de Inicia&ccedil;&atilde;o Cient&iacute;fica da sua institui&ccedil;&atilde;o.</p>

                                            <p class="text-justify">O per&iacute;odo de inscri&ccedil;&otilde;es no Encontro de Saberes 2016 ser&aacute; de&nbsp;12 de setembro a 09 de novembro de 2016.&nbsp;</p>

                                            <p class="text-justify">Possivelmente ser&atilde;o abertas vagas de participa&ccedil;&atilde;o no evento nos dias de realiza&ccedil;&atilde;o do Encontro de Saberes&nbsp;(22 e 23 de novembro de 2016),&nbsp;conforme disponibilidade.</p>

                                            <p class="text-justify">O per&iacute;odo de submiss&atilde;o de trabalhos no sistema ser&aacute; de&nbsp;12 de setembro a 05 de outubro de 2016.</p>

                                        



                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-justify"><strong>TAXA DE INSCRI&Ccedil;&Atilde;O</strong></p>
                                            <p class="text-justify">O pagamento da inscri&ccedil;&atilde;o dever&aacute; ser realizado via boleto. Basta acessar a sua &aacute;rea restrita e gerar o boleto para visualiza&ccedil;&atilde;o ou impress&atilde;o e pagamento.</p>

                                            <p class="text-justify">Lembrando que para confirmar a sua inscri&ccedil;&atilde;o e participa&ccedil;&atilde;o no evento &eacute; necess&aacute;rio efetuar o pagamento.</p>

                                            <p class="text-justify">Caso a inscri&ccedil;&atilde;o n&atilde;o seja confirmada no prazo, o trabalho submetido, se for o caso, n&atilde;o poder&aacute; ser apresentado.</p>

                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="danger">
                                                        <td class="text-center" colspan="2">
                                                            Valor das Inscri&ccedil;&otilde;es</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Estudante da UFOP</td>
                                                                <td>
                                                                    R$25,00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Professores ou t&eacute;cnicos da UFOP</td>
                                                                        <td>
                                                                            R$35,00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Estudante de outras institui&ccedil;&otilde;es</td>
                                                                                <td>
                                                                                    R$50,00</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Professores ou profissionais de outras institui&ccedil;&otilde;es</td>
                                                                                        <td>
                                                                                            R$70,00</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <p class="text-justify">* N&atilde;o haver&aacute; restitui&ccedil;&atilde;o da taxa de inscri&ccedil;&atilde;o no evento, em nenhuma hip&oacute;tese.</p>
                                                                                <p class="text-justify">*Os professores que forem designados para revisar resumos online e/ou avaliar trabalhos no evento n&atilde;o ser&atilde;o obrigados a pagar a inscri&ccedil;&atilde;o, apenas realizar o seu cadastro no site.</p>
                                                                                <p class="text-justify">Qualquer dúvida entre em contato com a Topazio Imperial Organização de Eventos - Telefones: (31) 3551-4006 - Celular: (31) 99917-5683 - E-mail: encontrodesaberes@ufop.br</p>
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
