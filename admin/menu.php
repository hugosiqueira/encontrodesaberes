<?php
date_default_timezone_set('America/Los_Angeles');
if ( $_SESSION['logado'] === true ) {



	$dados_inscrito = $db->sql_query("SELECT es_inscritos.*, es_inscritos.id as id_inscrito,
										es_instituicao.nome as nome_instituicao, es_instituicao.sigla as sigla_instituicao,
										es_inscritos_tipos.descricao_tipo as tipo_inscricao, es_inscritos_tipos.id_tipo_inscrito,
										es_inscritos_boletos.link as link_boleto, es_inscritos_boletos.status as status_boleto, es_inscritos_boletos.data_vencimento
										FROM es_inscritos_boletos
										right JOIN es_inscritos ON es_inscritos_boletos.fgk_inscrito = es_inscritos.id
										left JOIN es_inscritos_tipos ON es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
										left JOIN es_instituicao ON es_instituicao.id = es_inscritos.fgk_instituicao
										WHERE es_inscritos.fgk_evento = ? AND es_inscritos.cpf = ?", array('es_inscritos.fgk_evento' => EVENTO_ATUAL, 'es_inscritos.cpf' => CPF_USUARIO));
	foreach ($dados_inscrito as $inscrito) {
		$id_inscrito = $inscrito->id_inscrito;
		$nome = $inscrito->nome;
		$departamento = $inscrito->departamento;
		$curso = $inscrito->curso;
		$salt_atual = $inscrito->salt;
		$matricula = $inscrito->matricula;
		$email = $inscrito->email;
		$email_alternativo = $inscrito->email_alternativo;
		$data_nascimento = $inscrito->data_nascimento;
		$telefone = $inscrito->telefone;
		$telefone_celular = $inscrito->telefone_celular;
		$endereco = $inscrito->endereco;
		$bairro = $inscrito->bairro;
		$numero = $inscrito->numero;
		$complemento = $inscrito->complemento;
		$cidade = $inscrito->cidade;
		$estado = $inscrito->estado;
		$cep = $inscrito->cep;
		$mobilidade_ano_passado = $inscrito->mobilidade_ano_passado;
		$mobilidade_ano_atual = $inscrito->mobilidade_ano_atual;
		$data_vencimento = $inscrito->data_vencimento;
		$link_boleto = $inscrito->link_boleto;
		$conta_ativada = $inscrito->conta_ativada;
		$status_boleto = $inscrito->status_boleto;
		$tipo_inscricao = $inscrito->tipo_inscricao;
		@$id_tipo_inscrito = $inscrito->id_tipo_inscrito;
		$nome_instituicao = $inscrito->nome_instituicao;
		$sigla_instituicao = $inscrito->sigla_instituicao;
		@$bool_revisor = $inscrito->bool_revisor;
		@$bool_coordenador = $inscrito->bool_coordenador;
		@$bool_inscricao_paga = $inscrito->bool_inscricao_paga;

	}
	

?>
			<div class="horizontal-bar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    
                    <ul class="menu accordion-menu">   
                    	<?php if(CONTA_ATIVADA == 1){ ?> 
                        <li><a href="index.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>In&iacute;cio</p></a></li>
                        <li><a href="perfil.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>Meu Cadastro</p></a></li>
                        <li><a href="meus_resumos.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-edit"></span><p>Trabalhos Submetidos</p><span class="arrow"></span></a></li>
                        <li class="droplink">
                        	<a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-upload"></span><p>Submeter Trabalhos</p><span class="arrow"></span></a>
                        	<ul class="sub-menu">
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho.php?categoria=1">Seminário de Iniciação Científica</a></li>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho_sext.php">Seminário de Extensão</a></li>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/mobilidade_cadastro.php">Seminário de Internacionalização</a></li>
                        		<?php } if((TIPO_USUARIO  == ALUNO_UFOP )|| TIPO_USUARIO == ADMINISTRADOR || ( TIPO_USUARIO == PROFESSOR_UFOP) || ( TIPO_USUARIO == TECNICO_UFOP)){ ?>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho.php?categoria=3">Mostra Pró-Ativa</a></li>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho.php?categoria=7">Mostra Pibid</a></li>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho.php?categoria=6">Mostra Monitoria</a></li>
                        		<li><a href="http://encontrodesaberes.ufop.br/admin/cadastrar_trabalho.php?categoria=9">Mostra da Pós Graduação</a></li>
                        		<li><a href="#">Mostra de Material Didático</a></li>
                        		<?php } ?>
                        	</ul>
                        </li>
                        <li><a href="correcoes.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-edit"></span><p>Corrigir Trabalhos</p><span class="arrow"></span></a></li>
                       
                        
                        <?php } if(BOOL_COORDENADOR || TIPO_USUARIO == ADMINISTRADOR){ ?>
                        
                        <li><a href="designar_avaliadores.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-hand-up"></span><p>Designar Avaliadores</p><span class="arrow"></span></a></li>
                        <?php } if((TIPO_USUARIO == ADMINISTRADOR || BOOL_COORDENADOR || BOOL_REVISOR )) { ?>
                        <li><a href="revisao_trabalhos.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-file"></span><p>Revisar Trabalho</p><span class="arrow"></span></a></li>
                        <?php } if(TIPO_USUARIO == ADMINISTRADOR || BOOL_COORDENADOR ){ ?>
                        <li class="droplink">
                        	<a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-print"></span><p>Emitir Pareceres</p><span class="arrow"></span></a>
                        	<ul class="sub-menu">
                        		<li><a href="parecer.php">Primeiro Parecer</a></li>
                                <li><a href="parecer_final.php">Parecer Final</a></li>
                                
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a href="duvidas.php" class="waves-effect waves-button"><span class="menu-icon  glyphicon glyphicon-question-sign"></span><p>Dúvidas</p></a></li>
                    </ul>
                </div><!-- Page Sidebar Inner -->
            </div><!-- Page Sidebar -->
