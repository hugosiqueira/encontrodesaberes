<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_trabalho = $_POST['id_trabalho'];
	
	$query = sprintf("
		UPDATE es_trabalho
		SET fgk_status				= 2
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$id_trabalho)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

	
	$query = sprintf("
		DELETE FROM es_avaliacao WHERE bool_caint = 0 AND id = %d",
		mysqli_real_escape_string($mysqli, $id_trabalho)
	);
	mysqli_query($mysqli,$query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>