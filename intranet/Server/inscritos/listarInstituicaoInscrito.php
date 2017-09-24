<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	
	$queryString = "
		SELECT es_instituicao.*
		FROM es_instituicao
		WHERE 1 ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" AND ((es_instituicao.nome LIKE '%$filtro%') OR (es_instituicao.sigla LIKE '%$filtro%')) ";
	}

	$query = mysqli_query($mysqli,$queryString." ORDER BY ordem DESC, sigla ASC;") or die(mysqli_error($mysqli));
	$instituicao = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['rend_inst'] = $registro['sigla'] . " - " . $registro['nome'];
		$registro['id_instituicao'] = $registro['id'];
		$instituicao[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($instituicao),
		"resultado" => $instituicao
	));
?>