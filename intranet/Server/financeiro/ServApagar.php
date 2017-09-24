<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');

	///////////////////////////////////////////////////////////
	exit();
	///////////////////////////////////////////////////////////


	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];

	$json = $_POST['servico'];
	$dados = json_decode($json);
		$id_inscrito_servico = $dados->id_inscrito_servico;

	$db->iniciar_transacao();

	$DadosBoleto = $db->listar('es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
		$id_boleto = $DadosBoleto->fgk_boleto;

	$ChaveBoleto = $db->listar('es_inscritos_boletos', 'id_boleto', $id_boleto);
		$chave_boleto = $ChaveBoleto->chave;

	$buscaToken = $db->listar('es_pagamentos_tipos', 'fgk_evento', $id_evento);
	 	$token =  $buscaToken->token;
	 	
	$url = 'https://fortunus.gerencianet.com.br/webservice/cancelarCobranca';

	/*** XML com os dados necessários para cancelamento de cobranças.*/
	$xml = "
		<?xml version='1.0' encoding='utf-8'?>
		<CancelarCobranca>
		<Token>$token</Token>
		<Chave>$chave_boleto</Chave>
		</CancelarCobranca>
	";
	/*** O XML enviado não pode conter quebras de linha e tabulações.*/
	$xml = str_replace("\n", '', $xml);
	$xml = str_replace("\r",'',$xml);
	$xml = str_replace("\t",'',$xml);
	/*** Handle $ch : Manipulador de comunicação para transferência de dados, via CURL.*/
	$ch = curl_init();
	/*** Atualiza a URL de destino da variável $ch para a URL definida pela variável $url.*/
	curl_setopt($ch, CURLOPT_URL, $url);
	/*** Configura a variável $ch para retornar o resultado da comunicação, ao invés de exibir diretamente.*/
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	/*** Configura o máximo de redirecionamentos permitido.*/
	curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
	/*** Configura para que seja inserido automaticamente o campo Referer: nas requisições que seguem um redirecionamento Location:*/
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	/*** Array $data: Armazena o xml a ser enviado($data['xml']=$xml)*/
	$data = array('xml' => $xml);
	/*** Configura para que a requisição seja enviada via POST*/
	curl_setopt($ch, CURLOPT_POST, true);
	/*** Define os dados a serem enviados na requisição via POST*/
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	/*** Define o tempo limite de tentativa de conexão*/
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	/*** Configura o USERAGENT da requisição*/
	curl_setopt($ch, CURLOPT_USERAGENT, 'Sistema');
	/*** Envia a requisição via POST com o XML e retorna o resultado da requisição*/
	$resposta = curl_exec($ch);
	/*** Encerra a ponte de comunicação*/
	curl_close($ch);
	/*** Imprime a resposta da requisição.*/
	$retorno = simplexml_load_string($resposta);
	
	if($retorno->StatusCod == 2){
		$db->excluir('es_inscritos_boletos', 'id_boleto', $id_boleto); //APAGA O BOLETO DO INSCRITO
		$db->excluir('es_inscritos_servicos','id_inscrito_servico',$id_inscrito_servico); //APAGA O SERVICO DO INSCRITO
		$db->commit();
	}else{
		echo json_encode(array(
			"success" =>false,
			"msg" => "Um erro ocorreu ao <b>CANCELAR</b> um boleto.<br>Favor entrar em contato com o adminstrador do sistema."
		));
		exit();
	}

	echo json_encode(array(
		"success" => true
	));
?>