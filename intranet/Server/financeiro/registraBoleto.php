<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');

	///////////////////////////////////////////////////////////
	exit();
	///////////////////////////////////////////////////////////
	
	sec_session_start();
	$db->iniciar_transacao();

	$json = $_POST['boleto'];
	$dados = json_decode($json);
		$cpf = $dados->cpf;
		$id_servico = $dados->servico;
		$chave = $dados->Chave;
		$valor =  $dados->Valor;
		$ValorPago = $dados->ValorPago;
		$vencimento = toDate($dados->Vencimento);
		$pagamento = toDate($dados->Pagamento);
		$emissao = toDate($dados->Emissao);
		$link = $dados->Link;

 	$buscaInscrito = $db->listar('es_inscritos', 'cpf', $cpf);
 		$id_inscrito = $buscaInscrito->id;
	 	$nome = $buscaInscrito->nome;
	 	$telefone_celular = $buscaInscrito->telefone_celular;
	 	$email = $buscaInscrito->email;

	$buscaValor = $db->listar('es_servicos', 'id_servico', $id_servico);
		$valor_servico = $buscaValor->valor_servico;

	//GRAVAR DADOS NO BANCO
	$varsblt = array('chave'=> $chave);
	$existeBoleto = $db->existe('es_inscritos_boletos', $varsblt);
	if(!$existeBoleto){
		if($pagamento){
			$bool_pago = 1;
			$DadosBoleto = array('fgk_inscrito'=>$id_inscrito, 'data_emissao'=>$emissao, 'chave'=>$chave, 'valor'=>$valor, 'data_vencimento'=>$vencimento, 'link'=>$link, 'status'=>2, 'data_pagamento'=>$pagamento, 'valor_pago'=>$ValorPago);
			$db->inserir('es_inscritos_boletos', $DadosBoleto);

			$id_boleto = $db->lastInsertId();
		}else{
			$bool_pago = 0;
			$DadosBoleto = array('fgk_inscrito'=>$id_inscrito, 'data_emissao'=>$emissao, 'chave'=>$chave, 'valor'=>$valor, 'data_vencimento'=>$vencimento, 'link'=>$link, 'status'=>0);
			$db->inserir('es_inscritos_boletos', $DadosBoleto);
		}

		$fgk_boleto = $db->lastInsertId();

		$ServicoValues = array('fgk_inscrito'=>$id_inscrito, 'fgk_servico'=>$id_servico, 'fgk_boleto'=>$fgk_boleto, 'valor_servico'=>$valor_servico, 'bool_pago'=>$bool_pago);
		$db->inserir('es_inscritos_servicos', $ServicoValues);

		$id_inscrito_servico = $db->lastInsertId();

		if($pagamento){
			$pgtoValues = array('id_inscrito_servico'=> $id_inscrito_servico, 'fgk_servico'=>$id_servico,  'fgk_tipo_pagamento'=>2, 'datahora_pagamento'=>$pagamento, 'valor_pago'=>$ValorPago);
			$db->inserir('es_inscritos_pagamentos', $pgtoValues);
		}
		$db->commit();
	}

	echo json_encode(array(
		"success" => true
	));

	function toDate( $data ){
		if($data){
			$data = DateTime::createFromFormat("d/m/Y", $data);
			$data = $data->format("Y-m-d");
			return $data;
		}else
			return NULL;
	}
?>