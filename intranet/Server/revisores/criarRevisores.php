<?php
	header('Content-Type: text/html; charset=utf-8');
	// header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	$json = $_POST['revisor'];
	$dados = json_decode($json);

	$tipo_revisor 			= $dados->tipo_revisor;
	$fgk_area  				= $dados->fgk_area;
  	$fgk_area_especifica 	= $dados->fgk_area_especifica;
  	$bool_avaliador_prograd = $dados->bool_avaliador_prograd;
  	$bool_avaliador_proex	= $dados->bool_avaliador_proex;
  	$bool_avaliador_caint 	= $dados->bool_avaliador_caint;
  	$cpf 					= $dados->cpf;
	if($tipo_revisor == '0'){
		$busca = "
			SELECT es_avaliacao_revisor.id
			FROM es_avaliacao_revisor
			 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
			WHERE es_inscritos.fgk_evento = ? AND es_inscritos.cpf = ?
		";
		$busca = $db->sql_query($busca, array('fgk_evento'=>$id_evento_atual, 'cpf'=>$cpf));
		if($busca->rowCount() > 0){
			echo json_encode(array(
				"success" => false,
				"msg" => "Já existe um revisor cadastrado com este CPF no evento."
			));
			exit;
		}
		else{			
			$inscrito = $db->listar('es_inscritos', 'cpf', $cpf);
			$atualizar_inscrito = array(
				'bool_revisor'=> 1
			);
			$db->atualizar('es_inscritos', $atualizar_inscrito, 'id', $inscrito->id);
			$novo_revisor = array(
				'fgk_inscrito'=> $inscrito->id,
				'fgk_area'=>$fgk_area,
				'fgk_area_especifica'=>$fgk_area_especifica,
				'bool_avaliador_prograd'=>$bool_avaliador_prograd,
				'bool_avaliador_proex'=>$bool_avaliador_proex,
				'bool_avaliador_caint'=>$bool_avaliador_caint
			);
			$db->inserir('es_avaliacao_revisor', $novo_revisor);
			echo json_encode(array(
				"success" => true,
				"msg" => "Revisor cadastrado com sucesso."
			));
			exit;
		}
	}
	else if($tipo_revisor == '1' || $tipo_revisor == '2' ){
		$professorTA = $db->listar('es_ufop_professores', 'cpf', $cpf);
		if($tipo_revisor == '1')
			$tipo_inscrito = 2; //professor ufop
		else
			$tipo_inscrito = 6; //TA ufop
		$db->iniciar_transacao();
		$novo_inscrito_temporario = array(
			'fgk_evento'		=> $id_evento_atual,
			'fgk_instituicao'	=> 1, //UFOP
			'fgk_tipo'			=> $tipo_inscrito,
			'cpf'				=> $cpf,
			'email'				=> $professorTA->email,
			'nome'				=> $professorTA->nome,
			'datahora_registro'	=> date('Y-m-d'),
			'fgk_area_coordenacao'	=> 0,
			'bool_revisor'		=> 1,
			'bool_temp'			=> 1
		);
		$db->inserir('es_inscritos', $novo_inscrito_temporario);
		$id_inscrito_temporario = $db->lastInsertId();
		$novo_revisor = array(
			'fgk_inscrito'			=> $id_inscrito_temporario,
			'fgk_area'				=> $fgk_area,
			'fgk_area_especifica'	=> $fgk_area_especifica,
			'bool_avaliador_prograd'=> $bool_avaliador_prograd,
			'bool_avaliador_proex'	=> $bool_avaliador_proex,
			'bool_avaliador_caint'	=> $bool_avaliador_caint
		);
		$db->inserir('es_avaliacao_revisor', $novo_revisor);
		$db->commit();
		echo json_encode(array(
			"success" => true,
			"msg" => "Revisor cadastrado com sucesso."
		));
		exit;
	}
	else if($tipo_revisor == '3'){
		$aluno = $db->listar('es_ufop_alunos', 'cpf', $cpf);
		$db->iniciar_transacao();
		$novo_inscrito_temporario = array(
			'fgk_evento'		=> $id_evento_atual,
			'fgk_instituicao'	=> 1, //UFOP
			'fgk_tipo'			=> 1, // aluno ufop
			'cpf'				=> $cpf,
			'email'				=> $aluno->email,
			'nome'				=> $aluno->nome,
			'datahora_registro'	=> date('Y-m-d'),
			'fgk_area_coordenacao'	=> 0,
			'bool_revisor'		=> 1,
			'bool_temp'			=> 1
		);
		$db->inserir('es_inscritos', $novo_inscrito_temporario);
		$id_inscrito_temporario = $db->lastInsertId();
		$novo_revisor = array(
			'fgk_inscrito'			=> $id_inscrito_temporario,
			'fgk_area'				=> $fgk_area,
			'fgk_area_especifica'	=> $fgk_area_especifica,
			'bool_avaliador_prograd'=> $bool_avaliador_prograd,
			'bool_avaliador_proex'	=> $bool_avaliador_proex,
			'bool_avaliador_caint'	=> $bool_avaliador_caint
		);
		$db->inserir('es_avaliacao_revisor', $novo_revisor);
		$db->commit();
		echo json_encode(array(
			"success" => true,
			"msg" => "Revisor cadastrado com sucesso."
		));
		exit;
	}
?>