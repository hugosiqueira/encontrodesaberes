<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$json = $_POST['projeto'];
	$dados = json_decode($json);

	$fgk_evento			= $_SESSION['id_evento_atual'];
	$id_projeto			= $dados->id;
	$fgk_area 			= $dados->fgk_area;
	$fgk_instituicao 	= $dados->fgk_instituicao;
	$fgk_area_espec  	= $dados->fgk_area_especifica;
  	$fgk_orgao_fomento 	= $dados->fgk_orgao_fomento;
  	$fgk_programa_ic 	= $dados->fgk_programa_ic;
  	$fgk_departamento	= $dados->fgk_departamento;
  	$fgk_categoria 		= $dados->fgk_categoria;
  	$aluno 				= $dados->aluno;
  	$aluno_cpf 			= $dados->aluno_cpf;
  	$aluno_email 		= $dados->aluno_email;
  	$apr_obrigatoria 	= $dados->apresentacao_obrigatoria;
  	$orientador 		= $dados->orientador;
  	$orientador_cpf 	= $dados->orientador_cpf;
  	$orientador_email 	= $dados->orientador_email;
  	$titulo 			= $dados->titulo;

	$queryString = array(
		'fgk_evento'=>$fgk_evento,
		'fgk_instituicao'=>$fgk_instituicao,
		'fgk_area'=>$fgk_area,
		'fgk_area_especifica'=>$fgk_area_espec,
		'fgk_orgao_fomento'=>$fgk_orgao_fomento,
		'fgk_programa_ic'=>$fgk_programa_ic,
		'fgk_departamento'=>$fgk_departamento,
		'fgk_categoria'=>$fgk_categoria ,
		'aluno'=>$aluno,
		'aluno_cpf'=>$aluno_cpf,
		'aluno_email'=>$aluno_email,
		'apresentacao_obrigatoria'=>$apr_obrigatoria,
		'orientador'=>$orientador,
		'orientador_cpf'=>$orientador_cpf,
		'orientador_email'=>$orientador_email,
		'titulo'=>$titulo);

	$db->iniciar_transacao();
	// Se existir mais de um trabalho relacionado ao projeto, não realizar alterações. abaixo.

	$db->atualizar('es_projeto', $queryString, 'id', $id_projeto); // atualiza o projeto

	$result = $db->listar('es_trabalho', 'fgk_projeto', $id_projeto);
	$trabalho_status = $result->fgk_status;
	$trabalho_id = $result->id;

	$result2 = $db->listar('es_programa_ic', 'id', $fgk_programa_ic);
	$tipo_apresentacao = $result2->fgk_tipo_apresentacao;

	if($trabalho_status == 1){

		$queryTrabalho = array(
			'fgk_instituicao'=>$fgk_instituicao,
			'fgk_area'=>$fgk_area,
			'fgk_area_especifica'=>$fgk_area_espec,
			'fgk_evento'=>$fgk_evento,
			'fgk_orgao_fomento'=>$fgk_orgao_fomento,
			'fgk_categoria'=>$fgk_categoria,
			'fgk_tipo_apresentacao'=>$tipo_apresentacao,
			'apresentacao_obrigatoria'=>$apr_obrigatoria,
			'titulo_enviado'=>$titulo);
		$db->atualizar('es_trabalho', $queryTrabalho, 'id', $trabalho_id); //trabalho

		$db->excluir('es_trabalho_autor','fgk_trabalho', $trabalho_id);

		$queryAutorPrincipal = array(
			'fgk_instituicao'=> 1,
			'fgk_trabalho'=>$trabalho_id,
			'fgk_tipo_autor'=> 1,
			'cpf'=>$aluno_cpf,
			'nome'=>$aluno,
			'email'=>$aluno_email,
			'ordenacao'=> 1,
			'bool_apresentador'=> 1);
		$db->inserir('es_trabalho_autor', $queryAutorPrincipal); //auto principal

		$queryAutorSecundario = array(
			'fgk_instituicao'=> 1,
			'fgk_trabalho'=>$trabalho_id,
			'fgk_tipo_autor'=> 2,
			'cpf'=>$orientador_cpf,
			'nome'=>$orientador ,
			'email'=>$orientador_email,
			'ordenacao'=> 2,
			'bool_apresentador'=> 0);
		$db->inserir('es_trabalho_autor', $queryAutorSecundario); //auto Secundario
	}

	$db->commit();

	echo json_encode(array(
		"msg" => "Projeto atualizado com sucesso."
	));
?>