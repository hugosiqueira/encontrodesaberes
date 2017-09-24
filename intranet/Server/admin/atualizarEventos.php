<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	function formataData($data,$hora){
		$data = explode("T", $data);
		$data_hora = $data[0]."T".$hora;
		return $data_hora;
	}

	$json = $_POST['evento'];
	$dados = json_decode($json);

	$id_evento 						= utf8_decode($dados->id);
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
	
	$data_ini_parecer_final 	= utf8_decode($dados->data_ini_parecer_final);
	$data_fim_parecer_final 	= utf8_decode($dados->data_fim_parecer_final);
	$hora_ini_parecer_final 	= utf8_decode($dados->hora_ini_parecer_final);
	$hora_fim_parecer_final 	= utf8_decode($dados->hora_fim_parecer_final);

	$data_ini_submissao_minicurso 	= utf8_decode($dados->data_ini_submissao_minicurso);
	$data_fim_submissao_minicurso 	= utf8_decode($dados->data_fim_submissao_minicurso);

	$data_max_vencimento_boleto 	= utf8_decode($dados->data_max_vencimento_boleto);

	$hora_ini_primeiro_parecer 	= utf8_decode($dados->hora_ini_primeiro_parecer);
	$hora_fim_primeiro_parecer 	= utf8_decode($dados->hora_fim_primeiro_parecer);
	
	$hora_ini_submissao_minicurso 	= utf8_decode($dados->hora_ini_submissao_minicurso);
	$hora_fim_submissao_minicurso 	= utf8_decode($dados->hora_fim_submissao_minicurso);

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

	$query = sprintf("
		UPDATE es_evento
		SET edicao 			= '%s',
			titulo			= '%s',
			sigla			= '%s',
			data_evento_ini = '%s',
			data_evento_fim = '%s',
			data_inscricao_ini = '%s',
			data_inscricao_fim = '%s',
			data_avaliacao_ini = '%s',
			data_avaliacao_fim = '%s',
			data_reavaliacao_ini = '%s',
			data_reavaliacao_fim = '%s',
			data_submissao_ini = '%s',
			data_submissao_fim = '%s',
			data_submissao_adequacao_ini = '%s',
			data_submissao_adequacao_fim = '%s',

			data_ini_primeiro_parecer = '%s',
			data_fim_primeiro_parecer = '%s',

			data_ini_submissao_minicurso = '%s',
			data_fim_submissao_minicurso = '%s',

			data_ini_parecer_final = '%s',
			data_fim_parecer_final = '%s',

			data_max_vencimento_boleto = '%s'

		WHERE id = %d",
			mysqli_real_escape_string($mysqli,$edicao),
			mysqli_real_escape_string($mysqli,$titulo),
			mysqli_real_escape_string($mysqli,$sigla),

			mysqli_real_escape_string($mysqli,formataData($data_evento_ini,$hora_evento_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_evento_fim,$hora_evento_fim)),
			mysqli_real_escape_string($mysqli,formataData($data_inscricao_ini,$hora_inscricao_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_inscricao_fim,$hora_inscricao_fim)),
			mysqli_real_escape_string($mysqli,formataData($data_avaliacao_ini,$hora_avaliacao_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_avaliacao_fim,$hora_avaliacao_fim)),
			mysqli_real_escape_string($mysqli,formataData($data_reavaliacao_ini,$hora_reavaliacao_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_reavaliacao_fim,$hora_reavaliacao_fim)),
			mysqli_real_escape_string($mysqli,formataData($data_submissao_ini,$hora_submissao_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_submissao_fim,$hora_submissao_fim)),
			mysqli_real_escape_string($mysqli,formataData($data_submissao_adequacao_ini,$hora_submissao_adequacao_ini)),
			mysqli_real_escape_string($mysqli,formataData($data_submissao_adequacao_fim,$hora_submissao_adequacao_fim)),
			
			mysqli_real_escape_string($mysqli,formataData($data_ini_primeiro_parecer,$hora_ini_primeiro_parecer)),
			mysqli_real_escape_string($mysqli,formataData($data_fim_primeiro_parecer,$hora_fim_primeiro_parecer)),
			mysqli_real_escape_string($mysqli,formataData($data_ini_submissao_minicurso,$hora_ini_submissao_minicurso)),
			mysqli_real_escape_string($mysqli,formataData($data_fim_submissao_minicurso,$hora_fim_submissao_minicurso)),
			mysqli_real_escape_string($mysqli,formataData($data_ini_parecer_final,$hora_ini_parecer_final)),
			mysqli_real_escape_string($mysqli,formataData($data_fim_parecer_final,$hora_fim_parecer_final)),
			mysqli_real_escape_string($mysqli,$data_max_vencimento_boleto),

			mysqli_real_escape_string($mysqli,$id_evento)
		);
	mysqli_query($mysqli,$query);
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0
	));
?>