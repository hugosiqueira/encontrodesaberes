<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['grupomodulo'];

	$dados = json_decode($json, true);
	
	foreach($dados as $data){
		if (is_int($data['id_modulo'])){
			$id_modulo = $data['id_modulo'];
			$id_grupo = $data['id_grupo'];
			$bool_liberado = $data['bool_liberado'];
			
			if($bool_liberado == 1){ // ADICIOANR MODULO
				$query = sprintf("
				INSERT INTO desk_grupos_modulos
				(	fgk_grupo, fgk_modulo)
				values 
				(	%d, %d )",
					mysqli_real_escape_string($mysqli,$id_grupo),	
					mysqli_real_escape_string($mysqli,$id_modulo)
				);
				mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
			}
			else{ // REMOVER MODULO
				$query = sprintf("
					DELETE FROM desk_grupos_modulos WHERE fgk_grupo = %d AND fgk_modulo = %d",
					mysqli_real_escape_string($mysqli, $id_grupo),
					mysqli_real_escape_string($mysqli, $id_modulo)
				);
				mysqli_query($mysqli,$query);			
			}			
		}
		else{
			$id_modulo = $dados['id_modulo'];
			$id_grupo = $dados['id_grupo'];
			$bool_liberado = $dados['bool_liberado'];
			
			if($bool_liberado == 1){ // ADICIOANR MODULO
				$query = sprintf("
				INSERT INTO desk_grupos_modulos
				(	fgk_grupo, fgk_modulo)
				values 
				(	%d, %d )",
					mysqli_real_escape_string($mysqli,$id_grupo),	
					mysqli_real_escape_string($mysqli,$id_modulo)
				);
				mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
			}
			else{ // REMOVER MODULO
				$query = sprintf("
					DELETE FROM desk_grupos_modulos WHERE fgk_grupo = %d AND fgk_modulo = %d",
					mysqli_real_escape_string($mysqli, $id_grupo),
					mysqli_real_escape_string($mysqli, $id_modulo)
				);
				mysqli_query($mysqli,$query);			
			}			
			break;
		}
		
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>