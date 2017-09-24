<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	function formataData($data,$hora){
		$data = explode("T", $data);
		$data_hora = $data[0]."T".$hora;
		return $data_hora;
	}

	$dados = json_decode($_POST['evento']);

	$titulo 						= utf8_decode($dados->titulo);
	$sigla	 						= utf8_decode($dados->sigla);
	$edicao 						= utf8_decode($dados->edicao);
	$data_evento_ini 				= utf8_decode($dados->data_evento_ini);
	$data_evento_fim 				= utf8_decode($dados->data_evento_fim);
	$data_inscricao_ini 			= utf8_decode($dados->data_inscricao_ini);
	$data_inscricao_fim 			= utf8_decode($dados->data_inscricao_fim);
	$data_avaliacao_ini 			= utf8_decode($dados->data_avaliacao_ini);
	$data_avaliacao_fim 			= utf8_decode($dados->data_avaliacao_fim);
	$data_reavaliacao_ini 			= utf8_decode($dados->data_reavaliacao_ini);
	$data_reavaliacao_fim 			= utf8_decode($dados->data_reavaliacao_fim);
	$data_submissao_ini 			= utf8_decode($dados->data_submissao_ini);
	$data_submissao_fim 			= utf8_decode($dados->data_submissao_fim);
	$data_submissao_adequacao_ini 	= utf8_decode($dados->data_submissao_adequacao_ini);
	$data_submissao_adequacao_fim 	= utf8_decode($dados->data_submissao_adequacao_fim);

	$data_ini_primeiro_parecer 	= utf8_decode($dados->data_ini_primeiro_parecer);
	$data_fim_primeiro_parecer 	= utf8_decode($dados->data_fim_primeiro_parecer);

	$data_ini_submissao_minicurso 	= utf8_decode($dados->data_ini_submissao_minicurso);
	$data_fim_submissao_minicurso 	= utf8_decode($dados->data_fim_submissao_minicurso);

	$data_max_vencimento_boleto 	= utf8_decode($dados->data_max_vencimento_boleto);

	$hora_ini_primeiro_parecer 	= utf8_decode($dados->hora_ini_primeiro_parecer);
	$hora_fim_primeiro_parecer 	= utf8_decode($dados->hora_fim_primeiro_parecer);

	$hora_ini_submissao_minicurso 	= utf8_decode($dados->hora_ini_submissao_minicurso);
	$hora_fim_submissao_minicurso 	= utf8_decode($dados->hora_fim_submissao_minicurso);

	$data_ini_parecer_final 	= utf8_decode($dados->data_ini_parecer_final);
	$data_fim_parecer_final 	= utf8_decode($dados->data_fim_parecer_final);
	$hora_ini_parecer_final 	= utf8_decode($dados->hora_ini_parecer_final);
	$hora_fim_parecer_final 	= utf8_decode($dados->hora_fim_parecer_final);

	$hora_evento_ini 				= utf8_decode($dados->hora_evento_ini);
	$hora_evento_fim 				= utf8_decode($dados->hora_evento_fim);
	$hora_inscricao_ini 			= utf8_decode($dados->hora_inscricao_ini);
	$hora_inscricao_fim 			= utf8_decode($dados->hora_inscricao_fim);
	$hora_avaliacao_ini 			= utf8_decode($dados->hora_avaliacao_ini);
	$hora_avaliacao_fim 			= utf8_decode($dados->hora_avaliacao_fim);
	$hora_reavaliacao_ini 			= utf8_decode($dados->hora_reavaliacao_ini);
	$hora_reavaliacao_fim 			= utf8_decode($dados->hora_reavaliacao_fim);
	$hora_submissao_ini 			= utf8_decode($dados->hora_submissao_ini);
	$hora_submissao_fim 			= utf8_decode($dados->hora_submissao_fim);
	$hora_submissao_adequacao_ini 	= utf8_decode($dados->hora_submissao_adequacao_ini);
	$hora_submissao_adequacao_fim 	= utf8_decode($dados->hora_submissao_adequacao_fim);

	$add = array(
		'titulo'						=> $titulo,
		'sigla'							=> $sigla,
		'edicao'						=> $edicao,
		'data_evento_ini'				=> formataData($data_evento_ini,$hora_evento_ini),
		'data_evento_ini'				=> formataData($data_evento_ini,$hora_evento_ini),
		'data_evento_fim'				=> formataData($data_evento_fim,$hora_evento_fim),
		'data_inscricao_ini'			=> formataData($data_inscricao_ini,$hora_inscricao_ini),
		'data_inscricao_fim'			=> formataData($data_inscricao_fim,$hora_inscricao_fim),
		'data_avaliacao_ini'			=> formataData($data_avaliacao_ini,$hora_avaliacao_ini),
		'data_avaliacao_fim'			=> formataData($data_avaliacao_fim,$hora_avaliacao_fim),
		'data_reavaliacao_ini'			=> formataData($data_reavaliacao_ini,$hora_reavaliacao_ini),
		'data_reavaliacao_fim'			=> formataData($data_reavaliacao_fim,$hora_reavaliacao_fim),
		'data_submissao_ini'			=> formataData($data_submissao_ini,$hora_submissao_ini),
		'data_submissao_fim'			=> formataData($data_submissao_fim,$hora_submissao_fim),
		'data_submissao_adequacao_ini'	=> formataData($data_submissao_adequacao_ini,$hora_submissao_adequacao_ini),
		'data_submissao_adequacao_fim'	=> formataData($data_submissao_adequacao_fim,$hora_submissao_adequacao_fim),
		'data_ini_primeiro_parecer'		=> formataData($data_ini_primeiro_parecer,$hora_ini_primeiro_parecer),
		'data_fim_primeiro_parecer'		=> formataData($data_fim_primeiro_parecer,$hora_fim_primeiro_parecer),
		'data_ini_submissao_minicurso'	=> formataData($data_ini_submissao_minicurso,$hora_ini_submissao_minicurso),
		'data_fim_submissao_minicurso'	=> formataData($data_fim_submissao_minicurso,$hora_fim_submissao_minicurso),
		'data_ini_parecer_final'		=> formataData($data_ini_parecer_final,$hora_ini_parecer_final),
		'data_fim_parecer_final'		=> formataData($data_fim_parecer_final,$hora_fim_parecer_final),
		'data_max_vencimento_boleto'	=> $data_max_vencimento_boleto
	);
	$db->inserir('es_evento', $add);	
	$id = $db->lastInsertId();
	echo json_encode(array(
		"success" => true,
		"resultado" => array(
			"id_evento" => $id,
			"titulo" => $titulo,
			"sigla" => $sigla,
			"edicao" => $edicao,
			"data_evento_ini" => $data_evento_ini,
			"data_evento_fim" => $data_evento_fim,
			"data_inscricao_ini" => $data_inscricao_ini,
			"data_inscricao_fim" => $data_inscricao_fim,
			"data_avaliacao_ini" => $data_avaliacao_ini,
			"data_avaliacao_fim" => $data_avaliacao_fim,
			"data_reavaliacao_ini" => $data_reavaliacao_ini,
			"data_reavaliacao_fim" => $data_reavaliacao_fim,
			"data_submissao_ini" => $data_submissao_ini,
			"data_submissao_fim" => $data_submissao_fim,
			"data_submissao_adequacao_ini" => $data_submissao_adequacao_ini,
			"data_submissao_adequacao_fim" => $data_submissao_adequacao_fim,
			"bool_logo" => 0
		)
	));
	// echo "a";
?>