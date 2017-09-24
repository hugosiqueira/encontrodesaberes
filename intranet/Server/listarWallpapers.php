<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../includes/db_connect.php");

	$queryString = "
		SELECT desk_temas.* FROM desk_temas ORDER BY tema ASC
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error());
	
	
	// { img: img, text: me.getTextOfWallpaper(img), iconCls: '', leaf: true };
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$registro['tema'] = utf8_encode($registro['tema']);
		$registro['leaf'] = true;
		$registro['text'] = $registro['tema'];
		$resposta[] = $registro;
	}
	
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $resposta
	));
?>