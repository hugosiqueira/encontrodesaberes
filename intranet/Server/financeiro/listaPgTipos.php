<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$queryPgTipos = "SELECT id_tipo_pagamento, descricao_pagamento, bool_boleto FROM es_pagamentos_tipos WHERE fgk_evento = ?";

	$result = NULL;

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryPgTipos.=" AND descricao_pagamento LIKE ? ";
		$vars = array('fgk_evento'=>$id_evento,'descricao_pagamento'=>  '%'.$filtro.'%');

		$queryPgTipos.=" ORDER BY descricao_pagamento ASC; ";
		$result = $db->sql_query($queryPgTipos, $vars);
	}else{
		$vars = array('fgk_evento'=>$id_evento);

		$queryPgTipos.=" ORDER BY descricao_pagamento ASC; ";
		$result = $db->sql_query($queryPgTipos, $vars);
	}

	$tipospg = array();
	foreach ($result as $tipo)
		$tipospg[] = $tipo;

	echo json_encode(array(
		"success" => true,
		"tipospg" => $tipospg
	));
?>