<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$queryTipoPagamentos = "SELECT id_tipo_pagamento, descricao_pagamento
						FROM es_pagamentos_tipos
						WHERE fgk_evento = ?";

	$vars = array('fgk_evento'=> $id_evento);

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryTipoPagamentos.=" AND descricao_pagamento LIKE ? ";
		$vars['descricao_pagamento'] = '%'.$filtro.'%';
	}

	$result = $db->sql_query($queryTipoPagamentos, $vars);

	$tipo_pagamentos = array();
	foreach ($result as $tipo){
		$tipo_pagamentos[] = $tipo;
	}

	echo json_encode(array(
		"success" => true,
		"tipo_pagamentos" => $tipo_pagamentos
	));
?>