<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../includes/functions.php');
	require_once('../includes/db_connect.php');
	set_time_limit(100800); //30horas

	sec_session_start();
	$count = 0;

	$queryProjetos = "SELECT es_projeto.id, es_projeto.fgk_instituicao, es_trabalho.fgk_status, es_projeto.fgk_area, es_projeto.fgk_area_especifica, es_projeto.fgk_orgao_fomento, fgk_programa_ic, fgk_departamento, 
	es_projeto.fgk_categoria, aluno, aluno_cpf, es_projeto.apresentacao_obrigatoria, codigo_area, orientador, orientador_cpf, sigla_categoria, titulo,  
	 es_orgao_fomento.sigla AS sigla_orgao, es_programa_ic.sigla AS sigla_programa, es_programa_ic.nome AS nome_programa_ic, orientador_email, aluno_email
					FROM es_projeto 
					INNER JOIN es_ufop_areas ON es_projeto.fgk_area = es_ufop_areas.id_area 
					INNER JOIN es_programa_ic ON es_projeto.fgk_programa_ic = es_programa_ic.id
					LEFT JOIN es_categorias ON es_projeto.fgk_categoria = es_categorias.id_categoria 
					LEFT JOIN es_trabalho ON es_projeto.id = es_trabalho.fgk_projeto
					INNER JOIN es_orgao_fomento ON es_projeto.fgk_orgao_fomento = es_orgao_fomento.id 
					WHERE es_trabalho.id IS NULL
					AND es_projeto.fgk_evento = 8";	
		
	$projetos = $db->sql_query($queryProjetos);

	foreach ($projetos as $projeto){

		$fgk_evento			= 8;
		$fgk_instituicao 	= $projeto->fgk_instituicao;
		$fgk_area 			= $projeto->fgk_area;
		$fgk_area_espec  	= $projeto->fgk_area_especifica;
	  	$fgk_orgao_fomento 	= $projeto->fgk_orgao_fomento;
	  	$fgk_programa_ic 	= $projeto->fgk_programa_ic;
	  	$fgk_departamento	= $projeto->fgk_departamento;
	  	$fgk_categoria 		= $projeto->fgk_categoria;
	  	$aluno 				= $projeto->aluno;
	  	$aluno_cpf 			= $projeto->aluno_cpf;

	  	if(isset($projeto->aluno_email))
		  	$aluno_email 	= $projeto->aluno_email;
		 else
		 	$aluno_email 	= " ";

		 if(isset($projeto->orientador_email))
		 	$orientador_email 	= $projeto->orientador_email;
		 else
		 	$orientador_email = " ";

	  	$apr_obrigatoria 	= $projeto->apresentacao_obrigatoria;
	  	$orientador 		= $projeto->orientador;
	  	$orientador_cpf 	= $projeto->orientador_cpf;
	  	$titulo 			= $projeto->titulo;	
	  	$id_projeto			= $projeto->id;

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
			'fgk_instituicao'=> $fgk_instituicao,
			'fgk_trabalho'=>$last_ID_trabalho,
			'fgk_tipo_autor'=> 1,
			'cpf'=>$aluno_cpf,
			'nome'=>$aluno,
			'email'=>$aluno_email,
			'ordenacao'=> 1,
			'bool_apresentador'=> 1);
		$db->inserir('es_trabalho_autor', $queryAutorPrincipal); //cria o auto principal

		$queryAutorSecundario = array(
			'fgk_instituicao'=> $fgk_instituicao,
			'fgk_trabalho'=>$last_ID_trabalho,
			'fgk_tipo_autor'=> 2,
			'cpf'=>$orientador_cpf,
			'nome'=>$orientador ,
			'email'=>$orientador_email,
			'ordenacao'=> 2,
			'bool_apresentador'=> 0);
		$db->inserir('es_trabalho_autor', $queryAutorSecundario); //cria o auto Secundario
		$db->commit();
		$count++;
		print_r($count);
	}
?>