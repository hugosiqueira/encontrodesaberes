<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_trabalho = $_REQUEST['id_trabalho'];

	$queryString = "
		SELECT es_trabalho_autor.*, es_instituicao.sigla AS sigla_instituicao, es_tipo_autor.descricao_tipo
		FROM es_trabalho_autor
		 LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho_autor.fgk_instituicao
		 INNER JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
		WHERE es_trabalho_autor.fgk_trabalho = $id_trabalho
		ORDER BY es_trabalho_autor.ordenacao
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$resultado = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$resultado[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"total" => count($resultado),
		"resultado" => $resultado
	));
?>