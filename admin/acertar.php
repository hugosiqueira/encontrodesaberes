<?php

include ("../../config.php");

/*$verifica_email = $db->sql_query("SELECT es_inscritos.email, es_certificados.id_certificado FROM es_certificados left join es_inscritos ON es_inscritos.cpf = es_certificados.cpf where es_certificados.fgk_tipo = 2 AND es_certificados.fgk_evento = 8");
foreach ($verifica_email as $key) {
	$id_certificado = $key->id_certificado;
	$email = $key->email;
	$db->atualizar('es_certificados', array('email'=>$email), 'id_certificado', $id_certificado);
}
/*$verifica = $db->sql_query("SELECT es_avaliacao.*, fgk_trabalho FROM es_avaliacao_revisao LEFT JOIN es_avaliacao ON fgk_avaliacao = es_avaliacao.id LEFT JOIN es_trabalho ON es_avaliacao.fgk_trabalho = es_trabalho.id WHERE es_avaliacao.bool_caint = 1 ");
$i = 0;
foreach ($verifica as $registro) {
	$id_trabalho = $registro->fgk_trabalho;
	$resultado = $registro->resultado;
	if($resultado == 'A')
		$status = 6;
	else if($resultado == 'AR')
		$status = 7;
	else if($resultado == 'R')
		$status = 8;
	$db->atualizar('es_trabalho_caint', array('fgk_status'=>$status), 'id', $id_trabalho);
	$i++;
	echo $id_trabalho.' - '.$resultado. '<br>';
}*/
