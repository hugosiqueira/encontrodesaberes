<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT desk_estados.*, CONCAT(descricao_estado,' - ',uf) AS descricao_estado_uf
		FROM desk_estados ";

	if(isset($_REQUEST['filtro'])&&($_REQUEST['filtro']!="")){
		$filtro = $_REQUEST['filtro'];
		$queryString.=" WHERE (descricao_estado LIKE '%$filtro%') OR (uf LIKE '%$filtro%')";
	}

	$query = mysqli_query($mysqli,$queryString." ORDER BY desk_estados.uf") or die(mysqli_error($mysqli));
	$estados = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$estados[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($estados),
		"resultado" => $estados
	));
?>