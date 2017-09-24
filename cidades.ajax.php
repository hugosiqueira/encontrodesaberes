<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	include_once("conexao.php");
	$id_estado =  $_REQUEST['estado'];

	$cidades = array();

	$stmt = $conexao->prepare("SELECT id_cidade, descricao_cidade
			FROM desk_cidades
			INNER JOIN desk_estados ON fgk_estado=id_estado
			WHERE uf=:id_estado
			ORDER BY descricao_cidade");
	$stmt->bindValue(':id_estado', $id_estado);

	$stmt->execute();


	while ( $row =$stmt->fetch(PDO::FETCH_ASSOC) ) {
		$cidades[] = array(
			'id_cidade'	=> $row['id_cidade'],
			'nome'		=> $row['descricao_cidade']
		);
	}

	echo( json_encode( $cidades ) );