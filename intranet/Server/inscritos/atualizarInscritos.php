<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_inscrito 			= $_REQUEST['id'];
	$fgk_instituicao 		= $_REQUEST['fgk_instituicao'];
	$fgk_tipo 				= $_REQUEST['fgk_tipo'];
	$email 					= $_REQUEST['email'];
	$matricula 				= $_REQUEST['matricula'];
	$nome 					= $_REQUEST['nome'];
	$cep 					= $_REQUEST['cep'];
	$cidade 				= $_REQUEST['cidade'];
	$bairro 				= $_REQUEST['bairro'];
	$endereco 				= $_REQUEST['endereco'];
	$numero 				= $_REQUEST['numero'];
	$estado 				= $_REQUEST['estado'];
	$telefone 				= $_REQUEST['telefone'];
	$telefone_celular 		= $_REQUEST['telefone_celular'];
	$email_alternativo 		= $_REQUEST['email_alternativo'];
	$complemento 			= $_REQUEST['complemento'];
	$bool_revisor 			= $_REQUEST['bool_revisor'];
	$bool_monitoria 			= $_REQUEST['bool_monitoria'];

	if(isset($_REQUEST['fgk_departamento'])){
		$departamento = "";
		$fgk_departamento= $_REQUEST['fgk_departamento'];
	}
	else{
		$departamento = $_REQUEST['departamento'];
		$fgk_departamento = "";
	}
	if(isset($_REQUEST['fgk_curso'])){
		$curso = "";
		$fgk_curso= $_REQUEST['fgk_curso'];
	}
	else{
		$curso = $_REQUEST['curso'];
		$fgk_curso = "";
	}
	$bool_coordenador 	= $_REQUEST['bool_coordenador'];
	if($bool_coordenador!='0'){
		$fgk_area_coordenacao 	= $_REQUEST['fgk_area_coordenacao'];
	}
	else{
		$fgk_area_coordenacao = 0;
	}
	if(isset($_REQUEST['mobilidade_ano_atual']))
		$mobilidade_ano_atual 	= $_REQUEST['mobilidade_ano_atual'];
	else
		$mobilidade_ano_atual = 0;
	if(isset($_REQUEST['mobilidade_ano_passado']))
		$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
	else
		$mobilidade_ano_passado = 0;
	if(isset($_REQUEST['bool_inscricao_paga']))
		$bool_inscricao_paga 	= $_REQUEST['bool_inscricao_paga'];
	else
		$bool_inscricao_paga = 0;
	if(isset($_REQUEST['autoriza_envio_emails']))
		$autoriza_envio_emails	= $_REQUEST['autoriza_envio_emails'];
	else
		$autoriza_envio_emails = 0;
	if(isset($_REQUEST['bool_temp']))
		$bool_temp	= $_REQUEST['bool_temp'];
	else
		$bool_temp = 0;



	$query = sprintf("
		UPDATE es_inscritos
		SET fgk_instituicao = %d,
			fgk_tipo = %d,
			fgk_area_coordenacao = %d,
			autoriza_envio_emails = %d,
			fgk_departamento = '%s',
			departamento = '%s',
			fgk_curso = %d,
			curso = '%s',
			email = '%s',
			matricula = '%s',
			nome = '%s',
			cep = '%s',
			cidade = '%s',
			bairro = '%s',
			endereco = '%s',
			numero = %d,
			complemento = '%s',
			estado = '%s',
			telefone = '%s',
			telefone_celular = '%s',
			email_alternativo = '%s',
			mobilidade_ano_atual = %d,
			mobilidade_ano_passado = %d,
			bool_coordenador = %d,
			bool_temp = %d,
			bool_revisor = %d,
			bool_monitoria = %d
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$fgk_instituicao),
			mysqli_real_escape_string($mysqli,$fgk_tipo),
			mysqli_real_escape_string($mysqli,$fgk_area_coordenacao),
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
			mysqli_real_escape_string($mysqli,$email_alternativo),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_atual),
			mysqli_real_escape_string($mysqli,$mobilidade_ano_passado),
			mysqli_real_escape_string($mysqli,$bool_coordenador),
			mysqli_real_escape_string($mysqli,$bool_temp),
			mysqli_real_escape_string($mysqli,$bool_revisor),
			mysqli_real_escape_string($mysqli,$bool_monitoria),
			mysqli_real_escape_string($mysqli,$id_inscrito)
		);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg" => "Inscrito atualizado com sucesso.",
		"mobilidade_ano_atual" => $mobilidade_ano_atual,
		"mobilidade_ano_passado" =>$mobilidade_ano_passado,
		"autoriza_envio_emails" =>$autoriza_envio_emails,
		// "bool_inscricao_paga" =>$bool_inscricao_paga
	));
?>