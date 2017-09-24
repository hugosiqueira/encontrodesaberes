<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	//busca rapida
	$buscaRapida	= $_REQUEST['buscaRapida'];
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

	//formulário
	$aluno = "";
	if($_REQUEST['aluno'] == 'true'){
		$id = $_REQUEST['id_aluno'];
		$aluno = " AND es_ufop_alunos.id_aluno = $id";
	}
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

	$queryString = "
		SELECT es_ufop_alunos.*, es_ufop_cursos.descricao_curso
		FROM es_ufop_alunos
		 INNER JOIN es_ufop_cursos ON es_ufop_cursos.codigo = es_ufop_alunos.fgk_curso
		WHERE $filtro
		$aluno $busca_avancada
		ORDER BY nome ASC
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$emails = array();
	$contador=0;
	while($registro = mysqli_fetch_assoc($query)) { //todos os trabalhos listados ou selecionado
		$contador++;
		$emails[] = $registro['email'];
	}

	echo json_encode(array(
		"success" =>true,
		"total" => $contador
	));

?>