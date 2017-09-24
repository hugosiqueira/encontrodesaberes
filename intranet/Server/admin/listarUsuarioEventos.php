<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	
	sec_session_start();

	$id_usuario_logado = $_SESSION['primeiro_user'];
	$query = "SELECT fgk_grupo FROM desk_usuarios_grupos WHERE fgk_usuario = $id_usuario_logado";
	$query = mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	$registro = mysqli_fetch_assoc($query);
	$id_grupo_logado = $registro['fgk_grupo'];
	$id_usuario_grid = $_POST['id_usuario'];
	

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			edicao 				LIKE 	'%$buscaRapida%'	OR
			titulo 				LIKE 	'%$buscaRapida%'	OR
			sigla 				LIKE 	'%$buscaRapida%'
		)";
	}

	$queryString = "
		SELECT es_evento.id 
		FROM es_evento 
		 INNER JOIN desk_usuarios_evento ON fgk_evento = id
		WHERE $filtro AND desk_usuarios_evento.fgk_usuario = $id_usuario_grid
		ORDER BY data_evento_ini DESC
	";
	$queryString = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$eventos = array();
	while($reg = mysqli_fetch_assoc($queryString)) {
		$eventos[] = $reg['id'];
	}
	
	if($id_grupo_logado == '1'){// Superadmin, pode atribuir todos os eventos
		$queryString = "
			SELECT * FROM es_evento WHERE $filtro ORDER BY data_evento_ini DESC
		";
	}
	else{// Admin, pode atribuir somente eventos que esteja ele mesmo vinculado		
		$queryString = "
			SELECT *
			FROM es_evento 
			 INNER JOIN desk_usuarios_evento ON fgk_evento = id
			WHERE $filtro AND desk_usuarios_evento.fgk_usuario = $id_usuario_logado
			ORDER BY data_evento_ini DESC
		";
	}
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));		
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id_evento = $registro['id'];		
		if(in_array($id_evento, $eventos)){
			$registro['bool_liberado'] = true;
		}
		else{
			$registro['bool_liberado'] = false;	
		}
		$registro['fgk_usuario'] = $id_usuario_grid;
	    $resposta[] = $registro;
	}
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $resposta
	));
	



	
?>