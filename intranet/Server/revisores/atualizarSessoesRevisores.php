<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['sessaorevisor'];
	$dados = json_decode($json);

	if($dados->check == 1){
		$sessaoRevisor = array(
			'fgk_revisor'	=> $dados->fgk_revisor,
			'fgk_sessao'	=> $dados->id
		);
		$db->inserir('es_avaliacao_revisor_horarios', $sessaoRevisor);
	}
	else{
		$filtros = array();
		$queryString = "
			SELECT es_avaliacao_revisor_horarios.id
			FROM es_avaliacao_revisor_horarios
			WHERE fgk_revisor = ? AND fgk_sessao = ?
		";
		$filtros[] = intval($dados->fgk_revisor);
		$filtros[] = intval($dados->id);
		$query = $db->sql_query2($queryString, $filtros);
		foreach ($query as $res)
			$id = $res->id;
		$db->excluir('es_avaliacao_revisor_horarios', 'id', $id);
	}

	echo json_encode(array(
		"success" => true
	));
?>