<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$cpf = $_POST['cpf'];
	$filtros = array();
	$busca = "
		SELECT es_inscritos.id, es_inscritos.nome, es_inscritos.email
		FROM es_inscritos
		WHERE fgk_evento = ? AND cpf = ?
	";
	$filtros[] = intval($id_evento_atual);
	$filtros[] = $cpf;
	$inscrito = $db->sql_query2($busca, $filtros);
	if($inscrito->rowCount() > 0){
		foreach ($inscrito as $registro) {
			echo json_encode(array(
				"success" => true,
				"nome" => $registro->nome,
				"email" => $registro->email,
			));
			exit;
		}
	}
	else{
		echo json_encode(array(
			"success" => false
		));
		exit;
	}
?>