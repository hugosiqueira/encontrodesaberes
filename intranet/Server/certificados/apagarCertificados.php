<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	
	$json = $_POST['certificado'];
	$dados = json_decode($json);

	if($db->excluir('es_certificados', 'id_certificado', $dados->id_certificado)){
		echo json_encode(array(
			"success"=> true,
			"msg" => "Revisor removido com sucesso."
		));
	}

?>