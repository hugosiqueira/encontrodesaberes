<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	require_once('date_create_from_format.php');
	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];
	
	$id_inscrito = $_POST['id'];
	$id_minicurso = $_POST['id_minicurso'];
	$id_servico = $_POST['fgk_servico'];
	// 909b455f04e36fa1d4eef0feb230ab95 TOKEN TESTE

	$db->iniciar_transacao();

	//INFORMACOES PARA GERAR BOLETO
	// $buscaToken = $db->listar('es_pagamentos_tipos', 'fgk_evento', $id_evento);
	// $token =  $buscaToken->token;
	// $url = $buscaToken->token_url;

	// $buscaInscrito = $db->listar('es_inscritos', 'id', $id_inscrito);
	// $nome = $buscaInscrito->nome;
	// $cpf = $buscaInscrito->cpf;
	// // $telefone_celular = $buscaInscrito->telefone_celular;
	// $telefone_celular = '';
	// $email = $buscaInscrito->email;

	$buscaDescricao  = $db->listar('es_servicos', 'id_servico', $id_servico);
	$descricao_servico = $buscaDescricao->descricao_servico;
	$valor_servico = $buscaDescricao->valor_servico;

	// $buscaDataLimite = $db->listar('es_evento', 'id', $id_evento);
	// $dataLimiteBoletos = $buscaDataLimite->data_max_vencimento_boleto;

	// function geraTimestamp($data) {
		// $partes = explode('-', $data);
		// return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
	// }
	// $time_inicial = geraTimestamp(date('Y-m-d'));
	// $time_final = geraTimestamp($dataLimiteBoletos);
	// $diferenca = $time_final - $time_inicial;
	// $dias = (int)floor( $diferenca / (60 * 60 * 24));
	/*
	$Hoje = date('Y-m-d');
	$hojeDT = new DateTime();
	$dataLimit = date_create_from_format('Y-m-d', $dataLimiteBoletos);
	$diffDays = intval($hojeDT->diff($dataLimit)->format('%a'), 10);
	*/
	// function formatadataaqui($data){
		// $partes = explode('-',$data);
		// $retorno = $partes[2].'/'.$partes[1].'/'.$partes[0];
		// return $retorno;
	// }
	// if($dias <= 14){
		// $vencimentoDt = formatadataaqui($dataLimiteBoletos);
		// // echo $dataLimiteBoletos;
	// }
	// else if($dias > 14){
		// $vencimentoDt = date('d/m/Y', strtotime('+14 days'));
		// // echo "2";
	// }
	// echo $vencimentoDt;
	
	//GERACAO DO BOLETO GERENCIANET
	/*$xml = "<?xml version='1.0' encoding='utf-8'?>
	<boleto>
	<token>".$token."</token>
	<clientes><cliente>
	<nomeRazaoSocial>".$nome."</nomeRazaoSocial>
	<cpfcnpj>".preg_replace("/[^0-9\s]/", "", $cpf)."</cpfcnpj>
	<cel>".preg_replace("/[^0-9\s]/", "", $telefone_celular)."</cel>
	<opcionais>
	<email>".$email."</email>
	</opcionais>
	</cliente></clientes>
	<itens><item>
	<descricao>".$descricao_servico."</descricao>
	<valor>".preg_replace("/[^0-9\s]/", "", $valor_servico)."</valor>
	<qtde>1</qtde>
	</item></itens>
	<vencimento>".$vencimentoDt."</vencimento>
	</boleto>";*/
	// $xml = str_replace("\n", '', $xml);
	// $xml = str_replace("\r",'',$xml);
	// $xml = str_replace("\t",'',$xml);
	// /*** Handle $ch : Manipulador de comunicação para transferência de dados, via CURL.*/
	// $ch = curl_init();
	// /*** Atualiza a URL de destino da variável $ch para a URL definida pela variável $url.*/
	// curl_setopt($ch, CURLOPT_URL, $url);
	// /*** Configura a variável $ch para retornar o resultado da comunicação, ao invés de exibir diretamente.*/
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// /*** Configura o máximo de redirecionamentos permitido.*/
	// curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
	// /*** Configura para que seja inserido automaticamente o campo Referer: nas requisições que seguem um redirecionamento Location:*/
	// curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	// /*** Array $data: Armazena o xml a ser enviado($data['entrada']=$xml)*/
	// $data = array('entrada' => $xml);
	// /*** Configura para que a requisição seja enviada via POST*/
	// curl_setopt($ch, CURLOPT_POST, true);
	// /*** Define os dados a serem enviados na requisição via POST*/
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// /*** Define o tempo limite de tentativa de conexão*/
	// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	// /*** Configura o USERAGENT da requisição*/
	// curl_setopt($ch, CURLOPT_USERAGENT, 'Sistema');
	// /*** Envia a requisição via POST com o XML e retorna o resultado da requisição*/
	// $resposta = curl_exec($ch);
	// /*** Encerra a ponte de comunicação*/
	// curl_close($ch);

	// $retorno = simplexml_load_string($resposta);
	// if($retorno->statusCod == 2){
		// $chave = $retorno->resposta->cobrancasGeradas->cliente->cobranca->chave;
		// $link = $retorno->resposta->cobrancasGeradas->cliente->cobranca->link;
		// $vencimento = $retorno->resposta->cobrancasGeradas->cliente->cobranca->vencimento;
		// $valor = $retorno->resposta->cobrancasGeradas->cliente->cobranca->valor;
	// }else{
		// if($retorno->resposta->erro->status == 1012){ // significa que é um erro de cobrança já gerada anteriormente. Logo, iremos tratar a resposta anterior.
			// $retornoAnterior = $retorno->resposta->erro->entrada;
			// $link = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link;
			// $chave = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->chave;
			// $vencimento = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->vencimento;
			// $valor = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->valor;
		// }else{
			// //Foi outro tipo de erro. Nesse caso, pode ser tratado, ou então mostrar o erro na página
			// // RecurseXML($retorno);
			// // $erroMsg = $retorno->resposta->erro->statusMsg;
			// $erroMsg = '';
			// echo json_encode(array(
				// "success" =>false,
				// "msg" => "Um erro ocorreu ao <b>GERAR</b> o boleto.<br>".$erroMsg."<br>Favor entrar em contato com o adminstrador do sistema."
			// ));
			// exit();
		// }
	// }
	//FIM GERACAO DO BOLETO GERENCIANET
	//GRAVAR DADOS NO BANCO
	// $DadosBoleto = array('fgk_inscrito'=>$id_inscrito, 'data_emissao'=>$Hoje, 'chave'=>$chave, 'valor'=>$valor, 'data_vencimento'=>$vencimento, 'link'=>$link, 'status'=>0);
	// $db->inserir('es_inscritos_boletos', $DadosBoleto);
	// $fgk_boleto = $db->lastInsertId();

	$ServicoValues = array('fgk_inscrito'=>$id_inscrito, 'fgk_servico'=>$id_servico, 'valor_servico'=>$valor_servico, 'bool_pago'=>1);
	$db->inserir('es_inscritos_servicos', $ServicoValues);
	$fgk_inscrito_servico = $db->lastInsertId();

	$minicursoInscritos = array('fgk_inscrito_servico'=>$fgk_inscrito_servico, 'fgk_minicurso'=>$id_minicurso, 'datahora_registro'=>date('Y-m-d H:i:s'));
	$db->inserir('es_minicursos_inscritos', $minicursoInscritos);


	$db->commit();
	
	echo json_encode(array(
		"success" => true,
		"msg" => "Inscrito cadastrado com sucesso."
	));
?>