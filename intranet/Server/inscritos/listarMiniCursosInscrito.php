<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_inscrito = $_REQUEST['id_inscrito'];
	$filtros = array();

	$queryString = "
		SELECT es_minicursos_inscritos.*, es_minicursos.titulo
		FROM es_minicursos_inscritos
		 INNER JOIN es_minicursos ON es_minicursos.id = es_minicursos_inscritos.fgk_minicurso
		 INNER JOIN es_inscritos_servicos ON es_inscritos_servicos.id_inscrito_servico = es_minicursos_inscritos.fgk_inscrito_servico
		  INNER JOIN es_inscritos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito
		WHERE es_minicursos.fgk_evento = ? AND es_inscritos.id = ?
	";
	$filtros[] = intval($id_evento_atual);
	$filtros[] = intval($id_inscrito);
	// echo $queryString;
	// echo $id_inscrito;
	$total = $db->sql_query2($queryString,$filtros);
	

	$resultado = array();
	foreach ($total as $res)
		$resultado[] = $res;

	echo json_encode(array(
		"success" => true,
		"resultado" => $resultado
	));
?>