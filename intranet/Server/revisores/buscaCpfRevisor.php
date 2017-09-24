<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$cpf = $_POST['cpf'];
	$filtros = array();
	$busca = "
		SELECT es_inscritos.id, es_inscritos.nome, es_inscritos.email, es_inscritos.departamento, es_ufop_departamentos.nome_departamento, es_inscritos.fgk_instituicao, es_inscritos.fgk_departamento, es_avaliacao_revisor.bool_avaliador_prograd, es_avaliacao_revisor.bool_avaliador_proex, es_avaliacao_revisor.bool_avaliador_caint, es_avaliacao_revisor.fgk_area, es_avaliacao_revisor.fgk_area_especifica, es_avaliacao_revisor.id AS id_revisor
		FROM es_inscritos
		 LEFT JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_inscritos.fgk_departamento
		 LEFT JOIN es_avaliacao_revisor ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id
		WHERE fgk_evento = ? AND cpf = ?
	";	
	$filtros[] = intval($id_evento_atual);
	$filtros[] = $cpf;
	$inscrito = $db->sql_query2($busca, $filtros);
	if($inscrito->rowCount() > 0){ //revisor já é um inscrito
		foreach ($inscrito as $registro) {
			if($registro->id_revisor > 0){
				if($registro->fgk_instituicao == 1)
					$rend_departamento = $registro->fgk_departamento;
				else
					$rend_departamento = $registro->departamento;
				$nome = $registro->nome;
				$email = $registro->email;
				
				echo json_encode(array(
					"success" => true,
					"tipo_revisor" => -1,
					"nome" => $nome,
					"rend_departamento" 	=> $rend_departamento,
					"bool_avaliador_prograd"=> $registro->bool_avaliador_prograd,
					"bool_avaliador_proex" 	=> $registro->bool_avaliador_proex,
					"bool_avaliador_caint" 	=> $registro->bool_avaliador_caint,
					"fgk_area" 				=> $registro->fgk_area,
					"fgk_area_especifica" 	=> $registro->fgk_area_especifica,
					"id_revisor" => $registro->id_revisor,
					"email"=> $email
				));
				exit;	
			}
			else{
				if($registro->fgk_instituicao == 1)
					$rend_departamento = $registro->fgk_departamento;
				else
					$rend_departamento = $registro->departamento;
				$nome = $registro->nome;
				$email = $registro->email;
			
				echo json_encode(array(
					"success" => true,
					"tipo_revisor" => 0,
					"nome" => $nome,
					"rend_departamento" => $rend_departamento,
					"email"=> $email
				));
				exit;			
			}
		}
	}
	else{
		$dados = array('cpf'=> $cpf);
		if($db->existe('es_ufop_professores', $dados)){
			$professor = $db->listar('es_ufop_professores', 'cpf', $cpf);
			echo json_encode(array(
				"success" => true,
				"tipo_revisor" => $professor->fgk_tipo,
				"nome" => $professor->nome,
				"rend_departamento" => $professor->fgk_departamento,
				"email"=> $professor->email
			));
			exit;
		}
		else{
			if($db->existe('es_ufop_alunos', $dados)){
				$aluno = $db->listar('es_ufop_alunos', 'cpf', $cpf);
				echo json_encode(array(
					"success" => true,
					"tipo_revisor" => 3,
					"nome" => $aluno->nome,
					"email"=> $aluno->email
				));
				exit;
			}
			else{
				echo json_encode(array(
					"success" => false
				));
				exit;
			}
		}
	}
?>