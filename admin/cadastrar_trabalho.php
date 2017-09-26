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

    $categoria_trabalho = filter_input(INPUT_GET, "categoria");
?>   
<style>
select[readonly] {
  background: #eee; 
  pointer-events: none;
  touch-action: none;
}
</style>
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
        <div id="main-wrapper">
            <div class="row">
				<form id="form_trabalho" name="form_trabalho" action="javascript:void(0)">
				<div class="col-md-12">
					<div class="panel panel-white">
                        <div class="panel-body">
						<div class="panel-heading clearfix">
							<h4 class="panel-title">Termo de Aceite para Inclusão do Trabalho no Repositório do SISBIN</h4>
						</div>
						<div class="form-group">
							<div class="text-justify">Na qualidade de titular dos direitos de autor do trabalho, por mim submetido, autorizo o Sistema de Bibliotecas e Informação
							da Universidade Federal de Ouro Preto a disponibilizar a obra no Repositório Institucional da UFOP gratuitamente, sob uma <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/" target ="_blank">licença Creative Commons 4.0</a>,
							que permite copiar, distribuir e transmitir o trabalho em qualquer suporte ou formato desde que sejam citados a autoria e o licenciante. 
							Está licença não permite o uso para fins comerciais nem  adaptações da obra.</div>
						</div>
						<div >
							<div class="checkbox">
								<label>
									<input type="checkbox" name="autorizacao_repositorio" id="autorizacao_repositorio" checked="checked" > Autorizo que meu trabalho seja disponibilizado no Repositório da UFOP
								</label>
							</div>
						</div>

						</div>
					</div>
				</div>
                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-body">
                           
                                
                                <div id="sucesso" class="modal fade modal" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Encontro de Saberes</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Trabalho enviado com sucesso.</p>
                                                <button type="button" class="btn btn-success" id="btn_sim">Fechar</button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <input type="hidden" name="tipo_autor_responsavel" id="tipo_autor_responsavel" value='1'>
                                <input type="hidden" name="apresentador_responsavel" id="apresentador_responsavel" value='1'>
                                <div class="form-group">
                                    <label for="cpf">CPF do Responsável*</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" value="<?=CPF_USUARIO;?>" readonly>
                                    <p class="help-block"></p>
                                </div>
                                <div class="form-group">
                                    <label for="nome">Responsável*</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="<?=NOME_USUARIO;?>" readonly>
                                    <p class="help-block"></p>
                                </div>
								<div class="form-group">
									<label for="instituicao">Instituição*</label>
									<select class="form-control" id="instituicao" name="instituicao" readonly="readonly" tabindex="-1">
										<?php
										$stmt = $db->sql_query("SELECT *
										  FROM es_instituicao 
										  ORDER BY nome");
										

										foreach ($stmt as $instituicao) {
											if($instituicao->id == INSTITUICAO_USUARIO)
												$selected_instituicao = "selected";
											else
												$selected_instituicao = "";
											echo '<option value="'.$instituicao->id.'" '.$selected_instituicao.'>'.$instituicao->nome.'</option>';
										}
										?>
									</select>
									<p class="help-block"></p>
								</div>
								<div class='form-group'>
                                    <label for='categoria'>Evento em que vai apresentar o trabalho*</label>
                                    <select class='form-control' id='categoria' name='categoria' readonly="readonly" tabindex = '-1' required>
										<option></option>
                                        <option value=1 <?php if ($categoria_trabalho == 1) echo "selected"; ?>>SEIC - Seminário de Iniciação Científica</option>
                                        <option value=2 <?php if ($categoria_trabalho == 2) echo "selected"; ?>>SEXT - Seminário de Extensão</option>
										<option value=3 <?php if ($categoria_trabalho == 3) echo "selected"; ?>>Mostra Pró-Ativa</option>
										<option value=6 <?php if ($categoria_trabalho == 6) echo "selected"; ?>>Mostra Monitoria</option>
										<option value=7 <?php if ($categoria_trabalho == 7) echo "selected"; ?>>Mostra PIBID</option>
										<option value=9 <?php if ($categoria_trabalho == 9) echo "selected"; ?>>Mostra da Pós Graduação</option>
										<option value=10 <?php if ($categoria_trabalho == 10) echo "selected"; ?>>Mostra de Material Didático-Pedagógico e Tecnológico</option>

                                    </select>
                                    <p class="help-block"></p>
                                </div>
                                <?php if ($categoria_trabalho == 1 || $categoria_trabalho == 9) : ?>
	                                <div class="form-group">
										<label for="programa_ic">Programa de Iniciação Científica</label>
										<select class="form-control" id="programa_ic" name="programa_ic">
											<option value =0>Não possui Programa de Iniciação Científica</option>
											<?php
											$stmt = $db->sql_query("SELECT *
											  FROM es_programa_ic 
											  ORDER BY sigla ASC");
											

											foreach ($stmt as $programa) {
												
												echo '<option value="'.$programa->id.'">'.$programa->sigla.' - '.$programa->nome.'</option>';
											}
											?>
										</select>
										<p class="help-block"></p>
									</div>
								<?php endif; ?>
                                <div class="form-group">
									<label for="apoio_financeiro"> Apoio Financeiro</a></label>
									<input type="text" class="form-control" id="apoio_financeiro" name = 'apoio_financeiro' placeholder="Só preencha se possuir apoio financeiro" />
									<p class="help-block"></p>
								</div>
								 
                                
                            </div>
                        </div>
                </div>

                <div class="col-md-6">
                	<?php if ($categoria_trabalho == 1 || $categoria_trabalho == 9) : ?>
                		
                    <div class="panel panel-white">
                        <div class="panel-body">
                            
                            <div class="form-group">
                                <label for="area">Área de conhecimento*</label>
                                <select class="form-control" id="area" name="area" required>
                                    <option>
                                    </option>
                                    <?php
                                    $stmt = $db->sql_query("SELECT *
                                      FROM es_ufop_areas WHERE bool_interno = 0
                                      ORDER BY descricao_area ");
                                    foreach ($stmt as $grande_area) {
                                        echo '<option value="'.$grande_area->id_area.'"  >'.$grande_area->descricao_area.'</option>';
                                    }

                                    ?>
                                </select>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="area_especifica">Área Específica*</label>
                                <select class="form-control" id="area_especifica" name="area_especifica" required>
                                    <option>
                                    </option>
                                </select>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label for="orgao_fomento">Órgão de fomento*</label>
                                <select class="form-control" id="orgao_fomento" name="orgao_fomento" required>
                                    <option>
                                    </option>
                                    <?php
                                    $stmt = $db->sql_query("SELECT *
                                      FROM es_orgao_fomento
                                      ORDER BY sigla");
                                    foreach ($stmt as $orgao) {
                                        echo '<option value="'.$orgao->id.'"  >'.$orgao->sigla.' - '.$orgao->nome.'</option>';
                                    }

                                    ?>
                                </select>
                                <p class="help-block"></p>
                            </div>
							 <div class="form-group">
                                    <label for="aluno"> Número do Protocolo <a href="http://www.comitedeetica.ufop.br/" target="_blank">CEP</a></label>
                                    <input type="text" class="form-control" id="protocolo_cep" name = "protocolo_cep" placeholder="Número do Protocolo do Comitê de Ética em Pesquisa" />
                                    <p class="help-block"></p>
							</div>
							<div class="form-group">
								<label for="aluno"> Número do Protocolo <a href="http://www.ceua.ufop.br/" target="_blank">CEUA</a></label>
								<input type="text" class="form-control" id="protocolo_ceua" name="protocolo_ceua" placeholder="Número do Protocolo do Comissão de Ética no Uso de Animais" />
								<p class="help-block"></p>
							</div>
							
                        </div>
                    </div>

                <?php endif; ?>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <h3> Demais Autores <small>(Caso haja mais de 20 autores favor enviar um e-mail para encontrodesaberes@ufop.br)</small></h3>

                            <div class="form-group col-md-12">
                                <label for="qtdautor">Digite a quantidade de autores, que além de você colaboraram para este resumo (inclusive orientador, caso exista)</label>
                                <input type="number" min=0 max=20 class="form-control" id="qtdautor" name="qtdautor" required>
                                <p class="help-block"></p>
                            </div>

                            <div id="varia"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div class="form-group">
                            <label for="titulo">Título</label>
                            <textarea class="form-control" rows=2 id="titulo" name="titulo" placeholder="" required></textarea>
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                            <label for="palavras_chave">Palavras-Chave</label>
                            <input type="text" class="form-control" id="palavras_chave" name="palavras_chave" placeholder="">
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                            <label for="resumo">Resumo</label>
                            <textarea class="form-control" pattern=".{1300,2000}" rows="30" id="resumo" name="resumo" maxlength="2000" onkeyup="mostrarResultado(this.value,2000,'spcontando');contarCaracteres(this.value,2000,'sprestante')"><?php echo ( isset($resumo_enviado) ? $resumo_enviado : "" );?></textarea>
                            <span id="spcontando" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Mínimo:</strong> 1300 <strong>Máximo:</strong> 2000</span><br />
                            <span id="sprestante" style="font-family:Georgia;"></span>
                            <p class="help-block"></p>
                        </div> 

                        <button type="submit" id="enviar" class="btn btn-danger">Salvar Alterações</button>
                        <button type="submit" id="enviar2" class="btn btn-success" >Submeter Resumo</button>
                    
                    </div>
                </div>
				</form>
            </div>

                

        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <script type="text/javascript">
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
$(function(){
    $('#area').change(function(){
        if( $(this).val() ) {
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
    })
});
</script>
<script src="../js/jquery-validation/jquery.validate.min.js"></script>

<script type="text/javascript">        
    $(function() {
        function excluir() {
           $(this).parent().parent().remove();
        }
        function validaCPF(value){
            value = jQuery.trim(value);

            value = value.replace('.','');
            value = value.replace('.','');
            cpf = value.replace('-','');
            while(cpf.length < 11) cpf = "0"+ cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
            var a = [];
            var b = new Number;
            var c = 11;
            for (i=0; i<11; i++){
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
            }
            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
            b = 0;
            c = 11;
            for (y=0; y<10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

            var retorno = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

            return retorno;

        };
        $("#qtdautor").change(function() {
            $("#varia").empty();
            for (i = 1; i <= this.value; i++) {
                var div_autor = "<h4> Autor "+i+" </h4><div class='form-group col-md-3'><label for='cpf_autor"+i+"'>CPF</label><input type='text' class='form-control cpf' id='cpf_autor"+i+"' name='cpf_autor"+i+"' data-mask='000.000.000-00' data-required></div>";
                div_autor += "<div class='form-group col-md-5'><label for='nome_autor"+i+"'>Nome</label><input type='text' class='form-control' id='nome_autor"+i+"' name = 'nome_autor"+i+"'data-required></div>";
                div_autor += "<div class='form-group col-md-4'><label for='email_autor"+i+"'>E-mail</label><input type='email' class='form-control' id='email_autor"+i+"' name = 'email_autor"+i+"' data-required></div>";
                div_autor += "<div class='form-group col-md-5'><label for='instituicao_autor"+i+"'>Instituição</label><select class='form-control' id='instituicao_autor"+i+"' name='instituicao_autor"+i+"' data-required><option></option>";
                div_autor += "<?php $stmt = $db->sql_query('SELECT * FROM es_instituicao ORDER BY nome'); foreach ($stmt as $instituicao) { echo '<option value=\"'.$instituicao->id.'\" >'.$instituicao->nome.'</option>'; } ?></select> </div>";
                div_autor += "<div class='form-group col-md-4'><label for='tipo_autor"+i+"'>Tipo de Autor</label><select class='form-control' id='tipo_autor"+i+"' name='tipo_autor"+i+"' data-required><option></option>";
                div_autor += "<?php $stmt = $db->sql_query('SELECT * FROM es_tipo_autor');foreach ($stmt as $autor) {echo '<option value=\"'.$autor->id_tipo_autor.'\"  >'.$autor->descricao_tipo.' </option>';}?></select></div>";
                div_autor += "<div class='form-group col-md-3'><label for='apresentador"+i+"'>Apresentador</label><select class='form-control' id='apresentador"+i+"' name='apresentador"+i+"' data-required><option value=0>Não</option><option value=1>Sim</option></select></div>";
                $("#varia").append(div_autor).clone(true);
                $('#cpf_autor'+i).mask('000.000.000-00');
                $('#cpf_autor'+i).prop('required',true);
                $(".btnExcluir").bind("click", excluir);
                $('#cpf_autor'+i).change(function(){
                    var cpf_responsavel = $("#cpf").val();
                    var cpf = this.value;
                    if(!validaCPF(this.value)){
                        if( cpf.length > 0 ){      
                            BootstrapDialog.show({
                                    type: BootstrapDialog.TYPE_DANGER,
                                    title: 'Atenção',
                                    message: 'CPF inválido!'
                            });
                            $('.cpf').val(" "); 
                        }
                    }
                    if(cpf_responsavel == cpf){
                         BootstrapDialog.show({
                                    type: BootstrapDialog.TYPE_DANGER,
                                    title: 'Atenção',
                                    message: 'CPF já está como responsável!'
                            });
                            $('.cpf').val(" "); 
                    }
                   
                    
                    /*$.ajax({
						url: "verifica_aluno.php",
						type: "post",
						data: "cpf="+this.value,
						success: function( data )
						{
							if (data == "aluno") {
								$('.cpf').val('');
								BootstrapDialog.show({
									type: BootstrapDialog.TYPE_DANGER,
									title: 'Atenção',
									message: 'Esse cpf é de um aluno da UFOP que não pode ser autor de trabalhos externos!'
								});
							} 
						}
					});*/

                                
                })
            }
        });
    });
</script>
<script src="assets/js/pages/cadastrar_trabalho.js"></script>

</body>
</html>