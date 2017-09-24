<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryString = "SELECT es_projeto.id, es_projeto.fgk_instituicao, es_trabalho.fgk_status, es_projeto.fgk_area, es_projeto.fgk_area_especifica, es_projeto.fgk_orgao_fomento, fgk_programa_ic, fgk_departamento, 
	es_projeto.fgk_categoria, aluno, aluno_cpf, es_projeto.apresentacao_obrigatoria, codigo_area, orientador, orientador_cpf, sigla_categoria, titulo,  
	 es_orgao_fomento.sigla AS sigla_orgao, es_programa_ic.sigla AS sigla_programa, es_programa_ic.nome AS nome_programa_ic, 
	 				IF(es_trabalho.id, 1, 0) AS bool_trabalho 
					FROM es_projeto 
					INNER JOIN es_ufop_areas ON es_projeto.fgk_area = es_ufop_areas.id_area 
					INNER JOIN es_programa_ic ON es_projeto.fgk_programa_ic = es_programa_ic.id
					LEFT JOIN es_categorias ON es_projeto.fgk_categoria = es_categorias.id_categoria 
					LEFT JOIN es_trabalho ON es_projeto.id = es_trabalho.fgk_projeto
					INNER JOIN es_orgao_fomento ON es_projeto.fgk_orgao_fomento = es_orgao_fomento.id 
					WHERE es_projeto.fgk_evento = $id_evento ";

	if(isset($_REQUEST['cpf']) && ($_REQUEST['cpf'] != '')){
		$cpf = $_REQUEST['cpf'];
		$queryString.=" AND es_projeto.aluno_cpf = '$cpf' OR es_projeto.orientador_cpf = '$cpf'"; 
	}

	if(isset($_REQUEST['nome']) && ($_REQUEST['nome'] != '')){
		$nome = $_REQUEST['nome'];
		$queryString.=" AND es_projeto.aluno LIKE '%$nome%' OR es_projeto.orientador LIKE '%$nome%'"; 
	}

	if(isset($_REQUEST['email']) && ($_REQUEST['email'] != '')){
		$email = $_REQUEST['email'];
		$queryString.=" AND es_projeto.aluno_email LIKE '%$email%' OR es_projeto.orientador_email LIKE '%$email%'"; 
	}

	if(isset($_REQUEST['titulo']) && ($_REQUEST['titulo'] != '')){
		$titulo = $_REQUEST['titulo'];
		$queryString.=" AND es_projeto.titulo LIKE '%$titulo%'";
	}

	if(isset($_REQUEST['fgk_area']) && ($_REQUEST['fgk_area'] != '')){
		$fgk_area = $_REQUEST['fgk_area'];
		$queryString.=" AND es_projeto.fgk_area = $fgk_area";
	}

	if(isset($_REQUEST['fgk_categoria']) && ($_REQUEST['fgk_categoria'] != '')){
		$fgk_categoria = $_REQUEST['fgk_categoria'];
		$queryString.=" AND es_projeto.fgk_categoria = $fgk_categoria";
	}

	if(isset($_REQUEST['fgk_programa_ic']) && ($_REQUEST['fgk_programa_ic'] != '')){
		$fgk_programa_ic = $_REQUEST['fgk_programa_ic'];
		$queryString.=" AND es_projeto.fgk_programa_ic = $fgk_programa_ic";
	}

	if(isset($_REQUEST['fgk_departamento']) && ($_REQUEST['fgk_departamento'] != '')){
		$fgk_departamento = $_REQUEST['fgk_departamento'];
		$queryString.=" AND es_projeto.fgk_departamento = '$fgk_departamento'";
	}

	if(isset($_REQUEST['fgk_orgao_fomento']) && ($_REQUEST['fgk_orgao_fomento'] != '')){
		$fgk_orgao_fomento = $_REQUEST['fgk_orgao_fomento'];
		$queryString.=" AND es_projeto.fgk_orgao_fomento = $fgk_orgao_fomento";
	}

	if(isset($_REQUEST['fgk_area_especifica']) && ($_REQUEST['fgk_area_especifica'] != '')){
		$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
		$queryString.=" AND es_projeto.fgk_area_especifica = $fgk_area_especifica";
	}

	if(isset($_REQUEST['apresentacao_obrigatoria']) && ($_REQUEST['apresentacao_obrigatoria'] != '')){
		$apresentacao_obrigatoria = $_REQUEST['apresentacao_obrigatoria'];
		$queryString.=" AND es_projeto.apresentacao_obrigatoria = $apresentacao_obrigatoria";
	}

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND sigla_categoria LIKE '%$filtro%' OR 
						aluno LIKE '%$filtro%' OR 
						orientador LIKE '%$filtro%' OR
						titulo LIKE '%$filtro%'"; 
	}

	$queryString.=" ORDER BY es_projeto.datahora_registro DESC ";	
		
	$projetos = array();
	$total = $db->sql_query($queryString);

	$queryString.=" LIMIT $start, $limit; ";
	$query = $db->sql_query($queryString);

	foreach ($query as $projeto){
		$projetos[] = $projeto;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"projetos" => $projetos
	));
?>