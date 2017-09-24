<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$query = "SELECT id_local_presenca, descricao_local, apelido_local, COUNT(fgk_presenca_local) AS num_resp
				FROM es_presencas_locais 
				LEFT JOIN es_presencas_locais_usuarios ON es_presencas_locais.id_local_presenca = es_presencas_locais_usuarios.fgk_presenca_local
				WHERE fgk_evento = ?";

	$vars = array('fgk_evento'=> $id_evento);

	$total = $db->sql_query($query, $vars);
	$query.=" ORDER BY apelido_local ASC; ";
	$result = $db->sql_query($query, $vars);

	$checkpoints = array();
	foreach ($result as $checkpoint)
		$checkpoints[] = $checkpoint; 

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"checkpoints" => $checkpoints
	));
?>