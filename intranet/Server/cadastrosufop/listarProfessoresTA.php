<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	if(isset($_REQUEST['pa'])){
		$apresentacao_obrigatoria 			= $_REQUEST['apresentacao_obrigatoria'];
		$fgk_status 			= $_REQUEST['fgk_status'];
		$fgk_orgao_fomento 			= $_REQUEST['fgk_orgao_fomento'];
		$fgk_categoria 			= $_REQUEST['fgk_categoria'];
		$fgk_area			= $_REQUEST['fgk_area'];
		$fgk_area_especifica 	= $_REQUEST['fgk_area_especifica'];
		$fgk_tipo_apresentacao 	= $_REQUEST['fgk_tipo_apresentacao'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s AND %s AND %s ",
			($_REQUEST['fgk_status'])		? "( es_trabalho.fgk_status = $fgk_status )" 	: "1",
			($_REQUEST['fgk_orgao_fomento'])? "( es_trabalho.fgk_orgao_fomento = $fgk_orgao_fomento )" 	: "1",
			($_REQUEST['fgk_categoria'])	? "( es_trabalho.fgk_categoria = $fgk_categoria )" 	: "1",
			($_REQUEST['fgk_area'])			? "( es_trabalho.fgk_area = $fgk_area )" 			: "1",
			($_REQUEST['fgk_area_especifica'])? "( es_trabalho.fgk_area_especifica = $fgk_area_especifica )"	: "1",
			($_REQUEST['fgk_tipo_apresentacao'])? "( es_trabalho.fgk_tipo_apresentacao = '$fgk_tipo_apresentacao' )"		: "1"
		);
	}
	else{
		$busca_avancada = "";
	}

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_professores.nome LIKE '%$buscaRapida%' OR
			es_ufop_professores.fgk_departamento LIKE '%$buscaRapida%' OR
			es_ufop_professores.cod_siape LIKE '%$buscaRapida%' OR
			es_ufop_professores.email LIKE '%$buscaRapida%' OR
			es_ufop_professores.cpf LIKE '%$buscaRapida%'
		)";
	}

	$queryString = "
		SELECT es_ufop_professores.*, es_ufop_departamentos.nome_departamento
		FROM es_ufop_professores
		 INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_professores.fgk_departamento
		WHERE $filtro
		 $busca_avancada
		ORDER BY nome ASC
		LIMIT $start, $limit
	";
	$queryTotal = "SELECT count(*) as num
		FROM es_ufop_professores
		 INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_professores.fgk_departamento
		WHERE $filtro
		 $busca_avancada
	";

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