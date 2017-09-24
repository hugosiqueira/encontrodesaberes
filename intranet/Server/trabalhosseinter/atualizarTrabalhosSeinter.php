<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';

	$json = $_POST['trabalhoseinter'];
	$dados = json_decode($json);
	
	$atualizarTrabalho = array(
		'fgk_status'				=> $dados->fgk_status,
		'cpf' 						=> $dados->cpf,
		'nome_aluno' 				=> $dados->nome_aluno,
		'curso_aluno'				=> $dados->curso_aluno,
		'periodo_cursava'			=> $dados->periodo_cursava,
		'tempo_afastamento'			=> $dados->tempo_afastamento,
		'tipo_mobilidade'			=> $dados->tipo_mobilidade,
		'questoes_linguisticas'		=> $dados->questoes_linguisticas,
		'universidade_destino'		=> $dados->universidade_destino,
		'cidade_destino'			=> $dados->cidade_destino,
		'pais_destino'				=> $dados->pais_destino,
		'curso_destino'				=> $dados->curso_destino,
		'curso_area_destaque'		=> $dados->curso_area_destaque,
		'tipo_moradia'				=> $dados->tipo_moradia,
		'sistema_avaliacao'			=> $dados->sistema_avaliacao,
		'dinamica_metodologia_aulas'=> $dados->dinamica_metodologia_aulas,
		'custo_vida'				=> $dados->custo_vida,
		'infra_universidade'		=> $dados->infra_universidade,
		'servico_acolhimento'		=> $dados->servico_acolhimento,
		'estagio'					=> $dados->estagio,
		'atividades_universidade'	=> $dados->atividades_universidade,
		'processo_adaptacao'		=> $dados->processo_adaptacao,
		'relato_pessoal'			=> $dados->relato_pessoal,
		'conselhos_calouro'			=> $dados->conselhos_calouro
	);
	$db->atualizar('es_trabalho_caint', $atualizarTrabalho, 'id', $dados->id);

	echo json_encode(array(
		"success" =>true
	));
?>