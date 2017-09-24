<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$json = $_POST['autores'];
	$dados = json_decode($json);

	$queryString = "SELECT * FROM es_anais_trabalho_autor WHERE fgk_trabalho_anais = ? ";
	$contador = $db->sql_query2($queryString, array($dados->fgk_trabalho_anais))->rowCount() + 1;
	
	$novo = array(
		'fgk_trabalho_anais'=> $dados->fgk_trabalho_anais,
		'email'			=>$dados->email,
		'instituicao'	=>$dados->instituicao,
		'nome'			=>$dados->nome,
		'nome_citacao'	=>$dados->nome_citacao,
		'fgk_tipo'		=>$dados->fgk_tipo,
		'seq'			=>$contador
	);
	$db->inserir('es_anais_trabalho_autor', $novo);

	echo json_encode(array(
		"success" => true,
		"msg" => "Autor vinculado com sucesso."
	));

?>