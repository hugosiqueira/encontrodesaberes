<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$id_inscrito = $_REQUEST['id'];

	$queryPresencas = "	SELECT es_presencas.id_presenca, es_presencas_locais.descricao_local AS checkpoint, es_inscritos.nome, datahora_presenca FROM es_presencas 
						INNER JOIN es_inscritos ON es_presencas.fgk_inscrito = es_inscritos.id 
						INNER JOIN es_presencas_locais ON es_presencas.fgk_local_presenca = es_presencas_locais.id_local_presenca 
						WHERE es_presencas.fgk_evento = ? 
						AND es_presencas.fgk_inscrito = ?
						";
	$vars = array('fgk_evento'=>$id_evento, 'fgk_inscrito'=>$id_inscrito);

	$result = $db->sql_query($queryPresencas."ORDER BY datahora_presenca DESC", $vars);

	$presencas = array();
	foreach ($result as $presenca)
		$presencas[] = $presenca;

	echo json_encode(array(
		"success" => true,
		"presencas" => $presencas
	));
?>