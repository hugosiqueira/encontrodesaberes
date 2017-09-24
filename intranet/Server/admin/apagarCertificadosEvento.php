<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');

	$json = $_POST['certificado'];
	$dados = json_decode($json);
	$id_tipo_certificado = $dados->id_tipo_certificado;

	if($db->excluir('es_certificados_tipos', 'id_tipo_certificado', $id_tipo_certificado)){
		echo json_encode(array(
			"success"=> true,
			"msg" => "Registro removido com sucesso."
		));
	}

?>