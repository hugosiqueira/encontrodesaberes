<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_evento = $_REQUEST['id_evento'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$filtros = array();

	$queryString = "
		SELECT es_certificados_tipos.*
		FROM es_certificados_tipos
		WHERE es_certificados_tipos.fgk_evento = ?
	";
	$filtros[] = $id_evento;

	
	$total = $db->sql_query2($queryString,$filtros);
	$queryString.="ORDER BY descricao_certificado LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $certificado){
		$caminho = '../../../img/certificados/tipos/'.$certificado->id_tipo_certificado.'.jpg';
		if (file_exists($caminho))
			$certificado->bool_imagem = 1;
		else
			$certificado->bool_imagem = 0;
		$resultado[] = $certificado;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>