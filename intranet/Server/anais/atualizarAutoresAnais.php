<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['autores'];
	$dados = json_decode($json);

	$atualizar = array(
		'email'			=>$dados->email,
		'instituicao'	=>$dados->instituicao,
		'nome'			=>$dados->nome,
		'nome_citacao'	=>$dados->nome_citacao,
		'fgk_tipo'		=>$dados->fgk_tipo
	);
	$db->atualizar('es_anais_trabalho_autor', $atualizar, 'id', $dados->id);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"msg"	=> "Autor atualizado com sucesso."
	));
?>