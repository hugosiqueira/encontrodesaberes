<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['grupopermissao'];

	$dados = json_decode($json, true);
	
	$id_permissao = $dados['id_permissao'];
	$id_grupo = $dados['id_grupo'];
	$bool_liberado = $dados['bool_liberado'];
	
	if($bool_liberado == 1){ // ADICIOANR PERMISSÃO
		$query = sprintf("
		INSERT INTO desk_grupos_permissoes
		(	fgk_grupo, fgk_permissao)
		values 
		(	%d, %d )",
			mysqli_real_escape_string($mysqli,$id_grupo),	
			mysqli_real_escape_string($mysqli,$id_permissao)
		);
		mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	}
	else{ // REMOVER PERMISSÃO
		$query = sprintf("
			DELETE FROM desk_grupos_permissoes WHERE fgk_grupo = %d AND fgk_permissao = %d",
			mysqli_real_escape_string($mysqli, $id_grupo),
			mysqli_real_escape_string($mysqli, $id_permissao)
		);
		mysqli_query($mysqli,$query);			
	}			

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>