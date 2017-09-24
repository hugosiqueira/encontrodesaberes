<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	
	function retornaSituacao($valor){
		if($valor == '0')
			return "Inadequado";
		else if ($valor == '1')
			return "Ruim";
		else if ($valor == '2')
			return "Regular";
		else if ($valor == '3')
			return "Bom";
		else if ($valor == '4')
			return "Excelente";
		else
			return "-";
	}
	function retornaResultado($valor){
		if ($valor == "A")
			return "Aprovado";
		else if ($valor == "AR")
			return "Aprovado com restrições";
		else if ($valor == "R")
			return "Reprovado";
		else
			return "-";
	}
	
	$id_trabalho = $_REQUEST['id_trabalho'];

	$queryString = "
		SELECT es_avaliacao.*, inscrito1.nome AS nome_revisor1, tipo1.descricao_tipo AS tipo_revisor1, inscrito2.nome AS nome_revisor2, tipo2.descricao_tipo AS tipo_revisor2,
		revisao1.aval_conclusao AS aval_conclusao1, revisao1.aval_metodologia AS aval_metodologia1, revisao1.aval_redacao AS aval_redacao1, revisao1.aval_resultado AS aval_resultado1, revisao1.justificativa AS justificativa1, revisao1.nota AS nota1, revisao1.parecer AS parecer1, revisao1.resultado AS resultado1,
		revisao2.aval_conclusao AS aval_conclusao2, revisao2.aval_metodologia AS aval_metodologia2, revisao2.aval_redacao AS aval_redacao2, revisao2.aval_resultado AS aval_resultado2, revisao2.justificativa AS justificativa2, revisao2.nota AS nota2, revisao2.parecer AS parecer2, revisao2.resultado AS resultado2
		FROM es_avaliacao
			LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
				LEFT JOIN es_avaliacao_revisao AS revisao1 ON revisao1.fgk_avaliacao = es_avaliacao.id AND revisao1.fgk_revisor = revisor1.id
				LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
					LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo
			LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
				LEFT JOIN es_avaliacao_revisao AS revisao2 ON revisao2.fgk_avaliacao = es_avaliacao.id AND revisao2.fgk_revisor = revisor2.id
				LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
					LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo
		WHERE es_avaliacao.fgk_trabalho = $id_trabalho AND es_avaliacao.bool_caint = 1
	";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$registro = mysqli_fetch_assoc($query);

	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"id_avaliacao" 				=> $registro['id'],
		"fgk_revisor1" 				=> $registro['fgk_revisor1'],
		"nome_revisor1" 			=> $registro['nome_revisor1'],
		"tipo_revisor1" 			=> $registro['tipo_revisor1'],
		"fgk_revisor2"				=> $registro['fgk_revisor2'],
		"nome_revisor2" 			=> $registro['nome_revisor2'],
		"tipo_revisor2" 			=> $registro['tipo_revisor2'],
		"status" 					=> $registro['status'],
		"nota" 						=> $registro['nota'],
		"parecer" 					=> $registro['parecer'],
		"resultado" 				=> retornaResultado($registro['resultado']),
		"parecer_ar" 				=> $registro['parecer_ar'],
		"justificativa1" 			=> $registro['justificativa1'],
		"nota1" 					=> $registro['nota1'],
		"parecer1" 					=> $registro['parecer1'],
		"justificativa2" 			=> $registro['justificativa2'],
		"nota2" 					=> $registro['nota2'],
		"parecer2" 					=> $registro['parecer2'],
		"aval_conclusao1" 			=> retornaSituacao($registro['aval_conclusao1']),
		"aval_metodologia1" 		=> retornaSituacao($registro['aval_metodologia1']),
		"aval_redacao1" 			=> retornaSituacao($registro['aval_redacao1']),
		"aval_resultado1" 			=> retornaSituacao($registro['aval_resultado1']),
		"resultado1" 				=> retornaResultado($registro['resultado1']),
		"aval_conclusao2" 			=> retornaSituacao($registro['aval_conclusao2']),
		"aval_metodologia2" 		=> retornaSituacao($registro['aval_metodologia2']),
		"aval_redacao2" 			=> retornaSituacao($registro['aval_redacao2']),
		"aval_resultado2" 			=> retornaSituacao($registro['aval_resultado2']),
		"resultado2" 				=> retornaResultado($registro['resultado2'])
	));

?>