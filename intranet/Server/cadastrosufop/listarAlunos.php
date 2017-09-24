<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	if(isset($_REQUEST['pa'])){
		$fgk_curso 		= $_REQUEST['fgk_curso'];
		$bool_monitoria 		= $_REQUEST['bool_monitoria'];
		$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
		$mobilidade_ano_atual = $_REQUEST['mobilidade_ano_atual'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s ",
			($fgk_curso!="")	? "( es_ufop_alunos.fgk_curso = '$fgk_curso' )" 	: "1",
			($bool_monitoria!="-1")	? "( es_ufop_alunos.bool_monitoria = $bool_monitoria )" 	: "1",
			($mobilidade_ano_passado!="-1")? "( es_ufop_alunos.mobilidade_ano_passado = $mobilidade_ano_passado )" 	: "1",
			($mobilidade_ano_atual!="-1")? "( es_ufop_alunos.mobilidade_ano_atual = $mobilidade_ano_atual )" 	: "1"
		);
	}
	else{
		$busca_avancada = "";
	}
	
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_alunos.nome LIKE '%$buscaRapida%' OR
			es_ufop_alunos.cpf LIKE '%$buscaRapida%' OR
			es_ufop_alunos.matricula LIKE '%$buscaRapida%' OR
			es_ufop_cursos.descricao_curso LIKE '%$buscaRapida%' OR
			es_ufop_alunos.email LIKE '%$buscaRapida%'
		)";
	}

	$queryString = "
		SELECT es_ufop_alunos.*, es_ufop_cursos.descricao_curso
		FROM es_ufop_alunos
		 INNER JOIN es_ufop_cursos ON es_ufop_cursos.codigo = es_ufop_alunos.fgk_curso
		WHERE $filtro
		 $busca_avancada
		ORDER BY nome ASC
		LIMIT $start, $limit
	";
	$queryTotal = "SELECT count(*) as num
		FROM es_ufop_alunos
		 INNER JOIN es_ufop_cursos ON es_ufop_cursos.codigo = es_ufop_alunos.fgk_curso
		WHERE $filtro
		 $busca_avancada
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {		
		$resultado[] = $registro;
	}
	$queryTotal = mysqli_query($mysqli,$queryTotal) or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resultado
	));
?>