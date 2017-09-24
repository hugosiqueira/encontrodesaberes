<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$cpf = $_POST['cpf'];
	$queryString = "SELECT * FROM es_ufop_professores WHERE cpf = '$cpf';";
	$query = mysqli_query($mysqli, $queryString) or die(mysqli_error($mysqli));
	$resposta = array();
	if (mysqli_num_rows($query) > 0){
		$registro = mysqli_fetch_assoc($query);
		$id_professor 	= $registro['id_professor'];
		$cod_siape 		= $registro['cod_siape'];
		$fgk_tipo 		= $registro['fgk_tipo'];
		$fgk_departamento = $registro['fgk_departamento'];
		$nome 			= $registro['nome'];
		$email 			= $registro['email'];
		$cpf 			= $registro['cpf'];
		$bool_avaliador = $registro['bool_avaliador'];
		$cursos 		= $registro['cursos'];
		$bool_coordenador	= $registro['bool_coordenador'];
		$bool_monitoria	= $registro['bool_monitoria'];

		echo json_encode(array(
			"success" => mysqli_errno($mysqli) == 0,
			"id_professor" => $id_professor,
			"cod_siape" => $cod_siape,
			"fgk_tipo" => $fgk_tipo,
			"fgk_departamento" => $fgk_departamento,
			"nome" => $nome,
			"email" => $email,
			"bool_avaliador" => $bool_avaliador,
			"cursos" => $cursos,
			"bool_coordenador" => $bool_coordenador,
			"bool_monitoria" => $bool_monitoria
			
		));
	}
	else{
			echo json_encode(array(
			"success" => false
		));
	}
?>