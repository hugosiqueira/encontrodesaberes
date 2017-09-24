<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	
	$filtro = "";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "AND (
			nome_modulo 	LIKE 	'%$buscaRapida%'	OR
			name 			LIKE 	'%$buscaRapida%'			
		)";
	}
	
	$queryString = "
		SELECT desk_modulos.* FROM desk_modulos WHERE 1 $filtro ORDER BY nome_modulo ASC LIMIT $start,  $limit";
	
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
	    $resposta[] = $registro;
	}

	$queryTotal = mysqli_query($mysqli,"SELECT count(*) as num FROM desk_modulos WHERE 1 $filtro") or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resposta
	));
?>