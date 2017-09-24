<?php
	require_once("../../includes/db_connect.php");
	$id = $_REQUEST['id'];
	$onde = '../../../img/certificados/tipos/';
	$arquivo = $onde.$id.'.jpg';

	$maxTamanho = 1024 * 1024 * 3; // 3Mb
	if ($_FILES['imagem']['size'] > $maxTamanho ) {
		echo "{success: false, msg:'Arquivo maior que o limite permitido (3 Mb).'}";
		exit;
	}
	$extensao = explode('.', $_FILES['imagem']['name']);
	$extensao = end($extensao);
	$extensao = strtolower($extensao);
	if($extensao != 'jpg'){
		echo "{success: false, msg:'Favor enviar uma imagem com a extensão .jpg'}";
		exit;
	}
	if (move_uploaded_file($_FILES['imagem']['tmp_name'], $arquivo)) {
	 	echo "{success: true, msg:'Imagem alterada com sucesso.'}";
	}
	else {
		echo "{success: false, msg:'Falha no upload. Favor entrar em contato com o administrador do sistema.'}";
	}
?>