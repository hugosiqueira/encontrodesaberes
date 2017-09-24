<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');

	$json = $_POST['ids'];
	$dados = json_decode($json);
	$fgk_inscrito = $_POST['inscrito'];

	foreach ($dados as $id){
		$query = "UPDATE es_presencas SET fgk_inscrito = ? WHERE id_presenca = ?";

		$vars = array('fgk_inscrito'=>$fgk_inscrito, 'id_presenca'=>$id);
		$result = $db->sql_query2($query, $vars);
	}

	echo json_encode( array(
		"success" => true
	));
?>