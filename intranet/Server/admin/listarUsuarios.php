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
			nome_usuario		LIKE 	'%$buscaRapida%'	OR
			login 				LIKE 	'%$buscaRapida%'
		)";
	}

	$queryString = "
		SELECT desk_usuarios.*, desk_grupos.grupo, desk_usuarios_grupos.fgk_grupo
		FROM desk_usuarios
		LEFT JOIN desk_usuarios_grupos ON desk_usuarios_grupos.fgk_usuario = id_usuario
		LEFT JOIN desk_grupos ON desk_usuarios_grupos.fgk_grupo = id_grupo
		WHERE $filtro
		ORDER BY nome_usuario ASC LIMIT $start,  $limit
	";	
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$usuarios = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id_usuario = $registro['id_usuario'];
		$fgk_grupo = $registro['fgk_grupo'];		
		//Conta a quantidade de eventos vinculados no usuário $id_usuario e grava os eventos vinculados em um vetor para comparação
		$x=0;
		$eventos_usuario = array();
		$qryEventos = "SELECT fgk_evento FROM desk_usuarios_evento WHERE fgk_usuario = $id_usuario";
		$qryEventos = mysqli_query($mysqli,$qryEventos) or die(mysqli_error($mysqli));
		while($regEventos = mysqli_fetch_assoc($qryEventos)) {
			$x++;
			$eventos_usuario[] = $regEventos['fgk_evento'];
		}
		if($_SESSION['primeiro_grupo']=='1'){
			if($fgk_grupo=="1")
				$registro['eventos_vinculados'] = '<font size="4">∞</font>';
			else
				$registro['eventos_vinculados'] = $x;
			$usuarios[] = $registro;
		}
		else{
			if($fgk_grupo!="1"){
				//checar se o usuário está no meu evento atual	
				if(in_array($_SESSION['id_evento_atual'], $eventos_usuario)){
					$registro['eventos_vinculados'] = $x;
					$usuarios[] = $registro;
				}
				else if($x==0){ //usuário não está em nenhum evento, então é exibido no grid até ser vinculado
					$registro['eventos_vinculados'] = $x;
					$usuarios[] = $registro;
				}
				else{
					// nada acontece pois o usuário não está no meu evento atual
				}
			}
			else{
				// nada acontece pois não exibirá na lista os Super Admin
			}
		}		
	}	

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($usuarios),
		"resultado" => $usuarios
	));
?>