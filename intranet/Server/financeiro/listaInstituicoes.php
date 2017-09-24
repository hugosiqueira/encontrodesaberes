<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];

	$queryInstituicoes = "SELECT id, sigla, CONCAT(sigla, ' - ', nome) AS sig_nome  FROM es_instituicao ";

	$result = NULL;

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryInstituicoes.=" WHERE (nome LIKE ? OR sigla LIKE ?) ";
		$vars = array('nome'=>  '%'.$filtro.'%', 'sigla'=>  '%'.$filtro.'%');

		$queryInstituicoes.=" ORDER BY sigla ASC; ";
		$result = $db->sql_query($queryInstituicoes, $vars);
	}else{
		$queryInstituicoes.=" ORDER BY sigla ASC; ";
		$result = $db->sql_query($queryInstituicoes);
	}

	$instituicoes = array();
	foreach ($result as $instituicao)
		$instituicoes[] = $instituicao;

	echo json_encode(array(
		"success" => true,
		"instituicoes" => $instituicoes
	));
?>