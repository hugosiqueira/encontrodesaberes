<?php
	require_once("../../includes/db_connect.php");
	$id_evento = $_REQUEST['id_evento'];
	$onde = '../../../img/intranet/eventos/logos/';
	$arquivo = $onde.$id_evento.'.jpg';

	$maxTamanho = 1024 * 1024 * 3; // 3Mb
	if ($_FILES['logo']['size'] > $maxTamanho ) {
		echo "{success: false, msg:'Arquivo maior que o limite permitido (3 Mb).'}";
		exit;
	}
	$extensao = explode('.', $_FILES['logo']['name']);
	$extensao = end($extensao);
	$extensao = strtolower($extensao);
	if($extensao != 'jpg'){
		echo "{success: false, msg:'Favor enviar uma logo com a extensão .jpg'}";
		exit;
	}
	if (move_uploaded_file($_FILES['logo']['tmp_name'], $arquivo)) {
	   $query = sprintf("
			UPDATE es_evento 
			SET bool_logo = 1
			WHERE id = %d",
				mysqli_real_escape_string($mysqli,$id_evento)
			);
		mysqli_query($mysqli,$query);	   
		echo "{success: true, msg:'Logo alterada com sucesso.'}";	   
	}
	else {
		echo "{success: false, msg:'Falha no upload. Favor entrar em contato com o administrador do sistema.'}";
	}
	
?>