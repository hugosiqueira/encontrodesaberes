<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");
	require_once '../includes/functions.php';
	sec_session_start();

	//exibir somente os eventos vinculados ao funcionário logado
	$id_usuario_logado = $_SESSION['primeiro_user'];
	$queryString = "
		SELECT fgk_grupo
		FROM desk_usuarios_grupos
		WHERE fgk_usuario = $id_usuario_logado
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$registro = mysqli_fetch_assoc($query);
	$id_grupo = $registro['fgk_grupo'];

	if($id_grupo == '1'){
		//SUPER ADMIN, LISTA TODOS OS EVENTOS
		$queryString = "
			SELECT es_evento.id, es_evento.titulo, es_evento.sigla FROM es_evento ORDER BY edicao DESC, titulo ASC
		";
	}
	else{
		// USUÁRIO NÃO É SUPERADMIN, LISTA SOMENTE EVENTOS VINCULADOS
		$queryString = "
			SELECT es_evento.id, es_evento.titulo, es_evento.sigla
			FROM es_evento
			 INNER JOIN desk_usuarios_evento ON desk_usuarios_evento.fgk_evento = es_evento.id
			WHERE desk_usuarios_evento.fgk_usuario = $id_usuario_logado
			ORDER BY edicao DESC, titulo ASC
		";
	}
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));

	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id_evento = $registro['id'];
		$sigla = $registro['sigla'];
		$titulo = $registro['titulo'];
		$registro['formatacao_evento'] = $sigla." - ".$titulo;
	    $resposta[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $resposta
	));
?>