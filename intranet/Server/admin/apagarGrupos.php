<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");

	$json = $_POST['grupo'];

	$dados = json_decode($json);
	$id_grupo = $dados->id_grupo;

	$db->excluir('desk_grupos_modulos', 'fgk_grupo', $id_grupo);
	$db->excluir('desk_grupos_permissoes', 'fgk_grupo', $id_grupo);
	$db->excluir('desk_usuarios_grupos', 'fgk_grupo', $id_grupo);
	$db->excluir('desk_grupos', 'id_grupo', $id_grupo);

	echo json_encode(array(
		"success" => true
	));
?>