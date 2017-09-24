<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];
	$db->iniciar_transacao();

	$url = 'https://fortunus.gerencianet.com.br/webservice/detalharCobranca';

	$buscaToken = $db->listar('es_pagamentos_tipos', 'fgk_evento', $id_evento);
	 	$token = $buscaToken->token;
	 	$chave = $_POST['chave'];

	$xml = "<?xml version='1.0' encoding='utf-8'?>
	<DetalharCobranca>
	     <Token>{$token}</Token>
	     <Chave>{$chave}</Chave>
	</DetalharCobranca>";
	 
	/** O XML enviado não pode conter quebras de linha e tabulações.*/
	$xml = str_replace("\n", '', $xml);
	$xml = str_replace("\r",'',$xml);
	$xml = str_replace("\t",'',$xml);

	$ch = curl_init();
	 
	/** Atualiza a URL de destino da variável $ch para a URL definida pela variável $url. */
	curl_setopt($ch, CURLOPT_URL, $url);
	 
	/** Configura a variável $ch para retornar o resultado da comunicação, ao invés de exibir diretamente. */
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	/** Configura o máximo de redirecionamentos permitido. */
	curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
	 
	/** Configura para que seja inserido automaticamente o campo Referer: nas requisições que seguem um redirecionamento Location: */
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	 
	/** Array $data: Armazena o xml a ser enviado($data['xml']=$xml) */
	$data = array('xml' => $xml);
	 
	/** Configura para que a requisição seja enviada via POST */
	curl_setopt($ch, CURLOPT_POST, true);
	 
	/** Define os dados a serem enviados na requisição via POST */
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	 
	/**Define o tempo limite de tentativa de conexão */
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	 
	/** Configura o USERAGENT da requisição */
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	 
	/** Envia a requisição via POST com o XML e retorna o resultado da requisição */
	$resposta = curl_exec($ch);

	curl_close($ch);

	$retorno = simplexml_load_string($resposta);

	if($retorno->StatusCod == 2){
		$boleto = array();

		$desconto = intval($retorno->ProdutosServicos->Desconto);
		$valor = intval($retorno->Boleto->Valor);

		$boleto['cpf'] = (string) $retorno->Cliente->CpfCnpJ;
		$boleto['StatusBoleto'] = (string) $retorno->Boleto->Status;
		$boleto['Valor'] = (string) $valor;
		$boleto['Emissao'] = (string) $retorno->Boleto->DataEmissao;
		$boleto['Vencimento'] = (string) $retorno->Boleto->DataVencimento;
		$boleto['Pagamento'] = (string) $retorno->Boleto->DataPagamento;
		$boleto['ValorPago'] = (string) $valor-$desconto;
		$boleto['Chave'] = $chave;

		echo json_encode(array(
			"success" => true,
			"boleto" => $boleto
		));

	}else{
		echo json_encode(array(
			"success" => false
		));
		exit();
	}

	$db->commit();
?>