<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['usuarioevento'];

	$dados = json_decode($json, true);
	
	$id_evento 		= $dados['id'];
	$fgk_usuario 	= $dados['fgk_usuario'];
	$bool_liberado 	= $dados['bool_liberado'];
	
	if($bool_liberado == 1){ // ADICIOANR EVENTO
		$query = sprintf("
			INSERT INTO desk_usuarios_evento
			(	fgk_evento, fgk_usuario)
			values 
			(	%d, %d )",
				mysqli_real_escape_string($mysqli,$id_evento),	
				mysqli_real_escape_string($mysqli,$fgk_usuario)
		);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	}
	else{ // REMOVER PERMISSÃO
		$query = sprintf("
			DELETE FROM desk_usuarios_evento WHERE fgk_evento = %d AND fgk_usuario = %d",
			mysqli_real_escape_string($mysqli, $id_evento),
			mysqli_real_escape_string($mysqli, $fgk_usuario)
		);
		mysqli_query($mysqli,$query);			
	}			

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>