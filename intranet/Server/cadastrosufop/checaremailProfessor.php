<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	//busca rapida
	$buscaRapida	= $_REQUEST['buscaRapida'];
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_professores.nome LIKE '%$buscaRapida%' OR
			es_ufop_professores.fgk_departamento LIKE '%$buscaRapida%' OR
			es_ufop_professores.cod_siape LIKE '%$buscaRapida%' OR
			es_ufop_professores.email LIKE '%$buscaRapida%' OR
			es_ufop_professores.cpf LIKE '%$buscaRapida%'
		)";
	}

	//formulário
	if($_REQUEST['professor'] == 'true'){
		$professor = "";
	}
	else{
		$id = $_REQUEST['id_professor'];
		$professor = " AND es_ufop_professores.id_professor = $id";
	}
	$queryString = "
		SELECT es_ufop_professores.*
		FROM es_ufop_professores
		 INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_professores.fgk_departamento
		WHERE $filtro
		$professor
		ORDER BY nome ASC
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$emails = array();
	$contador=0;
	while($registro = mysqli_fetch_assoc($query)) { //todos os trabalhos listados ou selecionado
		$contador++;
		$emails[] = $registro['email'];
	}
	
	echo json_encode(array(
		"success" =>true,
		"total" => $contador
	));

?>