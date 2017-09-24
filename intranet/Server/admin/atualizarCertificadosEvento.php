<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['certificado'];
	$dados = json_decode($json);
	$descricao_certificado 	= $dados->descricao_certificado;
  	$modelo_padrao 			= $dados->modelo_padrao;
  	$id_tipo_certificado 			= $dados->id_tipo_certificado;
	
	$atualizarRegistro = array(
		'descricao_certificado'	=> $descricao_certificado,
		'modelo_padrao'			=> $modelo_padrao
	);

	$db->atualizar('es_certificados_tipos', $atualizarRegistro, 'id_tipo_certificado', $id_tipo_certificado);

	echo json_encode(array(
		"success" => true,
		"msg" => "Revisor atualizado com sucesso."
	));
?>