<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	
	/*
	id_trabalho:398
	id_sessao:4
	id_revisor:281
	id_apresentacao:0
	*/
	function novoCod($codigo){
		$vet = explode('-',$codigo);
		$aux = intval($vet[1]);
		$aux++;
		$retorno = $vet[0]."-".str_pad($aux, 3, "0", STR_PAD_LEFT);
		return $retorno;
	}

	$id_trabalho		= $_REQUEST['id_trabalho'];
	$id_sessao			= $_REQUEST['id_sessao'];
	$id_revisor			= $_REQUEST['id_revisor'];
	$alocados			= $_REQUEST['alocados'];
	$id_apresentacao	= $_REQUEST['id_apresentacao'];
	$codigo_area		= $_REQUEST['codigo_area'];
	$id_area		= $_REQUEST['id_area'];

	if($id_apresentacao!='0'){
		$atualiza = array(
			'fgk_sessao'	=> $id_sessao,
			'fgk_revisor'	=> $id_revisor
		);
		$db->atualizar('es_trabalho_apresentacao', $atualiza, 'id', $id_apresentacao);
		echo json_encode(array(
			"success" => true,
			"cod_poster" => $cod_poster
		));
		exit;
	}
	else{
		//novo codigo
		$filtros = array();
		$queryString = "
			SELECT cod_poster
			FROM es_trabalho_apresentacao
				INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
			WHERE cod_poster LIKE ?
				AND es_trabalho.fgk_evento = ?
			ORDER BY cod_poster DESC LIMIT 1
		";
		$filtros[] = '%'.$codigo_area.'%';
		$filtros[] = $id_evento_atual;
		$query = $db->sql_query2($queryString,$filtros);
		foreach ($query as $res)
			$cod_poster = $res->cod_poster;

		if($cod_poster) //se já tem algum cadastro prévio incrementa, se não começa um novo com 001
			$cod_poster = novoCod($cod_poster);
		else
			$cod_poster = $codigo_area."-001";

		//checar capacidade da id_sessao
		$filtros = array();
		$queryString = "
			SELECT capacidade
			FROM es_sessao_capacidade
			WHERE fgk_sessao = ? AND fgk_area = ?
		";
		$filtros[] = $id_sessao;
		$filtros[] = $id_area;
		$query = $db->sql_query2($queryString,$filtros);
		foreach ($query as $res)
			$capacidade = $res->capacidade;

		if($capacidade > $alocados){
			$nova = array(
				'fgk_trabalho'		=> $id_trabalho,
				'fgk_revisor'		=> $id_revisor,
				'fgk_sessao'		=> $id_sessao,
				'cod_poster'		=> $cod_poster,
				'datahora_registro'	=> date('Y-m-d H:i:s')
			);
			$db->inserir('es_trabalho_apresentacao', $nova);
			echo json_encode(array(
				"success" => true,
				"cod_poster" => $cod_poster
			));
			exit;
		}
		else{
			echo json_encode(array(
				"success" => false,
				"msg" => "Capacidade da sessão esgotada."
			));
			exit;
		}
	}

	

?>