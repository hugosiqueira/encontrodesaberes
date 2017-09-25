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
    $id_trabalho = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);
    $trabalho = dadosTrabalho($db,  $id_trabalho);
    if( ($trabalho["id_status"] != TRABALHO_NAO_ENVIADO && $trabalho["id_status"] != TRABALHO_EM_EDICAO )){
        $disabled = "disabled";
    } else{
        $disabled = "";
    }

    if($trabalho["id_projeto"]){
        $edicao = "disabled";
    } else {
        $edicao = "";
    }
    

    $sql_autor = "SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
    $dados_autor = $db->sql_query($sql_autor, array('fgk_trabalho'=>$id_trabalho));
    foreach ($dados_autor as $autor) {
        if($autor->fgk_tipo_autor == 1){
            $nome_autor = $autor->nome;
        } else if ($autor->fgk_tipo_autor == 2){
            $nome_orientador = $autor->nome;
        }
    }
    
?>   
<style type="text/css">
    .frameResults { border-style: solid; border-width: 1px; height: 550px;}
    </style>
    <script type="text/javascript" src="assets/js/diff.js"></script>
    </head>
    <script type="text/javascript"><!--
        var diff = new ML.Text.Diff();
        var htmlSpecialChars = function(text)
        {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
<?php if($trabalho["id_status"] != TRABALHO_NAO_ENVIADO && $trabalho["id_status"] != TRABALHO_SUBMETIDO){ ?>
        function updateDifference()
        {
            var theform, difference, before, after, afterPatch;

            theform = document.getElementById('theform');
            difference = {
                mode: 'w',
                patch: true
            };
            before = document.getElementById('after').value;
            after = document.getElementById('before').value;
            afterPatch = {};
            if(diff.formatDiffAsHtml(before, after, difference)
            && diff.patch(before, difference.difference, afterPatch)) 
            {
                document.getElementById('difference').innerHTML = difference.html;
                //document.getElementById('patch').innerHTML = (after === afterPatch.after ? 'Não houve alterações no resumo' : 'There is a BUG: The patched text (<b>' + htmlSpecialChars(afterPatch.after) + '</b>) does not match the text after (<b>' + htmlSpecialChars(after) + '</b>).');
            }
            if(before == after){
                document.getElementById('difference').innerHTML = "Não houve alterações no resumo.";
            }
        }
<?php } ?>
// --></script>    
 <div id="processando" class="modal fade modal" role="dialog">
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
            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Submeter trabalhos</a></li>
                        </ol>
                    </div>
                </div>
				<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel" >Adicionar novo autor</h4>
							</div>
							<form id="add-novo-autor" action="javascript:void(0);">
								<div class="modal-body">
								
									<div class="form-group">
										<input type="hidden" id="id_trabalho_autor" name="id_trabalho_autor" value="<?=$id_trabalho;?>" class="form-control">
										<input type="text" id="cpf_autor" name="cpf_autor" class="form-control" placeholder="CPF" required>
									</div>
									<div class="form-group">
										<input type="text" id="nome_autor" name="nome_autor" class="form-control" placeholder="Nome" required>
									</div>
									<div class="form-group">
										<input type="email" id="email_autor" name="email_autor" class="form-control" placeholder="E-mail" required>
									</div>
									<div class="form-group">
										<select class='form-control' id='instituicao_autor' name='instituicao_autor' required>
											<option>Selecione a Instituição</option>
											<?php 
											$stmt = $db->sql_query('SELECT * FROM es_instituicao ORDER BY nome');
											foreach ($stmt as $instituicao) { 
												echo '<option value="'.$instituicao->id.'" >'.$instituicao->nome.'</option>';
												 } 
											?>
										</select>
									</div>
									<div class="form-group">
										<select class='form-control' id='tipo_autor' name='tipo_autor' required>
											<option>Selecione a função do autor</option>
											<?php 
											$stmt = $db->sql_query('SELECT * FROM es_tipo_autor WHERE descricao_tipo <> "Autor"');
											foreach ($stmt as $autor) {
												echo '<option value="'.$autor->id_tipo_autor.'"  >'.$autor->descricao_tipo.' </option>';
											}
											?>
										</select>
									</div>
									<div class="form-group">
										 <input type="number" id="ordem_autor" name="ordem_autor" class="form-control" placeholder="Qual a ordem de autoria do autor?" min = 1 required>
									</div>
								

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="submit" id="add-autor" class="btn btn-danger">Adicionar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
                <div id="main-wrapper">
                    <div class="row">
						<div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Autores</h4>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        if(!$trabalho["id_projeto"] && ($trabalho["id_status"] == TRABALHO_EM_EDICAO || $trabalho["id_status"] == TRABALHO_NAO_ENVIADO) ){
                                    ?>
                                    <button type="button" class="btn btn-danger m-b-sm" data-toggle="modal" data-target="#myModal">Adicionar novo autor</button>
                                    <?php
                                        }
                                    ?>
                                    <!-- Modal -->
                                    

                                    <div class="table-responsive">
                                        <table id="autores" class="display table autores" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Tipo</th>
                                                    <th>Ordem</th>
                                                    <th>Apresentador</th>
                                                    <th>CPF</th>
                                                    <th>E-mail</th>
                                                    <th>Excluir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_autores = "SELECT *, es_trabalho_autor.id as id_autor from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
                                                $dados_autores = $db->sql_query($sql_autores, array('fgk_trabalho'=>$id_trabalho));
                                                foreach ($dados_autores as $autores) {
                                                    if($autores->bool_apresentador == 1)
                                                        $img = "<img src='assets/images/icons/ok.png'>";
                                                    else
                                                        $img = "";
                                                    echo "<tr>
                                                            <td>$autores->nome</td>
                                                            <td>$autores->descricao_tipo</td>
                                                            <td>$autores->ordenacao</td>
                                                            <td>$img</td>
                                                            <td>$autores->cpf</td>
                                                            <td>$autores->email</td>";
                                                    
													if(($autores->bool_apresentador == 1 || $trabalho["id_inscrito_responsavel"] != ID_USUARIO) )
                                                        echo"<td></td>";
                                                    else
                                                        echo "<td><a class='btn btn-danger' onClick='confirmaExcluir($autores->id_autor);''>Excluir Autor</a></td>";
                                                            
                                                            
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">                                   
                                    <form id="form_trabalho" name="form_trabalho" action="javascript:void(0);">
										<div class="col-md-6">
											<div class='form-group'>
												<label for='categoria'>Evento em que vai apresentar o trabalho*</label>
												<select class='form-control' id='categoria' name='categoria' required>
													
													<option></option>
													<option value=1 <?php if($trabalho["id_categoria"] == 1) echo "selected"; ?>>SEIC - Seminário de Iniciação Científica</option>
													<option value=2 <?php if($trabalho["id_categoria"] == 2) echo "selected"; ?>>SEXT - Seminário de Extensão</option>
													<option value=3 <?php if($trabalho["id_categoria"] == 3) echo "selected"; ?>>Mostra Pró-Ativa</option>
													<option value=6 <?php if($trabalho["id_categoria"] == 6) echo "selected"; ?>>Mostra Monitoria</option>
													<option value=7 <?php if($trabalho["id_categoria"] == 7) echo "selected"; ?>>Mostra PIBID</option>
													<option value=8 <?php if($trabalho["id_categoria"] == 8) echo "selected"; ?>>Mostra PET</option>
													<option value=9 <?php if($trabalho["id_categoria"] == 9) echo "selected"; ?>>I Mostra da Pós Graduação</option>

												</select>
												<p class="help-block"></p>
											</div>
											<div class="form-group">

												<input type="hidden" id="id_trabalho" value="<?=$id_trabalho;?>">
												
												<label for="area">Área de conhecimento</label>
												<select class="form-control" id="area" name="area" <?=$edicao;?> <?=$disabled;?>>
														<option>
														</option>
														<?php
														$stmt = $db->sql_query("SELECT *
														  FROM es_ufop_areas
														  ORDER BY descricao_area");
														foreach ($stmt as $grande_area) {
															if($trabalho["id_area"] == $grande_area->id_area)
																$select_area = "selected";
															else 
																$select_area = "";
															echo '<option value="'.$grande_area->id_area.'" '.$select_area.' >'.$grande_area->descricao_area.'</option>';
														}

														?>
												</select>
											</div>
											<div class="form-group">
												<label for="area_especifica">Área Específica</label>
												<select class="form-control" id="area_especifica" name="area_especifica" <?=$disabled;?> <?=$edicao;?>>
														<option>
														</option>
														<?php
															if($trabalho["id_area_especifica"]){
															echo '<option value="'.$trabalho["id_area_especifica"].'" selected >'.$trabalho["descricao_area_especifica"].'</option>';  
															} else {
															$stmt = $db->sql_query("SELECT *
															  FROM es_area_especifica
															  WHERE fgk_area = ?
															  ORDER BY descricao_area_especifica", array('fgk_area'=> $id_area));
															foreach ($stmt as $peq_area) {
																if($id_area_especifica == $peq_area->id)
																	$select_peqarea = "selected";
																else 
																	$select_peqarea = "";
																echo '<option value="'.$peq_area->id.'" '.$select_peqarea.' >'.$peq_area->descricao_area_especifica.'</option>';
															}
														}
													  
														?>
												</select>
											</div>
											<?php if($trabalho["id_categoria"] == 1) { ?>
												<div class="form-group">
													<label for="orgao_fomento">Órgão de fomento</label>
													<select class="form-control" id="orgao_fomento" name="orgao_fomento" required <?=$edicao;?>>
														<option>
														</option>
														<?php
														$stmt = $db->sql_query("SELECT *
														  FROM es_orgao_fomento
														  ORDER BY sigla");
														foreach ($stmt as $orgao) {
															 if($trabalho["id_orgao_fomento"] == $orgao->id)
																		$select_orgao = "selected";
																	else 
																		$select_orgao = "";
															echo '<option value="'.$orgao->id.'" '.$select_orgao.' >'.$orgao->sigla.' - '.$orgao->nome.'</option>';
														}

														?>
													</select>
													<p class="help-block"></p>
												</div>
												<?php } ?>
											</div>
										<?php if($trabalho["id_categoria"] == 1) { ?>
										<div class="col-md-6">
											<div class="form-group">
													<label for="aluno"> Número do Protocolo <a href="http://www.comitedeetica.ufop.br/" target="_blank">CEP</a></label>
													<input type="text" class="form-control" id="protocolo_cep" name = "protocolo_cep" value="<?=$trabalho["protocolo_cep"];?>" placeholder="Número do Protocolo do Comitê de Ética em Pesquisa" />
													<p class="help-block"></p>
											</div>
											<div class="form-group">
												<label for="aluno"> Número do Protocolo <a href="http://www.ceua.ufop.br/" target="_blank">CEUA</a></label>
												<input type="text" class="form-control" id="protocolo_ceua" name="protocolo_ceua" value="<?=$trabalho["protocolo_ceua"];?>" placeholder="Número do Protocolo do Comissão de Ética no Uso de Animais" />
												<p class="help-block"></p>
											</div>
											<div class="form-group">
												<label for="apoio_financeiro"> Apoio Financeiro</a></label>
												<input type="text" class="form-control" id="apoio_financeiro" name = 'apoio_financeiro' value="<?=$trabalho["apoio_financeiro"];?>"/>
												<p class="help-block"></p>
											</div>
		                                </div>
		                                <?php } ?>
		                            </div>
		                        </div>
                        
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                         <div class="form-group">
                                            <label for="titulo">Título</label>
                                            <textarea class="form-control" rows="2" id="titulo" <?=$disabled;?> ><?=$trabalho["titulo_enviado"];?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="palavras_chave">Palavras-Chave</label>
                                            <input type="text" class="form-control" id="palavras_chave" placeholder="" value="<?=$trabalho["palavras_chave_enviado"];?>"<?=$disabled;?>>
                                        </div>
										<?php
											if($trabalho["id_status"]  != TRABALHO_NAO_ENVIADO && $trabalho["id_status"]  != TRABALHO_SUBMETIDO && $trabalho["id_status"]  != TRABALHO_DESIGNADO  ){
										?>
                                        <div class="col-md-12">
                                            <div class="panel panel-danger"> 
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Resumo</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <br>
                                                    <ul class="nav nav-tabs">
														<li  class="active"><a data-toggle="tab" href="#1versao">1ª Versão</a></li>
														
                                                        <li><a data-toggle="tab" href="#revisado">Revisado</a></li>
                                                       
                                                        <li><a data-toggle="tab" href="#diferencas">Diferenças</a></li>
												
                                                    </ul>
                                                    <div class="tab-content">
														<div id="1versao" class="tab-pane fade">
                                                            <textarea id="after" cols="130" rows="30" onchange="updateDifference();" onkeyup="updateDifference();"><?=$trabalho["resumo_enviado"];?></textarea>
                                                        </div>
														
                                                        <div id="revisado" class="tab-pane fade in active">
                                                            <textarea id="before" cols="130" rows="30" onchange="updateDifference();" onkeyup="updateDifference();"><?=$trabalho["resumo_revisado"];?></textarea>
                                                        </div>
                                                        
                                                        <div id="diferencas" class="tab-pane fade">
                                                            <div id="difference" class="frameResults">&nbsp;</div>
                                                        </div>
														
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
											<?php } else { ?>
                                        <div class="form-group">
                                            <label for="resumo">Resumo</label>
                                            <textarea class="form-control" pattern=".{1300,2000}" rows="30" id="resumo" maxlength="2000" onkeyup="mostrarResultado(this.value,2000,'spcontando');contarCaracteres(this.value,2000,'sprestante')"<?=$disabled;?>><?=$trabalho["resumo_enviado"];?></textarea>
                                            <span id="spcontando" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Mínimo:</strong> 1300 <strong>Máximo:</strong> 2000</span><br />
                                            <span id="sprestante" style="font-family:Georgia;"></span>
                                        </div> 
                                        <?php
											} if ((ID_USUARIO == $trabalho["id_inscrito_responsavel"] && ($trabalho["id_status"] == TRABALHO_NAO_ENVIADO || $trabalho["id_status"] == TRABALHO_EM_EDICAO)) || TIPO_USUARIO == ADMINISTRADOR)
                                                $button_disabled = "";
                                            else 
                                                $button_disabled = "disabled";
                                        ?>
										<button id="enviar" class="btn btn-danger" <?=$disabled;?>>Salvar Alterações</button>
                                        <button id="enviar2" class="btn btn-success"<?=$disabled;?>>Submeter Resumo</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <script type="text/javascript">
				function confirmaExcluir(id) {
					var resposta = confirm("Deseja remover esse autor?");

					if (resposta == true) {
						window.location.href = "cancelar_autor.php?id_trabalho=<?=$id_trabalho?>&id="+id;
					}
				}
                    function mostrarResultado(box,num_max,campospan){
                        var contagem_carac = box.length;
                        if (contagem_carac != 0){
                            document.getElementById(campospan).innerHTML = contagem_carac + " caracteres digitados";
                            if (contagem_carac == 1){
                                document.getElementById(campospan).innerHTML = contagem_carac + " caracter digitado";
                            }
                            if (contagem_carac >= num_max){
                                document.getElementById(campospan).innerHTML = "Limite de caracteres excedido!";
                            }
                        }else{
                            document.getElementById(campospan).innerHTML = "Ainda não temos nada digitado..";
                        }
                    }
                    function contarCaracteres(box,valor,campospan){
                        var conta = valor - box.length;
                        document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
                        if(box.length >= valor){
                            document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
                            document.getElementById("campo").value = document.getElementById("campo").value.substr(0,valor);
                        }   
                    }
                    
                </script>

<?php
    include "footer.php";
 }
?>
<script type="text/javascript">
$('#myModal').on('shown.bs.modal', function () {
    $('#cpf_autor').focus();
})  
    $(function(){
		<?php if($trabalho["id_status"] != TRABALHO_NAO_ENVIADO && $trabalho["id_status"] != TRABALHO_SUBMETIDO){ ?>
         updateDifference();
		<?php } ?>
        <?php 
        if(($trabalho["id_status"] != TRABALHO_NAO_ENVIADO && $trabalho["id_status"] != TRABALHO_EM_EDICAO))
            echo "
                $('#form_trabalho input').attr('disabled', 'disabled');
                $('#form_trabalho select').attr('disabled', 'disabled');
                $('#form_trabalho textarea').attr('disabled', 'disabled');"
        ?>
        $('#area').change(function(){
            if( $(this).val() ) {
                /*$('#cidade').hide();
                $('.carregando').show();*/
                $.getJSON('area_ajax.php?search=',{area: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].id_area_especifica + '">' + j[i].nome + '</option>';
                    }
                    $('#area_especifica').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#area_especifica').html('<option value="" placeholder="– Escolha uma área de conhecimento –"> </option>');
            }
        });

     
    });
</script>
    <script src="http://cdn.datatables.net/plug-ins/1.10.8/api/fnStandingRedraw.js"></script>
    <script src="assets/js/pages/exibir_trabalho.js"></script>
</body>
</html>