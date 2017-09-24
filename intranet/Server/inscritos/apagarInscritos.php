<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$id_inscrito = $_POST['id_inscrito'];

	/*apagar ordem dia*/
	$query = sprintf("
		DELETE FROM es_inscritos WHERE id = %d",
		mysqli_real_escape_string($mysqli, $id_inscrito)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>