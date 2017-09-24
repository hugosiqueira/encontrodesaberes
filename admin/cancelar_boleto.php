<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
  include ("../../config.php");

	$buscar_token = $db->sql_query("SELECT token, token_url FROM es_pagamentos_tipos WHERE fgk_evento = ? AND id_tipo_pagamento = ?", array('fgk_evento'=>1, 'id_tipo_pagamento'=> 2));
	foreach ($buscar_token as $registro) {
	    $token = $registro->token;
	    $url = 'https://fortunus.gerencianet.com.br/webservice/cancelarCobranca';
	}
	
	foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

	/*** XML com os dados necessários para cancelamento de cobranças.*/
	$xml = "
		<?xml version='1.0' encoding='utf-8'?>
		<CancelarCobranca>
		<Token>".$token."</Token>
		<Chave>".$chave."</Chave>
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
	 
	 function RecurseXML($xml,$parent=""){
	    $child_count = 0;
	    foreach($xml as $key=>$value)
	    {
		   $child_count++;
		   if(RecurseXML($value,$parent.".".$key) == 0)  // no childern, aka "leaf node"
		   {
			  print($parent . "." . (string)$key . " = " . (string)$value . "<BR>\n");
		   }
	    }
	    return $child_count;
	 }
	if($retorno->StatusCod == '2'){
		$query = $db->atualizar("es_inscritos_boletos",array('status'=>3), 'id_boleto',$id_boleto);
		$db->excluir("es_minicursos_inscritos", 'id', $id_minicurso_inscrito);
	}
	else{
		echo "Um erro ocorreu ao <b>CANCELAR</b> um boleto.<br>Favor entrar em contato com o adminstrador do sistema. ERRO: ".RecurseXML($retorno);
		exit();
	}
	echo  "Boleto cancelado com sucesso.";
}
?>