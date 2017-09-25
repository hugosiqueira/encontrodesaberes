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

	$usuario = getDados($db, ID_USUARIO);

    if(TIPO_USUARIO == ALUNO_UFOP || TIPO_USUARIO == PROFESSOR_UFOP)
        $disabled = "disabled";
    else
        $disabled = "";


?> 
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
<div id="alterar_senha" class="modal fade modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Alterar senha</h4>
			</div>
			<div class="modal-body">
				<form id="form_senha" action="javascript:void(0)">
					<div class="form-group">
						<label for="nome">Senha atual</label>
						<input type="hidden" id="id_inscrito" name="id_inscrito" value="<?=$usuario["id_inscrito"];?>"/>
						<input type="password" class="form-control" id="senha_atual" name="senha_atual" >
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="nome">Nova senha</label>
						<input type="password" class="form-control" id="senha" name="senha" >
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="nome">Repita sua nova senha</label>
						<input type="password" class="form-control" id="csenha" name="csenha" >
						<p class="help-block"></p>
					</div>
				</form>
			</div>
			<div class = "modal-footer">
				<button id="btn-alterar-senha" class="btn btn-success btn200">Alterar Senha</button>
				<button class="btn btn-danger btn200" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
            <div class="page-inner">
				
                <div class="page-title">
					<div class="container">
						<h3>Encontro de Saberes</h3>
					</div>
                    <div class="page-breadcrumb container">
						<ol class="breadcrumb">
						<li><a href="index.php">Início</a></li>
							<li class="active">Atualizar Dados Pessoais</li>
						</ol>
					</div>
                </div>
			<form id="form_perfil" action="javascript:void(0)">
			<div id="main-wrapper" >

				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-white">
							<div class="panel-heading clearfix">
								<h4 class="panel-title">Dados Pessoais</h4>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="nome">Nome Completo</label>
									<input type="text" class="form-control" id="nome" name="nome" value="<?=$usuario["nome"];?>" >
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="cpf">CPF</label>
									<input type="text" class="form-control" id="cpf" data-mask="000.000.000-00" name="cpf" value="<?=$usuario["cpf"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="telefone">Telefone</label>
									<input type="tel" class="form-control" data-mask="(00) 0000-00000" id="telefone" name ="telefone" value="<?=$usuario["telefone"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="telefone_celular">Celular</label>
									<input type="tel" class="form-control" data-mask="(00) 0000-00000" id="telefone_celular" name ="telefone_celular" value="<?=$usuario["telefone_celular"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="email">E-mail Principal</label>
									<input type="email" class="form-control" name="email" id="email" value="<?=$usuario["email"];?>" readonly>
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="emaila">E-mail Alternativo</label>
									<input type="email" class="form-control" name="emaila" id="emaila" value="<?=$usuario["email_alternativo"];?>" >
									<p class="help-block"><i>Preencha um e-mail alternativo, caso o principal seja do Hotmail, ou da UFOP</i></p>
								</div>
								<div class="form-group">
									<label for="data_nascimento">Data de Nascimento</label>
									<input type="text" class="form-control" name="data_nascimento" id="data_nascimento" data-mask="00/00/0000" value="<?=converteDataPort($usuario["data_nascimento"]);?>" >
									<p class="help-block"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-white">
							<div class="panel-heading clearfix">
								<h4 class="panel-title">Endereço</h4>
							</div>
							<div class="panel-body">		
								<div class="form-group">
									<label for="endereco">Rua</label>
									<input type="text" class="form-control" id="endereco" name ="endereco" value="<?=$usuario["endereco"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="numero">Número</label>
									<input type="text" class="form-control" id="numero" name ="numero" value="<?=$usuario["numero"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="complemento">Complemento</label>
									<input type="text" class="form-control" id="complemento" name ="complemento" value="<?=$usuario["complemento"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="bairro">Bairro</label>
									<input type="text" class="form-control" id="bairro" name ="bairro" value="<?=$usuario["bairro"];?>">
									<p class="help-block"></p>
								</div>

								<div class="form-group">
									<label for="cidade">Cidade</label>
									<input type="text" class="form-control" id="cidade" name ="cidade" value="<?=$usuario["cidade"];?>">
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="uf"  >Estado</label>
									<select class="form-control" id="uf" name ="uf" required>
										<option>Selecione seu estado</option>
										<?php
										$sql_estados = $db->sql_query("SELECT uf, descricao_estado FROM desk_estados");
										foreach ($sql_estados as $key) {
											if($key->uf == strtoupper($usuario["estado"]))
												echo "<option value=".$key->uf." selected>".$key->descricao_estado."</option>\n";
											else 
												echo "<option value=".$key->uf.">".$key->descricao_estado."</option>\n";
										}
										?>
									</select>
									<p class="help-block"></p>
								</div>
								<div class="form-group">
									<label for="cep">CEP</label>
									<input type="text" class="form-control" name="cep" id="cep" data-mask="00000-000" value="<?=$usuario["cep"];?>" >
									<p class="help-block"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="panel panel-white">
							<div class="panel-heading clearfix">
								<h4 class="panel-title">Dados Acadêmicos</h4>
							</div>
							
							<div class="panel-body">
								<div class="col-md-6">
									<div class="form-group">
										<label for="instituicao">Instituição</label>
										<select class="form-control" id="fgk_instituicao" name ="fgk_instituicao" required>
										<option>Selecione sua Instituição</option>
										<?php
										$sql_instituicao = $db->sql_query("SELECT nome, id FROM es_instituicao");
										foreach ($sql_instituicao as $key) {
											if($key->id == $usuario["fgk_instituicao"])
												echo "<option value=".$key->id." selected>".$key->nome."</option>\n";
											else 
												echo "<option value=".$key->id.">".$key->nome."</option>\n";
										}
										?>
									</select>
									</div>
									<div class="form-group">
										<label for="curso">Curso</label>
										<input type="text" class="form-control" id="curso" name="curso" value="<?=$usuario["curso"];?>">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="departamento">Departamento</label>
										<input type="text" class="form-control" id="departamento" name="departamento" value="<?=$usuario["departamento"];?>">
									</div>
									<div class="form-group">
										<label for="matricula">Matrícula</label>
										<input type="text" class="form-control" id="matricula" name="matricula" value="<?=$usuario["matricula"];?>">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "col-md-12 form-group">
					<div class="form-group">
						<button id="enviar" class="btn btn-success btn200">Atualizar Cadastro</button>
						<button onClick="$('#alterar_senha').modal('show');" class="btn btn-danger btn200">Alterar Senha</button>
					</div>
				</div>
			<div>

		</form>  
								
				
<?php
    include "footer.php";
?>
    
    <script src="assets/js/pages/perfil.js"></script>
    </body>
</html>
<?php } ?>