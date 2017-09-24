<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_trabalho = $_POST['id_trabalho'];
	$novo_status = $_POST['novo_status'];

	$query = sprintf("
		UPDATE es_trabalho
		SET fgk_status				= %d		
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$novo_status),
			mysqli_real_escape_string($mysqli,$id_trabalho)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>