<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];

	$id_inscrito = $_POST['id'];
	$json = $_POST['servico'];
	$dados = json_decode($json);
		$id_servico = $dados->id_servico;
		$valor_servico = $dados->valor_servico;

	$ServicoValues = array('fgk_inscrito'=>$id_inscrito, 'fgk_servico'=>$id_servico, 'valor_servico'=>$valor_servico, 'bool_pago'=>0);
	$db->inserir('es_inscritos_servicos', $ServicoValues);

	echo json_encode(array(
		"success" => true,
		"msg" => "Serviço criado com sucesso!"
	));
?>