<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';	
	require_once('../../includes/db_connect.php');
	sec_session_start();
	
	$id_evento = $_SESSION['id_evento_atual'];
	$id_revisor = $_REQUEST['id_revisor'];
	
	// $queryString = "
		// SELECT DISTINCT( es_avaliacao.fgk_trabalho ) AS id_trabalho, es_trabalho.titulo_enviado, es_avaliacao.fgk_revisor1, es_avaliacao.fgk_revisor2, es_avaliacao_revisao.id AS id_avaliacao_revisao, es_avaliacao_revisao.status AS status_avaliacao_revisao
		// FROM es_avaliacao
		 // INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho
		 // INNER JOIN es_avaliacao_revisor ON (es_avaliacao_revisor.id = es_avaliacao.fgk_revisor1 OR es_avaliacao_revisor.id = es_avaliacao.fgk_revisor2)
		  // LEFT JOIN es_avaliacao_revisao ON es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id
		// WHERE es_trabalho.fgk_evento = ?
		// AND ( (es_avaliacao.fgk_revisor1 = ? OR es_avaliacao.fgk_revisor2 = ? )AND (es_avaliacao_revisao.fgk_revisor = ? OR es_avaliacao_revisao.fgk_revisor IS NULL) )
		// GROUP BY es_avaliacao.fgk_trabalho
	// ";
	$queryString = "
		select titulo_enviado, coalesce(es_avaliacao_revisao.status,0) as status
		from es_avaliacao
		inner join es_trabalho on es_avaliacao.fgk_trabalho = es_trabalho.id

		left join es_avaliacao_revisao on (es_avaliacao.id = es_avaliacao_revisao.fgk_avaliacao) and (es_avaliacao_revisao.fgk_revisor = ?) and (es_avaliacao.bool_caint = 0)
		where es_trabalho.fgk_evento = ? AND (fgk_revisor1 = ? or fgk_revisor2 = ?)
	";
	// AND (es_avaliacao_revisao.fgk_revisor = ? OR es_avaliacao_revisao.fgk_revisor IS NULL)
	$query = $db->sql_query($queryString, array('fgk_revisor'=> $id_revisor,'fgk_evento'=> $id_evento, 'fgk_revisor1'=> $id_revisor, 'fgk_revisor2'=> $id_revisor));
	$resultado = array();
	foreach ($query as $registros){
		$resultado[] = $registros;
	}
	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>