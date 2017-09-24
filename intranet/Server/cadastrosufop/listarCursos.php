<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_cursos.fgk_departamento LIKE '%$buscaRapida%' OR
			es_ufop_cursos.codigo LIKE '%$buscaRapida%' OR
			es_area_especifica.descricao_area_especifica LIKE '%$buscaRapida%' OR
			es_ufop_cursos.descricao_curso LIKE '%$buscaRapida%' OR
			es_ufop_cursos.modalidade LIKE '%$buscaRapida%' 
		)";
	}
	$queryString = "
		SELECT es_ufop_cursos.*, es_area_especifica.descricao_area_especifica
		FROM es_ufop_cursos
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_ufop_cursos.fgk_area_especifica
		WHERE
		 $filtro
		ORDER BY descricao_curso ASC, modalidade ASC
		LIMIT $start, $limit
	";
	$queryTotal = "SELECT count(*) as num
		FROM es_ufop_cursos
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_ufop_cursos.fgk_area_especifica
		WHERE
		 $filtro
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['rend_curso'] = $registro['descricao_curso'] ." - ". $registro['modalidade'];		
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