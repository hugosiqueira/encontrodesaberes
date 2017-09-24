<?php
	require_once("../../includes/functions.php");
	sec_session_start();

	$busca = "
		SELECT es_avaliacao_revisor.id, es_inscritos.id AS id_inscrito, es_inscritos.cpf, es_inscritos.bool_revisor
		FROM es_avaliacao_revisor
			INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		WHERE 1
		ORDER BY es_avaliacao_revisor.id
	";
	$busca = $db->sql_query($busca);
	$db->iniciar_transacao();
	foreach($busca as $res){
		if($res->bool_revisor==0)
			echo '<b>'.$res->id.' '.$res->cpf.' '.$res->bool_revisor.'</b><br>';
		// else
			// echo $res->id.' '.$res->cpf.' '.$res->bool_revisor.'<br>';
	}
	$db->commit();
?>