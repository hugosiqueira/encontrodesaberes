<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryAlunos= "SELECT nome, descricao_curso, cpf FROM es_ufop_alunos 
		LEFT JOIN es_ufop_cursos ON es_ufop_alunos.fgk_curso = es_ufop_cursos.codigo";

	$total = $db->sql_query($queryAlunos);

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryAlunos.=" WHERE (nome LIKE '%$filtro%') OR (descricao_curso LIKE '%$filtro%') OR (cpf LIKE '%$filtro%')"; 
	}

	$queryAlunos.=" ORDER BY es_ufop_alunos.nome ASC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryAlunos);

	$alunos = array();
	foreach ($result as $aluno)
		$alunos[] = $aluno;

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"alunos" => $alunos
	));
?>