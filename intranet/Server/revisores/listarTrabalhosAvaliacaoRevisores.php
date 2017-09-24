<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_revisor = $_REQUEST['id_revisor'];


	$queryString = "
		SELECT es_trabalho_apresentacao.*, es_trabalho.id, es_trabalho.titulo_enviado
		FROM es_trabalho_apresentacao
		 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
		WHERE fgk_revisor = ?

	";
	$query = $db->sql_query($queryString, array('fgk_revisor'=> $id_revisor));
	$resultado = array();
	foreach ($query as $registros){
		$resultado[] = $registros;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>