<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	$id_evento 			= $_SESSION['id_evento_atual'];
	$evento 			= $_SESSION['titulo_evento_atual'];
	$formatacao_evento	= $_SESSION['formatacao_evento_atual'];
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"id_evento" => $id_evento,
		"evento" => $evento,
		"formatacao_evento" => $formatacao_evento		
	));
?>