<?php
	require_once("../../includes/db_connect.php");
	$id_evento = $_REQUEST['id_evento'];
	$onde = '../../resources/wallpapers/';
	$arquivo = $onde.$id_evento.'.jpg';

	$maxTamanho = 1024 * 1024 * 3; // 3Mb
	if ($_FILES['wallpaper']['size'] > $maxTamanho ) {
		echo "{success: false, msg:'Arquivo maior que o limite permitido (3 Mb).'}";
		exit;
	}
	$extensao = explode('.', $_FILES['wallpaper']['name']);
	$extensao = end($extensao);
	$extensao = strtolower($extensao);
	if($extensao != 'jpg'){
		echo "{success: false, msg:'Favor selecionar uma imagem com a extensão <b>jpg</b>'}";
		exit;
	}
	if (move_uploaded_file($_FILES['wallpaper']['tmp_name'], $arquivo)) {
	   	echo "{success: true, msg:'Plano de fundo alterado com sucesso.'}";	   
	}
	else {
		echo "{success: false, msg:'Falha no upload. Favor entrar em contato com o administrador do sistema.'}";
	}
	
?>