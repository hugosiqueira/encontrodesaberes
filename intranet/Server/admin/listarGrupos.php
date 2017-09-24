<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once("../../includes/functions.php");
	sec_session_start();
	

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			grupo 				LIKE 	'%$buscaRapida%'	OR
			descricao_grupo		LIKE 	'%$buscaRapida%'			
		)";
	}
	if($_SESSION['primeiro_grupo']=='1'){
		$queryString = "
			SELECT desk_grupos.* FROM desk_grupos WHERE $filtro ORDER BY grupo ASC LIMIT $start,  $limit
		";
	}
	else{
		$queryString = "
			SELECT desk_grupos.* FROM desk_grupos WHERE $filtro AND id_grupo <> '1' ORDER BY grupo ASC LIMIT $start,  $limit
		";
	}
	
	
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id_grupo = $registro['id_grupo'];
		$registro['grupo'] = $registro['grupo'];
		$registro['descricao_grupo'] = $registro['descricao_grupo'];
			$qryUsuarios = mysqli_query($mysqli,"SELECT count(*) as usuarios FROM desk_usuarios_grupos WHERE fgk_grupo = $id_grupo") or die(mysqli_error($mysqli));
			$rowUsuarios = mysqli_fetch_assoc($qryUsuarios);
			$usuarios = $rowUsuarios['usuarios'];
		$registro['usuarios'] = $usuarios;
	    $resposta[] = $registro;
	}
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resposta),
		"resultado" => $resposta
	));
?>