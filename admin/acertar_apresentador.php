<?php

include ("../../config.php");
/*$verifica = $db->sql_query("SELECT fgk_trabalho, cpf FROM es_trabalho_autor Left join es_trabalho on es_trabalho_autor.fgk_trabalho = es_trabalho.id Where fgk_inscrito_responsavel is null and bool_apresentador = 1 and fgk_evento = 8  
ORDER BY `es_trabalho_autor`.`fgk_trabalho` ASC");
$i = 0;
foreach ($verifica as $registro) {
	$id_trabalho = $registro->fgk_trabalho;
	$cpf = $registro->cpf;
	$verifica_cpf = $db->sql_query("Select id FROM es_inscritos where cpf = '".$cpf."'");
	foreach ($verifica_cpf as $key) {
		$id_inscrito = $key->id;
		$db->atualizar('es_trabalho', array('fgk_inscrito_responsavel'=>$id_inscrito), 'id', $id_trabalho);
		echo $id_trabalho.'<br>';
	}
}
*/

$verifica_trabalho = $db->sql_query("SELECT sum(bool_apresentador) as soma, fgk_trabalho, fgk_inscrito_responsavel, es_inscritos.id as id_inscrito, es_inscritos.cpf FROM `es_trabalho_autor` left join es_trabalho on es_trabalho_autor.fgk_trabalho = es_trabalho.id  left join es_inscritos on fgk_inscrito_responsavel = es_inscritos.id group by fgk_trabalho  having sum(bool_apresentador) = 0
ORDER BY `es_trabalho_autor`.`fgk_trabalho`  DESC");
foreach ($verifica_trabalho as $key) {
	$cpf_autor = $key->cpf;
	$fgk_trabalho = $key->fgk_trabalho;
	$verifica_trabalho_autor = $db->sql_query("Select id from es_trabalho_autor where cpf = '".$cpf_autor."' AND fgk_trabalho = $fgk_trabalho");
	foreach ($verifica_trabalho_autor as $registro) {
		$id = $registro->id;
	}
			$db->atualizar('es_trabalho_autor', array('bool_apresentador'=>1), 'id', $id);

	
		echo $fgk_trabalho.' - '.$cpf_autor.'<br>';
}

