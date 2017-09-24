<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');

	$json = $_POST['projeto'];
	$dados = json_decode($json);
	$id_projeto = $dados->id;

	$db->iniciar_transacao();
	// 

	$dadosTrabalho = array('fgk_projeto'=> $id_projeto);
	$existeTrabalho = $db->existe('es_trabalho', $dadosTrabalho);
	if($existeTrabalho){
		$result = $db->listar('es_trabalho', 'fgk_projeto', $id_projeto);
		$trabalho_status = $result->fgk_status;
		$trabalho_id = $result->id;

		if($trabalho_status == 1){//status 1 indica que o projeto pode ser deletado
			$db->excluir('es_projeto', 'id', $id_projeto);
			$db->excluir('es_trabalho', 'fgk_projeto', $id_projeto);
			$db->excluir('es_trabalho_autor', 'fgk_trabalho', $trabalho_id);
			echo json_encode(array(
				"success"=> true,
				"msg" => "Projeto e trabalho excluídos com sucesso."
			));
		}else
			echo json_encode(array(
				"success"=> false,
				"msg" => "Projeto não excluído, trabalho já submetido."
			));
	}else{
		$db->excluir('es_projeto', 'id', $id_projeto);
		echo json_encode(array(
			"success"=> true,
			"msg" => "Projeto excluído com sucesso."
		));
	}

	$db->commit();
?>