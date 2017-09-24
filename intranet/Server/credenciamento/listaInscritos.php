<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$queryInscritos = "SELECT es_inscritos.id AS fgk_inscrito, es_inscritos.nome, es_inscritos.cpf, CONCAT(nome, ' - ', cpf) AS display FROM es_inscritos 
		WHERE es_inscritos.fgk_evento = $id_evento 
		AND es_inscritos.bool_cracha = ?";

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryInscritos.=" AND ((es_inscritos.nome LIKE '%$filtro%') OR (es_inscritos.cpf LIKE '%$filtro%')) "; 
	}
	
	$vars = array('bool'=> 1, 'start'=> 0, 'limit'=> 20);
	$queryInscritos.=" ORDER BY es_inscritos.nome ASC LIMIT ?, ?";
	$result = $db->sql_query2($queryInscritos, $vars);

	$inscritos = array();
	foreach ($result as $inscrito){
		$inscritos[] = $inscrito;
	}

	echo json_encode(array(
		"success" => true,
		"inscritos" => $inscritos
	));
?>