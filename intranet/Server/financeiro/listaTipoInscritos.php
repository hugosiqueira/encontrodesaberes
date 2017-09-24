<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$queryTipoInscritos = "SELECT id_tipo_inscrito, descricao_tipo
						FROM es_inscritos_tipos 
						WHERE 1";
						// WHERE fgk_evento = ?";

	// $vars = array('fgk_evento'=> $id_evento);
		$vars = array();

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryTipoInscritos.=" AND descricao_tipo LIKE ? ";
		$vars['descricao_tipo'] = '%'.$filtro.'%';
	}

	$result = $db->sql_query($queryTipoInscritos, $vars);

	$tipo_inscritos = array();
	foreach ($result as $tipo){
		$tipo_inscritos[] = $tipo;
	}

	echo json_encode(array(
		"success" => true,
		"tipo_inscritos" => $tipo_inscritos
	));
?>