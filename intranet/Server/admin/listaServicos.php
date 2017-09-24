<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	if(isset($_REQUEST['id_evento']) && ($_REQUEST['id_evento'] != ''))
		$id_evento = $_REQUEST['id_evento'];
	else
		$id_evento = $_SESSION['id_evento_atual'];

	$queryServicos = "SELECT id_servico AS id, valor_servico, descricao_servico 
							FROM es_servicos ";

		$vars = array();

		if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
			$filtro = $_REQUEST['filtro'];
			$queryServicos.=" WHERE descricao_servico LIKE ? ";
			$vars['descricao_servico'] = '%'.$filtro.'%';
		}
		
		$total = $db->sql_query($queryServicos, $vars);
		$queryServicos.=" ORDER BY descricao_servico ASC; ";
		$result = $db->sql_query($queryServicos, $vars);

		$servicos = array();
		foreach ($result as $servico)
			$servicos[] = $servico;

		echo json_encode(array(
			"success" => true,
			"total" => $total->rowCount(),
			"servicos" => $servicos
		));
?>