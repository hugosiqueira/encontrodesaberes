<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			edicao 				LIKE 	'%$buscaRapida%'
		)";
	}
	$queryString = "
		SELECT es_evento.*
		,DATE_FORMAT(data_evento_ini,'%H:%i:%s') AS hora_evento_ini
		,DATE_FORMAT(data_evento_fim,'%H:%i:%s') AS hora_evento_fim
		
		,DATE_FORMAT(data_inscricao_ini,'%H:%i:%s') AS hora_inscricao_ini
		,DATE_FORMAT(data_inscricao_fim,'%H:%i:%s') AS hora_inscricao_fim
		
		,DATE_FORMAT(data_avaliacao_ini,'%H:%i:%s') AS hora_avaliacao_ini
		,DATE_FORMAT(data_avaliacao_fim,'%H:%i:%s') AS hora_avaliacao_fim
		
		,DATE_FORMAT(data_reavaliacao_ini,'%H:%i:%s') AS hora_reavaliacao_ini
		,DATE_FORMAT(data_reavaliacao_fim,'%H:%i:%s') AS hora_reavaliacao_fim
		
		,DATE_FORMAT(data_submissao_ini,'%H:%i:%s') AS hora_submissao_ini
		,DATE_FORMAT(data_submissao_fim,'%H:%i:%s') AS hora_submissao_fim
		
		,DATE_FORMAT(data_submissao_adequacao_ini,'%H:%i:%s') AS hora_submissao_adequacao_ini
		,DATE_FORMAT(data_submissao_adequacao_fim,'%H:%i:%s') AS hora_submissao_adequacao_fim
		
		,DATE_FORMAT(data_ini_parecer_final,'%H:%i:%s') AS hora_ini_parecer_final
		,DATE_FORMAT(data_fim_parecer_final,'%H:%i:%s') AS hora_fim_parecer_final
		
		,DATE_FORMAT(data_ini_primeiro_parecer,'%H:%i:%s') AS hora_ini_primeiro_parecer
		,DATE_FORMAT(data_fim_primeiro_parecer,'%H:%i:%s') AS hora_fim_primeiro_parecer
		
		,DATE_FORMAT(data_ini_submissao_minicurso,'%H:%i:%s') AS hora_ini_submissao_minicurso
		,DATE_FORMAT(data_fim_submissao_minicurso,'%H:%i:%s') AS hora_fim_submissao_minicurso
		
		
		FROM es_evento WHERE $filtro ORDER BY data_evento_ini DESC LIMIT $start,  $limit";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));

	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id_evento = $registro['id'];
		$qryUsuarios = mysqli_query($mysqli,"SELECT count(*) as usuarios FROM desk_usuarios_evento INNER JOIN desk_usuarios_grupos ON desk_usuarios_grupos.fgk_usuario = desk_usuarios_evento.fgk_usuario WHERE fgk_evento = $id_evento AND desk_usuarios_grupos.fgk_grupo <> 1") or die(mysqli_error($mysqli));
		$rowUsuarios = mysqli_fetch_assoc($qryUsuarios);
		$usuarios = $rowUsuarios['usuarios'];
		$registro['usuarios'] = $usuarios;
		$arquivo = $id_evento.".jpg";

		$caminho = '../../resources/wallpapers/'.$arquivo;
		if (!file_exists($caminho)) {
			$arquivo = "0";
		}
		$registro['bool_wall'] = $arquivo;
	    $resposta[] = $registro;
	}

	$queryTotal = mysqli_query($mysqli,"SELECT count(*) as num FROM es_evento WHERE $filtro") or die(mysqli_error($mysqli));
	$row = mysqli_fetch_assoc($queryTotal);
	$total = $row['num'];

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => $total,
		"resultado" => $resposta
	));
?>