<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];

	if(isset($_POST['cpf'])){
		$db->iniciar_transacao();

		$cpf = $_POST['cpf']; 	
		$fgk_evento = $_SESSION['id_evento_atual'];
		$info_credencial;

		$vars0 = array('cpf'=> $cpf, 'fgk_evento'=> $fgk_evento);
	 	$result = $db->sql_query("SELECT TRIM(es_inscritos.nome) AS nome, es_inscritos.email, es_inscritos.id, es_instituicao.nome AS nome_inst FROM es_inscritos 
	 								INNER JOIN es_instituicao ON es_inscritos.fgk_instituicao = es_instituicao.id
	 								WHERE es_inscritos.cpf = ? AND es_inscritos.fgk_evento = ?;", $vars0);
		foreach ($result as $inscrito){
			$nome = $inscrito->nome;
			$email = $inscrito->email;
			$id = $inscrito->id;
			$nome_inst = $inscrito->nome_inst;
		}

		$vars1 = array('fgk_evento'=>$id_evento, 'fgk_inscrito'=>$id);
		$credencial = $db->existe('es_inscritos_credencial', $vars1);
		if($credencial){
			$vars2 = array('fgk_evento'=> $fgk_evento, 'fgk_inscrito'=>$id);
		 	$result = $db->sql_query("SELECT nome_credencial, codigo_credenciamento, info_credencial FROM es_inscritos_credencial WHERE fgk_evento = ? AND fgk_inscrito = ?;", $vars2);
			foreach ($result as $inscrito){
				$nome_credencial = $inscrito->nome_credencial;
				$barcode = $inscrito->codigo_credenciamento;
				$info_credencial = $inscrito->info_credencial;
			}
			echo json_encode(array(
				"success" => true,
				"nome" => $nome,
				"email" => $email,
				"nome_credencial" => $nome_credencial,
				"barcode" => '*'.$barcode.'*',
				"info_credencial"=>$info_credencial
			));
		}else{
			$nomes = explode(' ', ucwords(mb_strtolower($nome)));
			$primeiro_nome = array_shift($nomes);
			$ultimo_nome = array_pop($nomes);
			$nome_credencial = $primeiro_nome." ".$ultimo_nome;
			$barcode = str_pad($id.$fgk_evento,10,'0', STR_PAD_BOTH);

			echo json_encode(array(
				"success" => true,
				"nome" => $nome,
				"email" => $email,
				"nome_credencial" => $nome_credencial,
				"barcode" => '*'.$barcode.'*',
				"info_credencial"=>$nome_inst
			));
		}
		$db->commit();
	}
?>