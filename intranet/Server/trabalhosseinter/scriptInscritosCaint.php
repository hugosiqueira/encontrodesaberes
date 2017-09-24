<?php
	require_once("../../includes/db_connect.php");

	$queryString = "
		SELECT es_trabalho_caint.id, es_trabalho_caint.cpf, es_trabalho_caint.nome_aluno AS nome_trabalho, es_inscritos.nome AS nome_inscrito, es_inscritos.id AS id_inscrito
		FROM es_trabalho_caint
			INNER JOIN es_inscritos ON es_inscritos.cpf = es_trabalho_caint.cpf
		WHERE es_trabalho_caint.fgk_evento = 8
		ORDER BY es_trabalho_caint.id
	";
	$query = $db->sql_query2($queryString);

	$resultado = array();
	echo $query->rowCount()."<br>";
	foreach ($query as $res){
		echo $res->cpf."<br>";
		echo $res->nome_trabalho."<br>";
		echo $res->nome_inscrito."<br><br>";
		
		$edit = array('fgk_inscrito' => $res->id_inscrito);
		$db->atualizar('es_trabalho_caint', $edit, 'id', $res->id);
	}
?>