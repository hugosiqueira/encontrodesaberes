<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("$_SERVER[DOCUMENT_ROOT]/intranet/includes/functions.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/admin/vendor/autoload.php");
 
	use Gerencianet\Exception\GerencianetException;
	use Gerencianet\Gerencianet;

	sec_session_start();

	$hoje = new DateTime();
	$id_tipo_pagamento = intval($_REQUEST['pgt']); //O link do callback passa essa parametro na url cadastrada no banco
	$id_evento = intval($_REQUEST['evt']); //O link do callback passa essa parametro na url cadastrada no banco

	$result_banco = $db->listar(DB_BASE,'es_eventos', 'id', $id_evento);
		$db_evento = $result_banco->nome_banco;

	$tipo_pagamento = $db->listar($db_evento, 'es_pagamentos_tipos', 'id_tipo_pagamento', $id_tipo_pagamento);
        $client_id = $tipo_pagamento->client;
        $client_secret = $tipo_pagamento->client_secret;
	 
	$options = [
	  'client_id' => $client_id,
	  'client_secret' => $client_secret,
	  'sandbox' => false
	];

	$params = [ 'token' => $_POST['notification'] ];
	
	try{
	    $api = new Gerencianet($options);
	    $notification = $api->getNotification($params, []);
	 	foreach ($notification['data'] as $transacao){

	 		$charge_id = intval($transacao['identifiers']['charge_id']);
	 		$valor_pago = $transacao['value'];
	 		$status = $transacao['status']['current'];
	 		$data_pagamento = $hoje->format('Y-m-d');
	 		$datahora_pagamento = $hoje->format('Y-m-d H:i:s');

	 		$db->iniciar_transacao();
		 		$existeBoleto = $db->existe($db_evento, 'es_inscritos_boletos', array('chave'=>$charge_id));
		 		$existeCartao = $db->existe($db_evento, 'es_transacoes', array('chave'=>$charge_id));

		 		if($existeBoleto){
			 		$updateData = array('status'=>$status, 'data_pagamento'=>$data_pagamento, 'valor_pago'=>$valor_pago);
			 		$db->atualizar($db_evento, 'es_inscritos_boletos', $updateData, 'charge_id', $charge_id);

			 		$qServico ="SELECT id_inscrito_servico, fgk_servico FROM es_inscritos_servicos 
			 					INNER JOIN es_inscritos_boletos ON es_inscritos_servicos.fgk_boleto = es_inscritos_boletos.id_boleto 
			 					WHERE es_inscritos_boletos.chave = ?";
			 		$rsServico = $db->sql_query($db_evento, $qServico, array('chave'=>$charge_id));
			 		foreach($rsServico as $servico){
			 			$id_inscrito_servico = intval($servico->id_inscrito_servico);
			 			$fgk_servico = intval($servico->fgk_servico);
			 		}
	
			 		if($status == 'paid'){
						$isPg = $db->existe($db_evento, 'es_inscritos_pagamentos', array('id_inscrito_servico'=>$id_inscrito_servico));
						if(!$isPg){
							$dadosPagamento = array('id_inscrito_servico'=>$id_inscrito_servico, 'fgk_servico'=>$fgk_servico, 'fgk_tipo_pagamento'=>$id_tipo_pagamento, 'datahora_pagamento'=>$datahora_pagamento, 'valor_pago'=>$valor_pago );
							$db->inserir($db_evento, 'es_inscritos_pagamentos', $dadosPagamento);
						}else{
							$db->atualizar($db_evento, 'es_inscritos_pagamentos', array('valor_pago'=>$valor_pago), 'id_inscrito_servico', $id_inscrito_servico);
						}
	
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>1), 'id_inscrito_servico', $id_inscrito_servico);
	
				 	}else if($status =='contested'){
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>0), 'id_inscrito_servico', $id_inscrito_servico);
	
				 	}else if($status == 'refunded'){
				 		$db->excluir($db_evento, 'es_inscritos_pagamentos','id_inscrito_servico', $id_inscrito_servico);
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>0), 'id_inscrito_servico', $id_inscrito_servico);
				 	}
				}else if($existeCartao){
			 		$db->atualizar($db_evento, 'es_transacoes', array('status'=>$status) 'charge_id', $charge_id);

			 		$qServico ="SELECT id_inscrito_servico, fgk_servico FROM es_inscritos_servicos 
			 					INNER JOIN es_transacoes ON es_inscritos_servicos.fgk_transacao = es_transacoes.id_transacao 
			 					WHERE es_transacoes.charge_id = ?";
			 		$rsServico = $db->sql_query($db_evento, $qServico, array('charge_id'=>$charge_id));
			 		foreach($rsServico as $servico){
			 			$id_inscrito_servico = intval($servico->id_inscrito_servico);
			 			$fgk_servico = intval($servico->fgk_servico);
			 		}
	
			 		if($status == 'paid'){
						$isPg = $db->existe($db_evento, 'es_inscritos_pagamentos', array('id_inscrito_servico'=>$id_inscrito_servico));
						if(!$isPg){
							$dadosPagamento = array('id_inscrito_servico'=>$id_inscrito_servico, 'fgk_servico'=>$fgk_servico, 'fgk_tipo_pagamento'=>$id_tipo_pagamento, 'datahora_pagamento'=>$datahora_pagamento, 'valor_pago'=>$valor_pago );
							$db->inserir($db_evento, 'es_inscritos_pagamentos', $dadosPagamento);
						}else{
							$db->atualizar($db_evento, 'es_inscritos_pagamentos', array('valor_pago'=>$valor_pago), 'id_inscrito_servico', $id_inscrito_servico);
						}
	
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>1), 'id_inscrito_servico', $id_inscrito_servico);
	
				 	}else if($status =='contested'){
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>0), 'id_inscrito_servico', $id_inscrito_servico);
	
				 	}else if($status == 'refunded'){
				 		$db->excluir($db_evento, 'es_inscritos_pagamentos','id_inscrito_servico', $id_inscrito_servico);
				 		$db->atualizar($db_evento, 'es_inscritos_servicos', array('bool_pago'=>0), 'id_inscrito_servico', $id_inscrito_servico);
				 	}
				}else if($status !='new'){
					$log = fopen("log.txt", "a");
						fwrite($log, "\n".$hoje->format('Y-m-d H:i:s')."\n");
						fwrite($log, "\t--Boleto não identificado--\n");
					    fwrite($log, "\tCharge_id: ".$charge_id."\n");
					    fwrite($log, "\tValor pago: ".$valor_pago."\n");
					    fwrite($log, "\tStatus: ".$status."\n");
				    fclose($log); 
				}
	 		$db->commit();
	 	}
	}catch (GerencianetException $e){
		$log = fopen("log.txt", "a");
			fwrite($log, "\n".$hoje->format('Y-m-d H:i:s')."\n");
		    fwrite($log, "\t".$e->code."\n");
		    fwrite($log, "\t".$e->error."\n");
		    fwrite($log, "\t".var_dump($e->errorDescription)."\n");
	    fclose($log); 
	}catch (Exception $e){
		$log = fopen("log.txt", "a");
			fwrite($log, "\n".$hoje->format('Y-m-d H:i:s')."\n");
		    fwrite($log, "\t".var_dump($e->getMessage())."\n");
	    fclose($log); 
	}
?>