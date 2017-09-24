<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	include_once("conexao.php");
	$id_tipo_inscrito =  $_REQUEST['tipo_inscricao'];

	$cidades = array();

	$stmt = $conexao->prepare("SELECT valor_servico
			FROM es_inscritos_tipos
			INNER JOIN es_servicos ON fgk_servico_inscricao = id_servico
			WHERE id_tipo_inscrito=:id_tipo_inscrito
			");
	$stmt->bindValue(':id_tipo_inscrito', $id_tipo_inscrito);

	$stmt->execute();


	while ( $row =$stmt->fetch(PDO::FETCH_ASSOC) ) {
		$valor[] = array('valor_inscricao'=>$row['valor_servico']) ;
	}

	echo( json_encode($valor) );