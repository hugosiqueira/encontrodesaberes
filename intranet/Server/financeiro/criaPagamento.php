<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/boletos.php');

	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];
	$id_inscrito_servico = $_POST['id_inscrito_servico'];
	$id_forma_pagamento = $_POST['id_forma_pagamento'];

	$tipoPG = $db->listar('es_pagamentos_tipos', 'id_tipo_pagamento', $id_forma_pagamento);

	if($tipoPG->bool_boleto == 1){
		// // CRIA BOLETO GERENCIANET // //

		$serv_insc = $db->listar('es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
		 	$id_inscrito = $serv_insc->fgk_inscrito;

		criaBoleto($db, $id_inscrito, $id_inscrito_servico, $id_forma_pagamento);

	}else{
		// // SOMENTE PAGA O SERVICO // //
		$dataHoraHoje = date("Y-m-d H:i:s");

		$db->iniciar_transacao();
		$result1 = $db->listar('es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
		 	$tipoServico = $result1->fgk_servico;
		 	$valor_pago = $result1->valor_servico;

		$db->atualizar('es_inscritos_servicos', array('bool_pago'=>1), 'id_inscrito_servico', $id_inscrito_servico);

		$dadosPagamento = array('id_inscrito_servico'=>$id_inscrito_servico, 'fgk_servico'=>$tipoServico, 'fgk_tipo_pagamento'=>$id_forma_pagamento, 'datahora_pagamento'=>$dataHoraHoje, 'valor_pago'=>$valor_pago );
		$db->inserir('es_inscritos_pagamentos', $dadosPagamento);

		$db->commit();
		echo json_encode(array(
			"success" => true,
			"msg" => 'Serviço pago com sucesso.'
		));
	} 
?>