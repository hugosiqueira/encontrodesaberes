<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$filtros = array();

	$queryString = "
		SELECT es_trabalho_seminario.*, es_trabalho_status.descricao_status, es_ufop_areas.descricao_area
		FROM es_trabalho_seminario
		 INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho_seminario.fgk_status
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho_seminario.fgk_area
		WHERE es_trabalho_seminario.fgk_evento = ?		
	";
	$filtros[] = $id_evento_atual;
	
	if(isset($_REQUEST['pa'])&&($_REQUEST['pa']=='1')){
		if(isset($_REQUEST['aluno_nome'])&&($_REQUEST['aluno_nome']!='')){
			$aluno_nome = $_REQUEST['aluno_nome'];
			$queryString.= " AND es_trabalho_seminario.aluno_nome LIKE ?";
			$filtros[] = '%'.$aluno_nome.'%';
		}
		if(isset($_REQUEST['aluno_cpf'])&&($_REQUEST['aluno_cpf']!='')){
			$aluno_cpf = $_REQUEST['aluno_cpf'];
			$queryString.= " AND es_trabalho_seminario.aluno_cpf = ?";
			$filtros[] = $aluno_cpf;
		}
		if(isset($_REQUEST['orientador_nome'])&&($_REQUEST['orientador_nome']!='')){
			$orientador_nome = $_REQUEST['orientador_nome'];
			$queryString.= " AND es_trabalho_seminario.orientador_nome = ?";
			$filtros[] = $orientador_nome;
		}
		if(isset($_REQUEST['orientador_cpf'])&&($_REQUEST['orientador_cpf']!='')){
			$orientador_cpf = $_REQUEST['orientador_cpf'];
			$queryString.= " AND es_trabalho_seminario.orientador_cpf = ?";
			$filtros[] = $orientador_cpf;
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho_seminario.fgk_status = ?";
			$filtros[] = $fgk_status;
		}
	}
	
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			aluno_nome LIKE ? OR
			aluno_cpf LIKE ? OR
			titulo LIKE ? OR
			orientador_nome LIKE ? OR
			orientador_cpf LIKE ?
		)";
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
		$filtros[] 	= '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString,$filtros);
	$queryString.="ORDER BY aluno_nome LIMIT ?, ? ; ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $monitoria){
		$resultado[] = $monitoria;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>