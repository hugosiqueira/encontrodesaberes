<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$fgk_evento = $_SESSION['id_evento_atual'];//////

	$url = "https://integracao.gerencianet.com.br/xml/boleto/emite/xml";
	$token = '909b455f04e36fa1d4eef0feb230ab95';
	$id_inscrito	= $_REQUEST['id_inscrito'];
	$nome 			= $_REQUEST['nome'];
	$tipo 			= $_REQUEST['tipo'];
	$cpf 			= $_REQUEST['cpf'];
	$telefone_celular = str_replace(' ', '', $_REQUEST['celular']);
	$email 			= $_REQUEST['email'];
	$data_hoje = date('Y-m-d');

	$queryBoletos = "
		SELECT id_boleto 
		FROM es_inscritos_boletos 
		WHERE es_inscritos_boletos.status = 0 
		 AND es_inscritos_boletos.fgk_inscrito = $id_inscrito
	";
	$queryBoletos = mysqli_query($mysqli,$queryBoletos) or die(mysqli_error($mysqli));
	$boletos = mysqli_num_rows($queryBoletos);
	if($boletos > 0){
		echo json_encode(array(
			"success" =>false,
			"msg" => "Já existe um boleto aguardando pagamento para este inscrito."
		));
		exit();
	}	
	// $queryString = "
	// 	SELECT valor_inscricao
	// 	FROM es_inscritos_tipos
	// 	WHERE id_tipo_inscrito = $tipo		
	// ";

	$queryString = 
		"SELECT es_servicos.valor_servico
		FROM es_servicos
		INNER JOIN es_inscritos_tipos ON es_inscritos_tipos.fgk_servico_inscricao = es_servicos.id_servico
		WHERE es_inscritos_tipos.id_tipo_inscrito = $tipo
		AND es_servicos.fgk_evento = $fgk_evento";


	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$registro = mysqli_fetch_assoc($query);
	$valor_inscricao = $registro['valor_servico'];

	$xml = "<?xml version='1.0' encoding='utf-8'?>
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
	<descricao>Encontro de Saberes para o cpf ".$cpf."</descricao>
	<valor>".preg_replace("/[^0-9\s]/", "", $valor_inscricao)."</valor>
	<qtde>1</qtde>
	</item></itens>
	<vencimento>".date('d/m/Y', strtotime('+14 days'))."</vencimento>
	</boleto>";
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
	/*** Array $data: Armazena o xml a ser enviado($data['entrada']=$xml)*/
	$data = array('entrada' => $xml);
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

	$retorno = simplexml_load_string($resposta);

	if($retorno->StatusCod == 2){
		$chave = $retorno->resposta->cobrancasGeradas->cliente->cobranca->chave;
		$link = $retorno->resposta->cobrancasGeradas->cliente->cobranca->link;
		$vencimento = $retorno->resposta->cobrancasGeradas->cliente->cobranca->vencimento;
		$valor = $retorno->resposta->cobrancasGeradas->cliente->cobranca->valor;
	}
	else{
		if($retorno->resposta->erro->status == 1012){ // significa que é um erro de cobrança já gerada anteriormente. Logo, iremos tratar a resposta anterior.
			$retornoAnterior = $retorno->resposta->erro->entrada;
			$link = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link;
			$chave = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->chave;
			$vencimento = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->vencimento;
			$valor = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->valor;
		}
		else{
			//Foi outro tipo de erro. Nesse caso, pode ser tratado, ou então mostrar o erro na página		
			echo json_encode(array(
				"success" =>false,
				"msg" => "Um erro ocorreu ao <b>GERAR</b> o boleto.<br>Favor entrar em contato com o adminstrador do sistema."
			));
			exit();
		}
	}
	// GUARDAR O NOVO
	$query = sprintf("
		INSERT INTO es_inscritos_boletos
		(	fgk_inscrito, data_emissao, chave, valor, data_vencimento, link, status)
		values
		(	%d, '%s', '%s', %d, '%s', '%s', %d)",
			mysqli_real_escape_string($mysqli,$id_inscrito),
			mysqli_real_escape_string($mysqli,$data_hoje),
			mysqli_real_escape_string($mysqli,$chave),
			mysqli_real_escape_string($mysqli,$valor),
			mysqli_real_escape_string($mysqli,$vencimento),
			mysqli_real_escape_string($mysqli,$link),
			mysqli_real_escape_string($mysqli,0)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	$id_ultimo_boleto = mysqli_insert_id($mysqli);
	
	echo json_encode(array(
		"success" =>true,
		"msg" => "Boleto gerado com sucesso."
	));
?>