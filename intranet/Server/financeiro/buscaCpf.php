<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$fgk_evento	= $_SESSION['id_evento_atual'];
	$cpf = $_POST['cpf'];

	$queryCPF = "SELECT nome, email, descricao_tipo 
					FROM es_inscritos
					INNER JOIN es_inscritos_tipos ON es_inscritos.fgk_tipo = es_inscritos_tipos.id_tipo_inscrito
					WHERE cpf = ? AND es_inscritos.fgk_evento = ?;";

	$vars = array('cpf'=>$cpf, 'fgk_evento'=>$fgk_evento);

	$result = $db->sql_query($queryCPF, $vars);

	$dados = array();
	foreach ($result as $row) {
		$row->nome = ucwords(strtolower($row->nome));
		$row->nome = str_replace(" De ", " de ", $row->nome);
		$row->nome = str_replace(" Da ", " da ", $row->nome);
		$row->nome = str_replace(" Dos ", " dos ", $row->nome);
		$row->nome = str_replace(" Das ", " das ", $row->nome);
		$dados = $row;
	}

	echo json_encode(array(
		"success" => true,
		"msg" => $dados
	));
?>