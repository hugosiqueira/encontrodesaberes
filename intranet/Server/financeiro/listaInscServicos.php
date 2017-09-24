<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryServicos = "SELECT es_inscritos_servicos.bool_pago, es_inscritos_servicos.id_inscrito_servico, es_servicos.descricao_servico, es_servicos.valor_servico 
					 FROM es_inscritos_servicos
					 INNER JOIN es_servicos ON es_inscritos_servicos.fgk_servico = es_servicos.id_servico";
					 // WHERE es_servicos.fgk_evento = $id_evento"; //Não foram criados servicos pro SEIC2016, e sim usados do SEIC2015

	if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
		$id_inscrito = $_REQUEST['id'];
		$queryServicos.=" AND es_inscritos_servicos.fgk_inscrito = $id_inscrito";
	}
	
	$total = $db->sql_query($queryServicos);
	$queryServicos.=" ORDER BY es_servicos.descricao_servico ASC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryServicos);

	$servicos = array();
	foreach ($result as $servico)
		$servicos[] = $servico;

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"servicos" => $servicos
	));
?>