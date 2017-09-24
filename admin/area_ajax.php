<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	include_once("../../config.php");
	$id_area =  $_REQUEST['area'];

	$area_especifica = array();

	$stmt = $db->sql_query("SELECT * FROM es_area_especifica WHERE fgk_area = ? ORDER BY descricao_area_especifica", array('fgk_area'=> $id_area));
	foreach ($stmt as $area) {
		$area_especifica[] = array(
			'id_area_especifica'	=> $area->id,
			'nome'		=> $area->descricao_area_especifica);
	}

	echo( json_encode( $area_especifica ) );
                                                   