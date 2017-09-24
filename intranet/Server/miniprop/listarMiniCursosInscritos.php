<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_minicurso = $_REQUEST['id_minicurso'];

	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();

	$queryString = "
		SELECT es_minicursos_inscritos.*, es_inscritos.nome, es_inscritos.email, es_servicos.descricao_servico, es_inscritos_servicos.bool_pago
		FROM es_minicursos_inscritos
		 INNER JOIN es_inscritos_servicos ON es_inscritos_servicos.id_inscrito_servico = es_minicursos_inscritos.fgk_inscrito_servico
	     	 INNER JOIN es_inscritos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito
	     	 INNER JOIN es_servicos ON es_servicos.id_servico = es_inscritos_servicos.fgk_servico
		 INNER JOIN es_minicursos ON es_minicursos.id = es_minicursos_inscritos.fgk_minicurso
		WHERE es_minicursos_inscritos.fgk_minicurso = ?
	";
	$filtros[] = intval($id_minicurso);
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_minicursos.apresentador LIKE ? OR
			es_minicursos.titulo LIKE ? OR
			es_minicursos.resumo LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString,$filtros);

	$queryString.="ORDER BY es_inscritos.nome ASC LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $inscritos){
		$resultado[] = $inscritos;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>