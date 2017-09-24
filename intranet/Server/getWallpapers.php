<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$arquivo = $id_evento.".jpg";
	
	$caminho = '../resources/wallpapers/'.$arquivo;
	if (!file_exists($caminho)) {
		$arquivo = "0.jpg";
	}
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"wallpaper" => $arquivo
	));
?>