<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id = $_POST['id'];
	$fgk_area = $_POST['fgk_area'];
	$fgk_area_especifica = $_POST['fgk_area_especifica'];
	$bool_avaliador_prograd = $_POST['bool_avaliador_prograd'];
	$bool_avaliador_proex = $_POST['bool_avaliador_proex'];
	$bool_avaliador_caint = $_POST['bool_avaliador_caint'];
	
	$atualizar_revisor = array(
		'fgk_area'=>$fgk_area,
		'fgk_area_especifica'=>$fgk_area_especifica,
		'bool_avaliador_prograd'=>$bool_avaliador_prograd,
		'bool_avaliador_proex'=>$bool_avaliador_proex,
		'bool_avaliador_caint'=>$bool_avaliador_caint
	);

	$db->atualizar('es_avaliacao_revisor', $atualizar_revisor, 'id', $id);

	echo json_encode(array(
		"success" => true,
		"msg" => "Revisor atualizado com sucesso."
	));
?>