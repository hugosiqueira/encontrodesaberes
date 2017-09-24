<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_trabalho = $_REQUEST['id_trabalho'];

	$queryString = "
		SELECT es_anais_trabalho_autor.*, es_tipo_autor.descricao_tipo
		FROM es_anais_trabalho_autor
		 INNER JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_anais_trabalho_autor.fgk_tipo
		WHERE es_anais_trabalho_autor.fgk_trabalho_anais = ?
		ORDER BY es_anais_trabalho_autor.seq ASC
	";
	$query = $db->sql_query2($queryString, array(intval($id_trabalho)));

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>