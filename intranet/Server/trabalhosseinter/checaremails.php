<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$filtros = array();
	$queryString = "
		SELECT es_trabalho_caint.*, es_inscritos.email
		FROM es_trabalho_caint
		 INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho_caint.fgk_status
		 INNER JOIN es_inscritos ON es_inscritos.id = es_trabalho_caint.fgk_inscrito
		WHERE es_trabalho_caint.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho_caint.nome_aluno 			LIKE ? OR
			es_trabalho_caint.curso_aluno 			LIKE ? OR
			es_trabalho_caint.cidade_destino		LIKE ? OR
			es_trabalho_caint.pais_destino 			LIKE ? OR
			es_trabalho_caint.curso_destino 		LIKE ? OR
			es_trabalho_caint.universidade_destino	LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['cpf'])&&($_REQUEST['cpf']!='')){
			$cpf = $_REQUEST['cpf'];
			$queryString.= " AND es_trabalho_caint.cpf LIKE ?";
			$filtros[] = $cpf;
		}
		if(isset($_REQUEST['nome_aluno'])&&($_REQUEST['nome_aluno']!='')){
			$nome_aluno = $_REQUEST['nome_aluno'];
			$queryString.= " AND es_trabalho_caint.nome_aluno = ?";
			$filtros[] = $nome_aluno;
		}
		if(isset($_REQUEST['curso_aluno'])&&($_REQUEST['curso_aluno']!='')){
			$curso_aluno = $_REQUEST['curso_aluno'];
			$queryString.= " AND es_trabalho_caint.curso_aluno = ?";
			$filtros[] = $curso_aluno;
		}
		if(isset($_REQUEST['universidade_destino'])&&($_REQUEST['universidade_destino']!='')){
			$universidade_destino = $_REQUEST['universidade_destino'];
			$queryString.= " AND es_trabalho_caint.universidade_destino = ?";
			$filtros[] = $universidade_destino;
		}
		if(isset($_REQUEST['tempo_afastamento'])&&($_REQUEST['tempo_afastamento']!='')){
			$tempo_afastamento = $_REQUEST['tempo_afastamento'];
			$queryString.= " AND es_trabalho_caint.tempo_afastamento = ?";
			$filtros[] = $tempo_afastamento;
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho_caint.fgk_status = ?";
			$filtros[] = $fgk_status;
		}

	}

	if($_REQUEST['radio'] == 'true'){
		$queryString.= " AND es_trabalho_caint.id = ?";
		$filtros[] = $_REQUEST['id_trabalho'];
	}


	$total = $db->sql_query($queryString,$filtros);


	echo json_encode(array(
		"success" =>true,
		"total" => $total->rowCount()
	));

?>