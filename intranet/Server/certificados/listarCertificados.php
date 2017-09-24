<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();
	
	$queryString = "
		SELECT es_certificados.*, es_certificados_tipos.descricao_certificado
		FROM es_certificados
		 INNER JOIN es_certificados_tipos ON es_certificados_tipos.id_tipo_certificado = es_certificados.fgk_tipo
		WHERE es_certificados.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_certificados.nome LIKE ? OR
			es_certificados_tipos.descricao_certificado LIKE ? OR
			es_certificados.cpf LIKE ? OR
			es_certificados.chave_autenticidade LIKE ? 
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	
	$total = $db->sql_query2($queryString,$filtros);	
	$queryString.=" ORDER BY es_certificados.data_emissao DESC LIMIT ? , ?;";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);

	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $res)
		$resultado[] = $res;
	
	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>