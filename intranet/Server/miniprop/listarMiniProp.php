<?php
	header('Content-Type: application/json; charset=utf-8');
	// require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$filtros = array();
	$queryString = "
		SELECT SQL_CALC_FOUND_ROWS es_minicursos_propostos.*, es_inscritos.fgk_evento, es_inscritos.nome, es_inscritos.cpf, es_inscritos.email, es_area_especifica.descricao_area_especifica
		FROM es_minicursos_propostos
		 INNER JOIN es_inscritos ON es_inscritos.id = es_minicursos_propostos.fgk_inscrito
		 INNER JOIN es_area_especifica ON es_area_especifica.id = es_minicursos_propostos.fgk_area_especifica
		WHERE es_inscritos.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_inscritos.nome LIKE ? OR
			es_minicursos_propostos.assunto LIKE ? OR
			es_minicursos_propostos.resumo LIKE ? OR
			es_area_especifica.descricao_area_especifica LIKE ? OR
			es_inscritos.email LIKE ? OR
			es_inscritos.cpf LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';		
	}
	$total = $db->sql_query2($queryString,$filtros);
	$queryString.="ORDER BY es_minicursos_propostos.assunto, es_inscritos.nome LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $miniprop){
		if($miniprop->status == 1)
			$miniprop->rend_status = 'Em edição';
		else if($miniprop->status == 2)
			$miniprop->rend_status = 'Submetido';
		else if($miniprop->status == 3)
			$miniprop->rend_status = 'Aprovado';
		else if($miniprop->status == 4)
			$miniprop->rend_status = 'Regeitado';
		$resultado[] = $miniprop;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>