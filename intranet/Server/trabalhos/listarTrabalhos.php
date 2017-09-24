<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];
	$start = preg_replace("/[^0-9]+/", "", $_REQUEST['start']);
	$limit = preg_replace("/[^0-9]+/", "", $_REQUEST['limit']);
	$filtros = array();

	$queryString = "
		SELECT es_trabalho_justificativa.descricao, es_trabalho.*, es_inscritos.nome, es_area_especifica.descricao_area_especifica, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_tipo_apresentacao.descricao_tipo, es_trabalho_status.descricao_status, es_categorias.descricao_categoria, es_categorias.sigla_categoria, es_instituicao.nome, es_instituicao.sigla
		FROM es_trabalho
			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			INNER JOIN es_evento ON es_evento.id = es_trabalho.fgk_evento
			LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
			LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho.fgk_instituicao
			INNER JOIN es_tipo_apresentacao ON es_tipo_apresentacao.id_tipo_apresentacao = es_trabalho.fgk_tipo_apresentacao
			INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
			INNER JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
			LEFT JOIN es_projeto ON es_projeto.id = es_trabalho.fgk_projeto
			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			LEFT JOIN es_trabalho_justificativa ON es_trabalho_justificativa.fgk_trabalho = es_trabalho.id
		WHERE es_trabalho.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['nome_autores'])&&($_REQUEST['nome_autores']!='')){
			$queryString.= "
				AND es_trabalho.id IN (
					SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
				)
			";
			$filtros[] = '%'.$_REQUEST['nome_autores'].'%';
		}
		if(isset($_REQUEST['apresentacao_obrigatoria'])&&($_REQUEST['apresentacao_obrigatoria']!='')){
			$queryString.= "  AND es_trabalho.apresentacao_obrigatoria = ?";
			$filtros[] = $_REQUEST['apresentacao_obrigatoria'];
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho.fgk_status = ? ";
			$filtros[] = $fgk_status;
		}
		if(isset($_REQUEST['fgk_orgao_fomento'])&&($_REQUEST['fgk_orgao_fomento']!='')){
			$fgk_orgao_fomento = $_REQUEST['fgk_orgao_fomento'];
			$queryString.= " AND es_trabalho.fgk_orgao_fomento = ?";
			$filtros[] = $fgk_orgao_fomento;
		}
		if(isset($_REQUEST['fgk_categoria'])&&($_REQUEST['fgk_categoria']!='')){
			$fgk_categoria = $_REQUEST['fgk_categoria'];
			$queryString.= " AND es_trabalho.fgk_categoria = ?";
			$filtros[] = $fgk_categoria;
		}
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_trabalho.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
			$queryString.= " AND es_trabalho.fgk_area_especifica = ?";
			$filtros[] = $fgk_area_especifica;
		}
		if(isset($_REQUEST['fgk_tipo_apresentacao'])&&($_REQUEST['fgk_tipo_apresentacao']!='')){
			$fgk_tipo_apresentacao = $_REQUEST['fgk_tipo_apresentacao'];
			$queryString.= " AND es_trabalho.fgk_tipo_apresentacao = ?";
			$filtros[] = $fgk_tipo_apresentacao;
		}
		if(isset($_REQUEST['avaliacao'])&&($_REQUEST['avaliacao']!='-1')){
			$avaliacao = $_REQUEST['avaliacao'];
			if($avaliacao=='0'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status = 0
					)
				";
			}
			else if($avaliacao=='1'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status > 0
					)
				";
			}
		}
	}
	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.palavras_chave 	LIKE ? OR
			es_trabalho.resumo_revisado LIKE ? OR
			es_trabalho.resumo_enviado 	LIKE ? OR
			es_trabalho.titulo_revisado LIKE ? OR
			es_trabalho.titulo_enviado 	LIKE ? OR
			es_trabalho.id IN (
				SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
			)
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	$total = $db->sql_query2($queryString,$filtros)->rowCount();
	$queryString.=" ORDER BY datahora_registro DESC LIMIT ? , ?;";
	$filtros[] = intval($start);
	$filtros[] = intval($limit);
	$query = $db->sql_query2($queryString, $filtros);

	$resultado = array();
	foreach ($query as $res){
		$res->titulo_a_mais = $res->titulo_enviado;
		$autores 	= "";
		$orientador = "";
		$queryAutores ="
			SELECT es_trabalho_autor.nome, es_trabalho_autor.fgk_tipo_autor
			FROM es_trabalho_autor
			WHERE es_trabalho_autor.fgk_trabalho = ?
			ORDER BY es_trabalho_autor.ordenacao
		";
		$queryAutores = $db->sql_query2($queryAutores,array($res->id));
		foreach ($queryAutores as $resAutor){
			if($resAutor->fgk_tipo_autor ==2){
				$orientador = $resAutor->nome;
			}
			else{
				if($autores=="")
					$autores = $resAutor->nome;
				else
					$autores = $autores.", ".$resAutor->nome;
			}
		}
		$res->todos_autores = $autores;
		$res->orientador 	= $orientador;
		$resultado[] = $res;
	}
	echo json_encode(array(
		"success" 	=> true,
		"total" 	=> $total,
		"resultado" => $resultado
	));
?>