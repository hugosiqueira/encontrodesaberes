<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	if(isset($_REQUEST['id_evento']) && ($_REQUEST['id_evento'] != '')){
		$id_evento = $_REQUEST['id_evento'];

		$json = $_POST['servico'];
		$dados = json_decode($json);
		$descricao_servico = $dados->descricao_servico;
		$valor_servico = $dados->valor_servico;

		$Values = array('fgk_evento'=>$id_evento, 'descricao_servico'=>$descricao_servico,'valor_servico'=>$valor_servico);
		$db->inserir('es_servicos', $Values);

		echo json_encode(array(
			"success" => true
		));
	}
?>