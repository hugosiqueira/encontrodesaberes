<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$id_area		 = $_REQUEST['id_area'];
	$id_trabalho		 = $_REQUEST['id_trabalho'];
	$id_area_especifica		 = $_REQUEST['id_area_especifica'];

	$filtros = array();
	$queryString = "
		SELECT
			SUM(CASE WHEN (es_trabalho_apresentacao.id IS NOT NULL) THEN 1 ELSE 0 END) alocados,
			es_avaliacao_revisor.id, es_inscritos.nome, es_area_especifica.descricao_area_especifica
		FROM es_avaliacao_revisor
		 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		 LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_revisor = es_avaliacao_revisor.id
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_avaliacao_revisor.fgk_area_especifica
		WHERE es_avaliacao_revisor.fgk_area = ?
		 AND es_avaliacao_revisor.id IN (
				SELECT fgk_revisor
				FROM es_avaliacao_revisor_horarios
				 INNER JOIN es_sessao ON es_sessao.id = es_avaliacao_revisor_horarios.fgk_sessao
				WHERE es_sessao.fgk_evento = ?
			)
			AND es_inscritos.cpf not in (
				Select cpf
				from es_trabalho_autor
				where es_trabalho_autor.fgk_trabalho = ?
			)
	";
	$filtros[] = $id_area;
	$filtros[] = $id_evento_atual;
	$filtros[] = $id_trabalho;
	if(intval($id_area_especifica)>0){
		$queryString .= "
			AND es_avaliacao_revisor.fgk_area_especifica = ?
		";
		$filtros[] = $id_area_especifica;
	}
	$queryString .= "
		GROUP BY es_avaliacao_revisor.id
		ORDER BY es_inscritos.nome
	";
	$query = $db->sql_query2($queryString,$filtros);

	$resultado = array();
	foreach ($query as $res){
		$filtrosSessoes = array();
		$querySessoes = "
			SELECT es_sessao.nome, count(es_trabalho_apresentacao.id) AS contador 
			FROM es_sessao
			RIGHT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_sessao = es_sessao.id
			WHERE es_trabalho_apresentacao.fgk_revisor = ?
			GROUP BY fgk_sessao
		";
		$filtrosSessoes[] = $res->id;
		$qrySessoes = $db->sql_query2($querySessoes,$filtrosSessoes);
		$tooltip = "
			<table><tr><td><b>Sessão</b></td><td align='center'><b>Qtd.</b></td></tr>
			<tr><td colspan=2><b><hr></b></td></tr>
		";
		foreach ($qrySessoes as $resSessoes){
			$tooltip .= "<tr><td>".$resSessoes->nome."</td><td align='center'>".$resSessoes->contador."</td></tr>";
		}
		$tooltip .= "</table>";
		$res->tooltip = $tooltip;		
		$resultado[] = $res;
	}

	echo json_encode(array(
		"success" => true,
		"total" => $query->rowCount(),
		"resultado" => $resultado
	));
?>