<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$db->iniciar_transacao();

	$id_evento = $_SESSION['id_evento_atual'];
	$json = $_POST['insc'];
	$dados = json_decode($json);
		$id_inscrito = $dados->id;
		$nome_credencial = $dados->nome_credencial;
		$barcode = $dados->barcode;
		$nome_instituicao = $dados->nome_instituicao;

	$vars0 = array('fgk_evento'=>$id_evento, 'fgk_inscrito'=>$id_inscrito);
	$credencial = $db->existe('es_inscritos_credencial', $vars0);
	if($credencial){
		echo json_encode(array(
			"success"=>false,
			"msg"=>"Inscrito já credenciado neste evento."
		));
		exit();
	}else{
		$barcode = str_replace('*', '', $barcode);
		$result = $db->listar('es_inscritos', 'id', $id_inscrito);
			$tipo_credencial = $result->fgk_tipo;
			$fgk_instituicao = $result->fgk_instituicao;
	
		$vars = array('fgk_evento'=>$id_evento, 'fgk_inscrito'=>$id_inscrito, 'tipo_credencial'=>$tipo_credencial, 'instituicao_inscrito'=>$fgk_instituicao, 'nome_credencial'=>$nome_credencial, 'codigo_credenciamento'=>$barcode, 'info_credencial'=>$nome_instituicao);
		$db->inserir('es_inscritos_credencial', $vars);

		$vars2 = array('bool_cracha'=>1);
		$db->atualizar('es_inscritos', $vars2, 'id', $id_inscrito);

		$db->commit();
		echo json_encode(array(
			"success"=>true,
			"msg"=>"Inscrito credenciado com sucesso!"
		));
	}
?>