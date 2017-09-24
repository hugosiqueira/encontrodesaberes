<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	sec_session_start();

	$id_projeto = $_POST['id_projeto'];

	$dados = $db->listar('es_projeto', 'id', $id_projeto);
		$fgk_evento			= $dados->fgk_evento;
		$fgk_instituicao 	= $dados->fgk_instituicao;
		$fgk_area 			= $dados->fgk_area;
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

	$result = $db->listar('es_programa_ic', 'id', $fgk_programa_ic);
	$tipo_apresentacao = $result->fgk_tipo_apresentacao;

	$db->iniciar_transacao();

	$queryTrabalho = array(
		'fgk_instituicao'=>$fgk_instituicao,
		'fgk_area'=>$fgk_area,
		'fgk_area_especifica'=>$fgk_area_espec,
		'fgk_evento'=>$fgk_evento,
		'fgk_projeto'=> $id_projeto,
		'fgk_orgao_fomento'=>$fgk_orgao_fomento,
		'fgk_categoria'=>$fgk_categoria,
		'fgk_tipo_apresentacao'=>$tipo_apresentacao,
		'apresentacao_obrigatoria'=>$apr_obrigatoria,
		'titulo_enviado'=>$titulo);

	$db->inserir('es_trabalho', $queryTrabalho); //cria o trabalho
	$last_ID_trabalho = $db->lastInsertId();

	$queryAutorPrincipal = array(
		'fgk_instituicao'=> 1,
		'fgk_trabalho'=>$last_ID_trabalho,
		'fgk_tipo_autor'=> 1,
		'cpf'=>$aluno_cpf,
		'nome'=>$aluno,
		'email'=>$aluno_email,
		'ordenacao'=> 1,
		'bool_apresentador'=> 1);
	$db->inserir('es_trabalho_autor', $queryAutorPrincipal); //cria o auto principal

	$queryAutorSecundario = array(
		'fgk_instituicao'=> 1,
		'fgk_trabalho'=>$last_ID_trabalho,
		'fgk_tipo_autor'=> 2,
		'cpf'=>$orientador_cpf,
		'nome'=>$orientador ,
		'email'=>$orientador_email,
		'ordenacao'=> 2,
		'bool_apresentador'=> 0);
	$db->inserir('es_trabalho_autor', $queryAutorSecundario); //cria o auto Secundario
	$db->commit();

	echo json_encode(array(
		"msg" => "Trabalho criado com sucesso."
	));
?>