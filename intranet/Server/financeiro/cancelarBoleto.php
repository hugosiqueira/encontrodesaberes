<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/boletos.php';

	$id_boleto = $_REQUEST['id_boleto'];

	$charge_id = $db->listar('es_inscritos_boletos', 'id_boleto', $id_boleto)->charge_id;

	cancelaBoleto($db, $charge_id);
?>