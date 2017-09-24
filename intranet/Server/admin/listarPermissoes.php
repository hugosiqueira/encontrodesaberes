<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			permissao 			LIKE 	'%$buscaRapida%'	OR
			descricao_permissao LIKE 	'%$buscaRapida%'	OR
			nome_modulo 		LIKE 	'%$buscaRapida%'			
		)";
	}
	
	$queryString = "
		SELECT desk_permissoes.*, desk_modulos.nome_modulo FROM desk_permissoes INNER JOIN desk_modulos ON desk_modulos.id_modulo = desk_permissoes.fgk_modulo 
		WHERE $filtro
		ORDER BY permissao ASC LIMIT $start,  $limit";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
	    $resposta[] = $registro;
	}

	$queryTotal = mysqli_query($mysqli,"SELECT count(*) as num FROM desk_permissoes INNER JOIN desk_modulos ON desk_modulos.id_modulo = desk_permissoes.fgk_modulo WHERE $filtro") or die(mysql_error());
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resposta
	));
?>