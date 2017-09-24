<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$id_local_presenca = $_REQUEST['id_local'];

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryPresencas = "	SELECT es_inscritos_credencial.info_credencial, es_inscritos.nome, datahora_presenca FROM es_presencas 
						INNER JOIN es_inscritos ON es_presencas.fgk_inscrito = es_inscritos.id 
						LEFT JOIN es_inscritos_credencial ON es_inscritos.id = es_inscritos_credencial.fgk_inscrito 
						WHERE es_presencas.fgk_evento = ? 
						AND es_presencas.fgk_local_presenca = ?
						";
	$vars = array('fgk_evento'=>$id_evento,'fgk_local_presenca'=> $id_local_presenca);


	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryPresencas.=" AND ((es_inscritos.nome LIKE '%$filtro%') OR (es_inscritos_credencial.info_credencial LIKE '%$filtro%'))";
	}


	if(isset($_REQUEST['busca'])&&($_REQUEST['busca'] != "")){
		$jsonBusca = $_REQUEST['busca'];
		$dadosBusca = json_decode($jsonBusca);
			$nome = $dadosBusca->nome;
			$id_checkpoint = $dadosBusca->id_checkpoint;
			$dataMin = $dadosBusca->dateMin;
			$dataMax = $dadosBusca->dateMax;

		if($nome != "")
			$queryPresencas.= " AND (es_inscritos.nome LIKE '%$nome%') ";

		if($id_checkpoint != "")
			$queryPresencas.= " AND (es_presencas.fgk_local_presenca = $id_checkpoint) ";

		if(($dataMin != "")&&($dataMax != "")){
			$queryPresencas.= "AND (es_presencas.datahora_presenca BETWEEN '$dataMin' AND '$dataMax') ";
		}else if($dataMin != ""){
			$queryPresencas.= "AND (es_presencas.datahora_presenca >= '$dataMin') ";
		}else if($dataMax != ""){
			$queryPresencas.= "AND (es_presencas.datahora_presenca <= '$dataMax') ";
		}
	}

	$result = $db->sql_query($queryPresencas."ORDER BY datahora_presenca DESC LIMIT $start, $limit", $vars);

	$presencas = array();
	foreach ($result as $presenca)
		$presencas[] = $presenca;

	echo json_encode(array(
		"success" => true,
		"presencas" => $presencas
	));
?>