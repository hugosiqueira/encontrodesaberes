<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	$id_novo_evento = $_REQUEST['novo_evento'];

	$queryString = "
		SELECT * FROM es_evento WHERE es_evento.id = $id_novo_evento
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());
	while($registro = mysqli_fetch_assoc($query)) {
		$_SESSION['id_evento_atual'] 		= $registro['id'];
		$_SESSION['titulo_evento_atual'] 	= $registro['titulo'];
		$_SESSION['formatacao_evento_atual'] = $registro['sigla']." - ".$registro['titulo'];		
		echo '{"success":true}';
		exit;
	}
	echo '{"success":false}';



?>