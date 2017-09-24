<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$id_evento_atual = $_SESSION['id_evento_atual'];

	if(isset($_REQUEST['pa'])){
		$cpf 					= $_REQUEST['cpf'];
		$fgk_tipo 				= $_REQUEST['fgk_tipo'];
		$fgk_instituicao 		= $_REQUEST['fgk_instituicao'];
		// echo $fgk_instituicao. "<br/>";
		$fgk_departamento 		= $_REQUEST['fgk_departamento'];
		$departamento 			= $_REQUEST['departamento'];
		$fgk_curso 				= $_REQUEST['fgk_curso'];
		$curso 					= $_REQUEST['curso'];
		
		$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
		$bool_monitoria			= $_REQUEST['bool_monitoria'];
		$bool_temp				= $_REQUEST['bool_temp'];
		$conta_ativada			= $_REQUEST['conta_ativada'];
		$bool_coordenador		= $_REQUEST['bool_coordenador'];
		$bool_revisor			= $_REQUEST['bool_revisor'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s AND %s ",
			($_REQUEST['cpf'])						? "( es_inscritos.cpf = '$cpf' )" 	: "1",
			($_REQUEST['fgk_tipo'])					? "( es_inscritos.fgk_tipo = $fgk_tipo )" 	: "1",
			($_REQUEST['fgk_instituicao'])			? "( es_inscritos.fgk_instituicao = $fgk_instituicao )"	: "1",
			($_REQUEST['fgk_departamento'])			? "( es_inscritos.fgk_departamento = '$fgk_departamento' )"	: "1",
			($_REQUEST['departamento'])				? "( es_inscritos.departamento = '$departamento' )"	: "1",
			($_REQUEST['fgk_curso'])				? "( es_inscritos.fgk_curso = '$fgk_curso' )"	: "1",
			($_REQUEST['curso'])					? "( es_inscritos.curso = '$curso' )"	: "1",
			($_REQUEST['mobilidade_ano_passado']>-1)? "( es_inscritos.mobilidade_ano_passado = '$mobilidade_ano_passado' )"	: "1",
			($_REQUEST['bool_monitoria']>-1)		? "( es_inscritos.bool_monitoria = '$bool_monitoria' )"	: "1",
			($_REQUEST['bool_temp']>-1)				? "( es_inscritos.bool_temp = '$bool_temp' )"	: "1",
			($_REQUEST['conta_ativada']>-1)			? "( es_inscritos.conta_ativada = '$conta_ativada' )"	: "1",
			($_REQUEST['bool_coordenador']>-1)		? "( es_inscritos.bool_coordenador = '$bool_coordenador' )"	: "1",
			($_REQUEST['bool_revisor']>-1)			? "( es_inscritos.bool_revisor = '$bool_revisor' )"	: "1"
		);
	}
	else{
		$busca_avancada = "";
	}
	// echo $busca_avancada;
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
				es_inscritos.nome LIKE '%$buscaRapida%' OR
				es_inscritos.matricula LIKE '%$buscaRapida%' OR
				es_inscritos.curso LIKE '%$buscaRapida%' OR
				es_inscritos.departamento LIKE '%$buscaRapida%' OR
				es_inscritos.cpf LIKE '%$buscaRapida%'
			)";
	}

	$queryString = "
		SELECT es_inscritos.*, es_inscritos_tipos.descricao_tipo, es_evento.sigla, es_instituicao.sigla AS sigla_instituicao, es_instituicao.nome AS nome_instituicao, es_ufop_departamentos.nome_departamento, es_ufop_cursos.descricao_curso, desk_estados.id_estado
		FROM es_inscritos
		 LEFT JOIN es_inscritos_tipos ON es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
		 INNER JOIN es_evento ON es_evento.id = es_inscritos.fgk_evento
		 LEFT JOIN es_instituicao ON es_instituicao.id = es_inscritos.fgk_instituicao
		 LEFT JOIN desk_estados ON desk_estados.uf = es_inscritos.estado
		 LEFT JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_inscritos.fgk_departamento AND es_inscritos.fgk_departamento <>  '0'
		 LEFT JOIN es_ufop_cursos ON es_ufop_cursos.id_curso = es_inscritos.fgk_curso AND es_inscritos.fgk_curso > 0
		WHERE $filtro
		 AND es_evento.id = $id_evento_atual
		 $busca_avancada
		ORDER BY es_inscritos.nome
		LIMIT $start, $limit
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$inscritos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		if( $registro['fgk_curso']=="0" || $registro['fgk_curso']=="" )
			$registro['descricao_curso'] = $registro['curso'];
		if( $registro['fgk_departamento']=="0" || $registro['fgk_curso']=="" )
			$registro['nome_departamento'] = $registro['departamento'];
		$registro['rend_inst'] = $registro['sigla_instituicao'] . " - " . $registro['nome_instituicao'];
		$inscritos[] = $registro;
	}
	$queryTotal = mysqli_query($mysqli,"SELECT count(*) as num FROM es_inscritos
		 LEFT JOIN es_inscritos_tipos ON es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
		 INNER JOIN es_evento ON es_evento.id = es_inscritos.fgk_evento
		 LEFT JOIN es_instituicao ON es_instituicao.id = es_inscritos.fgk_instituicao
		 LEFT JOIN desk_estados ON desk_estados.uf = es_inscritos.estado
		 LEFT JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_inscritos.fgk_departamento AND es_inscritos.fgk_departamento <>  '0'
		 LEFT JOIN es_ufop_cursos ON es_ufop_cursos.id_curso = es_inscritos.fgk_curso AND es_inscritos.fgk_curso > 0
		WHERE $filtro
		 AND es_evento.id = $id_evento_atual
		 $busca_avancada") or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $inscritos
	));
?>