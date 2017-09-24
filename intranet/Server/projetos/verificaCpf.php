<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	mb_internal_encoding("UTF-8");  // before calling the function
	mb_regex_encoding("UTF-8");


	$cpf = $_POST['cpf'];
	$tipo = $_POST['tipo'];

	if($tipo == 0){
		$queryString = "
			SELECT nome, email, descricao_curso FROM es_ufop_alunos
			LEFT JOIN es_ufop_cursos ON es_ufop_alunos.fgk_curso = es_ufop_cursos.codigo
			WHERE cpf = ?
		";
	}
	else if($tipo == 1){
		$queryString = "SELECT nome, email, fgk_departamento AS fgk_departamento_orientador FROM es_ufop_professores WHERE cpf = ?";
	}

	$query = $db->sql_query($queryString, array($cpf));

	// $dados = mysqli_fetch_assoc($query);

	$dados = array();
	foreach ($query as $row) {
		// $echo $row->nome;
		$row->nome = ucwords(mb_strtolower($row->nome,"UTF-8"));
		$row->nome = str_replace(" De ", " de ", $row->nome);
		$row->nome = str_replace(" Da ", " da ", $row->nome);
		$row->nome = str_replace(" Dos ", " dos ", $row->nome);
		$row->nome = str_replace(" Das ", " das ", $row->nome);
		$dados = $row;
	}
	echo json_encode(array(
		"success" =>true,
		"msg" => $dados
	));
?>