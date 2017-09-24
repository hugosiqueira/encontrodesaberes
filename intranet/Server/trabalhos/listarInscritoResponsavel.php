<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_trabalho = $_REQUEST['id_trabalho'];
	$queryString = "
		SELECT es_inscritos.id, es_inscritos.nome FROM `es_inscritos`
		INNER JOIN es_trabalho_autor ON es_trabalho_autor.cpf = es_inscritos.cpf
		WHERE es_trabalho_autor.fgk_trabalho = $id_trabalho AND es_inscritos.fgk_evento = $id_evento_atual
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resultado),
		"resultado" => $resultado
	));
?>