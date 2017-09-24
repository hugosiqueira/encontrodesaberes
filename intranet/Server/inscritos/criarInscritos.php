<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	
	function safeHexToString($input){
		if(strpos($input, '0x') === 0){
			$input = substr($input, 2);
		}
		return hex2bin($input);
	}
	$json = $_REQUEST['inscrito'];

	$dados = json_decode($json);

	$fgk_evento 				= $_SESSION['id_evento_atual'];
	
	$fgk_instituicao 		= $dados->fgk_instituicao;
	$cpf 					= $dados->cpf;
	$fgk_tipo 				= $dados->fgk_tipo;
	$autoriza_envio_emails 	= $dados->autoriza_envio_emails;
	$bool_inscricao_paga	= $dados->bool_inscricao_paga;
	$fgk_departamento 		= $dados->fgk_departamento;
	$departamento 			= $dados->departamento;
	$fgk_curso 				= $dados->fgk_curso;
	$curso 					= $dados->curso;
	$email 					= $dados->email;
	$matricula 				= $dados->matricula;
	$bool_coordenador 		= $dados->bool_coordenador;
	$nome 					= $dados->nome;
	$cep 					= $dados->cep;
	$cidade 				= $dados->cidade;
	$bairro 				= $dados->bairro;
	$endereco 				= $dados->endereco;
	$numero 				= $dados->numero;
	$estado 				= $dados->estado;
	$telefone 				= $dados->telefone;
	$telefone_celular 		= $dados->telefone_celular;
	$datahora_registro 		= $dados->datahora_registro;
	// $link_boleto 			= $dados->link_boleto;
	$password	 			= $dados->password;
	$email_alternativo		= $dados->email_alternativo;
	$complemento			= $dados->complemento;
	$mobilidade_ano_atual	= $dados->mobilidade_ano_atual;
	$mobilidade_ano_passado	= $dados->mobilidade_ano_passado;
	$bool_temp				= $dados->bool_temp;
	$bool_revisor			= $dados->bool_revisor;
	$bool_monitoria			= $dados->bool_monitoria;
	
	if($bool_coordenador!='0'){		
		$fgk_area_coordenacao 	= $dados->fgk_area_coordenacao;
	}
	else{
		$fgk_area_coordenacao = 0;
	}		
	
	$password = trim(mcrypt_decrypt(MCRYPT_DES, "seic2015", safeHexToString($password), MCRYPT_MODE_ECB));
	
	$salt = base64_encode($cpf);
	$password = crypt($password, $salt);
	
	//verifica se já existe este cpf
	$queryString = "
		SELECT cpf FROM es_inscritos WHERE cpf = '$cpf' AND fgk_evento = $fgk_evento";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultados = mysqli_num_rows($query);
	if ($resultados > 0){
		echo json_encode(array(
			"success" => false,
			"msg" => "Este CPF já está em uso no evento selecionado."
		));
		exit;
	}
	
	$query = sprintf("
		INSERT INTO es_inscritos
		(	fgk_evento, fgk_instituicao, fgk_tipo, cpf, autoriza_envio_emails, conta_ativada, fgk_departamento, departamento, fgk_curso, curso, email, matricula, nome, cep, cidade, bairro, endereco, numero, complemento, estado, telefone, telefone_celular, datahora_registro, email_alternativo, password, salt, mobilidade_ano_atual, mobilidade_ano_passado, bool_coordenador, fgk_area_coordenacao, bool_temp, bool_revisor, bool_monitoria)
		values
		(	%d, %d, %d, '%s', %d, 1, '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %d, %d, %d, %d, %d, %d)",
			mysqli_real_escape_string($mysqli,$fgk_evento),
			mysqli_real_escape_string($mysqli,$fgk_instituicao),
			mysqli_real_escape_string($mysqli,$fgk_tipo),
			mysqli_real_escape_string($mysqli,$cpf),
			mysqli_real_escape_string($mysqli,$autoriza_envio_emails),
			// mysqli_real_escape_string($mysqli,$bool_inscricao_paga),
			mysqli_real_escape_string($mysqli,$fgk_departamento),
			mysqli_real_escape_string($mysqli,$departamento),
			mysqli_real_escape_string($mysqli,$fgk_curso),
			mysqli_real_escape_string($mysqli,$curso),
			mysqli_real_escape_string($mysqli,$email),
			mysqli_real_escape_string($mysqli,$matricula),
			mysqli_real_escape_string($mysqli,$nome),
			mysqli_real_escape_string($mysqli,$cep),
			mysqli_real_escape_string($mysqli,$cidade),
			mysqli_real_escape_string($mysqli,$bairro),
			mysqli_real_escape_string($mysqli,$endereco),
			mysqli_real_escape_string($mysqli,$numero),
			mysqli_real_escape_string($mysqli,$complemento),
			mysqli_real_escape_string($mysqli,$estado),
			mysqli_real_escape_string($mysqli,$telefone),
			mysqli_real_escape_string($mysqli,$telefone_celular),
			mysqli_real_escape_string($mysqli,$datahora_registro),
			mysqli_real_escape_string($mysqli,$email_alternativo),
			mysqli_real_escape_string($mysqli,$password),
			mysqli_real_escape_string($mysqli,$salt),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_atual),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_passado),
			mysqli_real_escape_string($mysqli,$bool_coordenador),
			mysqli_real_escape_string($mysqli,$fgk_area_coordenacao),
			mysqli_real_escape_string($mysqli,$bool_temp),
			mysqli_real_escape_string($mysqli,$bool_revisor),
			mysqli_real_escape_string($mysqli,$bool_monitoria)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg" => "Novo inscrito registrado com sucesso."
	));
?>