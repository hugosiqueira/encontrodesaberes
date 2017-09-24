<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$cpf = $_POST['cpf'];
	$id_minicurso = $_POST['id_minicurso'];
	$filtros = array();
	$busca = "
		SELECT es_inscritos.id, es_inscritos.nome, es_inscritos.email, es_inscritos.departamento, es_ufop_departamentos.nome_departamento, es_inscritos.fgk_departamento, es_inscritos.fgk_instituicao
		FROM es_inscritos
		 LEFT JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_inscritos.fgk_departamento
		WHERE fgk_evento = ? AND cpf = ?
	";
	$filtros[] = intval($id_evento_atual);
	$filtros[] = $cpf;
	$inscrito = $db->sql_query2($busca, $filtros);
	if($inscrito->rowCount() > 0){
		foreach ($inscrito as $registro) {
			$id_inscrito = $registro->id;
			$nome_inscrito = $registro->nome;
			$email_inscrito = $registro->email;
		}
		if($registro->fgk_instituicao == 1)
			$rend_departamento = $registro->fgk_departamento;
		else
			$rend_departamento = $registro->departamento;
		$verificaSeJaTem = "
			SELECT es_minicursos_inscritos.*
			FROM es_minicursos_inscritos
			 INNER JOIN es_inscritos_servicos ON es_inscritos_servicos.id_inscrito_servico = es_minicursos_inscritos.fgk_inscrito_servico
			WHERE es_minicursos_inscritos.fgk_minicurso = ? AND es_inscritos_servicos.fgk_inscrito = ?
		";
		$filtros = array();
		$filtros[] = intval($id_minicurso);
		$filtros[] = intval($id_inscrito);
		$jaTem = $db->sql_query2($verificaSeJaTem, $filtros);
		if($jaTem->rowCount() > 0){
			echo json_encode(array(
				"success" => false,
				"msg"	=> "Inscrito já matriculado neste minicurso."
			));
			exit;
		}
		else{
			echo json_encode(array(
				"success" => true,
				"id_inscrito" 	=> $id_inscrito,
				"nome"			=> $nome_inscrito,
				"rend_departamento" => $rend_departamento,
				"email"			=> $email_inscrito
			));
			exit;
		}
	}
	else{
		echo json_encode(array(
			"success" => false,
			"msg"	=> 'Nenhum inscrito foi encontrado para o CPF: <b>'.$cpf.'</b>'
		));
		exit;
	}
?>