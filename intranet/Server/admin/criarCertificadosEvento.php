<?php
	header('Content-Type: text/html; charset=utf-8');
	// header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$json = $_POST['certificado'];
	$dados = json_decode($json);
	$descricao_certificado 	= $dados->descricao_certificado;
  	$modelo_padrao 			= $dados->modelo_padrao;
 
	$novoRegistro = array(
		'fgk_evento'			=> $id_evento_atual,
		'descricao_certificado'	=> $descricao_certificado,
		'modelo_padrao'			=> $modelo_padrao
	);
	$db->inserir('es_certificados_tipos', $novoRegistro);

	echo json_encode(array(
		"success" => true,
		"msg" => "Registro cadastrado com sucesso."
	));
	exit;
	
?>