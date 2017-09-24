<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

		$queryString = "
			SELECT cod_poster, id
			FROM es_trabalho_apresentacao
			WHERE cod_poster LIKE '%CV%'
			ORDER BY id ASC
		";
		$query = $db->sql_query2($queryString);
		$x=1;
		foreach ($query as $res){
			$cod_poster = $res->cod_poster;
			$cod_poster = "CV-".str_pad($x, 3, "0", STR_PAD_LEFT);
			echo $res->id." ".$res->cod_poster." ".$cod_poster."</br>";

			$atualiza = array(
				'cod_poster'	=> $cod_poster
			);
			$db->atualizar('es_trabalho_apresentacao', $atualiza, 'id', $res->id);
			$x++;
		}
?>