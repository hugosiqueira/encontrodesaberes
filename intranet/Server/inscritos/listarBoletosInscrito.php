<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_inscrito = $_REQUEST['id_inscrito'];

	$queryString = "
		SELECT es_inscritos_boletos.*
		FROM es_inscritos_boletos
		WHERE es_inscritos_boletos.fgk_inscrito = $id_inscrito 
		ORDER BY es_inscritos_boletos.status ASC, es_inscritos_boletos.data_vencimento ASC
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$boletos = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$boletos[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($boletos),
		"resultado" => $boletos
	));
?>