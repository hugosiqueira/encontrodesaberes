<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	// $id_evento_atual = $_SESSION['id_evento_atual'];

	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();
	
	$queryString = "
		SELECT nome, cpf, if(fgk_tipo=1,'PROFESSOR','TÉCNICO ADMINISTRATIVO') as tipo, nome_departamento, descricao_area,  cod_siape AS matricula_siape
		FROM es_ufop_professores
		 left join es_ufop_departamentos on es_ufop_professores.fgk_departamento = es_ufop_departamentos.id_departamento
		 left join es_ufop_areas on es_ufop_departamentos.fgk_area = es_ufop_areas.id_area
	";
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " WHERE (
			es_ufop_professores.nome LIKE ? OR
			es_ufop_professores.cod_siape LIKE ? OR
			es_ufop_professores.cpf LIKE ?
		) ";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$queryString.= "
		UNION
		SELECT nome, cpf, 'ALUNO' as tipo, nome_departamento, descricao_area,  matricula AS matricula_siape
		FROM es_ufop_alunos
		 left join es_ufop_cursos on es_ufop_alunos.fgk_curso = es_ufop_cursos.id_curso
		 left join es_ufop_departamentos on es_ufop_cursos.fgk_departamento = es_ufop_departamentos.id_departamento
		 left join es_ufop_areas on es_ufop_departamentos.fgk_area = es_ufop_areas.id_area
	";
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " WHERE (
			es_ufop_alunos.nome LIKE ? OR
			es_ufop_alunos.matricula LIKE ? OR
			es_ufop_alunos.cpf LIKE ?
		) ";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}	
	$total = $db->sql_query2($queryString,$filtros);
	$queryString.="ORDER BY nome LIMIT ?, ? ";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString,$filtros);



	$resultado = array();
	foreach ($query as $revisor){
		$resultado[] = $revisor;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"resultado" => $resultado
	));
?>