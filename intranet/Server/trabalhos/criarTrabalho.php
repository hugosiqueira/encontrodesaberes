<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$json = $_POST['trabalho'];
	$dados = json_decode($json);

	$fgk_area 	= $dados->fgk_area;
	$fgk_area_especifica 	= $dados->fgk_area_especifica;
	$fgk_projeto 			= $dados->fgk_projeto;
	$fgk_orgao_fomento 				= $dados->fgk_orgao_fomento;
	$fgk_inscrito_responsavel 	= $dados->fgk_inscrito_responsavel;
	$fgk_tipo_apresentacao 		= $dados->fgk_tipo_apresentacao;
	$palavras_chave 		= $dados->palavras_chave;
	$resumo_enviado 		= $dados->resumo_enviado;
	$titulo_enviado 		= $dados->titulo_enviado;
	$fgk_categoria 		= $dados->fgk_categoria;
	$fgk_instituicao 		= $dados->fgk_instituicao;
	$apresentacao_obrigatoria 		= $dados->apresentacao_obrigatoria;
	$fgk_status 		= $dados->fgk_status;
	$datahora_registro 		= date('Y-m-d');

	$query = sprintf("
		INSERT INTO es_trabalho
		(	fgk_area, fgk_area_especifica, fgk_evento, fgk_orgao_fomento, fgk_inscrito_responsavel, fgk_categoria, fgk_instituicao, fgk_tipo_apresentacao, palavras_chave, resumo_enviado, titulo_enviado, fgk_status, datahora_registro, apresentacao_obrigatoria	)
		values
		(	%d, %d, %d, %d, %d, %d, %d, %d, '%s', '%s', '%s', %d, '%s', %d	)",
		mysqli_real_escape_string($mysqli,$fgk_area),
		mysqli_real_escape_string($mysqli,$fgk_area_especifica),
		mysqli_real_escape_string($mysqli,$id_evento_atual),
		mysqli_real_escape_string($mysqli,$fgk_orgao_fomento),
		mysqli_real_escape_string($mysqli,$fgk_inscrito_responsavel),
		mysqli_real_escape_string($mysqli,$fgk_categoria),
		mysqli_real_escape_string($mysqli,$fgk_instituicao),
		mysqli_real_escape_string($mysqli,$fgk_tipo_apresentacao),
		mysqli_real_escape_string($mysqli,$palavras_chave),
		mysqli_real_escape_string($mysqli,$resumo_enviado),
		mysqli_real_escape_string($mysqli,$titulo_enviado),
		mysqli_real_escape_string($mysqli,$fgk_status),
		mysqli_real_escape_string($mysqli,$datahora_registro),
		mysqli_real_escape_string($mysqli,$apresentacao_obrigatoria)
		);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));
	$id_trabalho = mysqli_insert_id($mysqli);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
		,"id_trabalho" => $id_trabalho
		,"resultado" => array(
			"id" => $id_trabalho,
			"fgk_area" => $fgk_area,
			"fgk_area_especifica" => $fgk_area_especifica,
			"fgk_orgao_fomento" => $fgk_orgao_fomento,
			"fgk_inscrito_responsavel" => $fgk_inscrito_responsavel,
			"fgk_categoria" => $fgk_categoria,
			"fgk_tipo_apresentacao" => $fgk_tipo_apresentacao,
			"palavras_chave" => $palavras_chave,
			"resumo_enviado" => $resumo_enviado,
			"titulo_enviado" => $titulo_enviado,
			"fgk_status" => $fgk_status,
			"datahora_registro" => $datahora_registro
		)
	));
?>