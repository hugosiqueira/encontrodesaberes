<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['trabalho'];
	$dados = json_decode($json);

	$id_trabalho 	= $dados->id;
	$fgk_area 	= $dados->fgk_area;
	$fgk_area_especifica 	= $dados->fgk_area_especifica;
	$fgk_projeto 			= $dados->fgk_projeto;
	$fgk_orgao_fomento 				= $dados->fgk_orgao_fomento;
	$fgk_inscrito_responsavel 	= $dados->fgk_inscrito_responsavel;
	$fgk_tipo_apresentacao 		= $dados->fgk_tipo_apresentacao;
	$palavras_chave 		= $dados->palavras_chave;
	$resumo_enviado 		= $dados->resumo_enviado;
	$titulo_enviado 		= $dados->titulo_enviado;
	$fgk_instituicao 		= $dados->fgk_instituicao;
	$fgk_categoria 		= $dados->fgk_categoria;
	$fgk_status 		= $dados->fgk_status;
	$apresentacao_obrigatoria 		= $dados->apresentacao_obrigatoria;

	$query = sprintf("
		UPDATE es_trabalho
		SET fgk_area				= %d,
			fgk_area_especifica 	= %d,
			fgk_orgao_fomento 		= %d,
			fgk_inscrito_responsavel= %d,
			fgk_categoria			= %d,
			fgk_instituicao			= %d,
			fgk_tipo_apresentacao	= %d,
			palavras_chave			= '%s',
			resumo_enviado			= '%s',
			titulo_enviado			= '%s',
			fgk_status				= %d,
			apresentacao_obrigatoria	= %d
		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$fgk_area),
			mysqli_real_escape_string($mysqli,$fgk_area_especifica),
			mysqli_real_escape_string($mysqli,$fgk_orgao_fomento),
			mysqli_real_escape_string($mysqli,$fgk_inscrito_responsavel),
			mysqli_real_escape_string($mysqli,$fgk_categoria),
			mysqli_real_escape_string($mysqli,$fgk_instituicao),
			mysqli_real_escape_string($mysqli,$fgk_tipo_apresentacao),
			mysqli_real_escape_string($mysqli,$palavras_chave),
			mysqli_real_escape_string($mysqli,$resumo_enviado),
			mysqli_real_escape_string($mysqli,$titulo_enviado),
			mysqli_real_escape_string($mysqli,$fgk_status),
			mysqli_real_escape_string($mysqli,$apresentacao_obrigatoria),
			mysqli_real_escape_string($mysqli,$id_trabalho)
	);
	mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));


	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>