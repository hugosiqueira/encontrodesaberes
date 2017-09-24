<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento = $_SESSION['id_evento_atual'];
	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$queryInscritos = "SELECT es_inscritos.telefone_celular,es_inscritos.bool_cracha, es_inscritos.id, es_inscritos.nome, cpf, es_inscritos_tipos.descricao_tipo, es_instituicao.nome AS nome_instituicao, es_instituicao.sigla AS sigla_instituicao,
		SUM(CASE WHEN es_inscritos_servicos.bool_pago = 1 THEN 1 ELSE 0 END) serv_pg,
		SUM(CASE WHEN es_inscritos_servicos.fgk_inscrito = es_inscritos.id THEN 1 ELSE 0 END) servs, 
		IF(es_presencas.fgk_inscrito, 1, 0) AS credencial, 
		COUNT(es_inscritos_servicos.fgk_inscrito) AS num_servicos
		FROM es_inscritos 
		INNER JOIN es_instituicao ON es_inscritos.fgk_instituicao = es_instituicao.id
		INNER JOIN es_inscritos_tipos ON es_inscritos.fgk_tipo = es_inscritos_tipos.id_tipo_inscrito
		LEFT JOIN es_presencas ON es_inscritos.id = es_presencas.fgk_inscrito AND es_presencas.fgk_evento = $id_evento
		LEFT JOIN es_inscritos_servicos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito 
		WHERE es_inscritos.fgk_evento = $id_evento ";

	if(isset($_REQUEST['filtro']) && ($_REQUEST['filtro'] != '')){
		$filtro = $_REQUEST['filtro'];
		$queryInscritos.=" AND ((es_inscritos.nome LIKE '%$filtro%') OR (es_inscritos.cpf LIKE '%$filtro%')) "; 
	}

	if(isset($_REQUEST['cpf']) && ($_REQUEST['cpf'] != '')){
		$cpf = $_REQUEST['cpf'];
		$queryInscritos.=" AND es_inscritos.cpf = '$cpf'"; 
	}

	if(isset($_REQUEST['nome']) && ($_REQUEST['nome'] != '')){
		$nome = $_REQUEST['nome'];
		$queryInscritos.=" AND es_inscritos.nome LIKE '%$nome%'"; 
	}

	if(isset($_REQUEST['tipo_inscrito']) && ($_REQUEST['tipo_inscrito'] != '')){
		$tipo_inscrito = $_REQUEST['tipo_inscrito'];
		$queryInscritos.=" AND es_inscritos.fgk_tipo = $tipo_inscrito"; 
	}

	if(isset($_REQUEST['instituicao']) && ($_REQUEST['instituicao'] != '')){
		$instituicao = $_REQUEST['instituicao'];
		$queryInscritos.=" AND es_inscritos.fgk_instituicao = $instituicao"; 
	}

	if(isset($_REQUEST['credenciado']) && ($_REQUEST['credenciado'] != '') && ($_REQUEST['credenciado'] != '2')){
		$credenciado = $_REQUEST['credenciado'];
		if($credenciado == 1)
			$queryInscritos.=" AND es_presencas.fgk_inscrito  IS NOT NULL";
		else
			$queryInscritos.=" AND es_presencas.fgk_inscrito  IS NULL";
	}	

	$queryInscritos.=" GROUP BY es_inscritos.id ";

	if(isset($_REQUEST['quite']) && ($_REQUEST['quite'] != '') && ($_REQUEST['quite'] != '2')){
		$quite = $_REQUEST['quite'];
		if($quite == 0)
			$queryInscritos.=" HAVING servs != serv_pg AND num_servicos != 0"; 
		else
			$queryInscritos.=" HAVING servs = serv_pg AND num_servicos != 0"; 
	}else if(isset($_REQUEST['num_servicos']) && ($_REQUEST['num_servicos'] != '')){
		$num_servicos = $_REQUEST['num_servicos'];
		$queryInscritos.=" HAVING num_servicos = $num_servicos";
	}

	if(isset($_REQUEST['quite']) && isset($_REQUEST['num_servicos'])){
		$num_servicos = $_REQUEST['num_servicos'];
		$queryInscritos.=" AND num_servicos = $num_servicos";
	}

	$total = $db->sql_query($queryInscritos);
	
	$queryInscritos.=" ORDER BY es_inscritos.nome ASC LIMIT $start, $limit; ";
	$result = $db->sql_query($queryInscritos);

	$inscritos = array();
	foreach ($result as $inscrito){
		if($inscrito->num_servicos != 0)
			if($inscrito->serv_pg == $inscrito->servs)
				$inscrito->quite = 1;
			else
				$inscrito->quite = 0;
		else
			$inscrito->quite = 2;

		$inscritos[] = $inscrito;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $total->rowCount(),
		"inscritos" => $inscritos
	));
?>