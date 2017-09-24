<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	//busca rapida
	$buscaRapida	= $_REQUEST['buscaRapida'];
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_trabalho.palavras_chave LIKE '%$buscaRapida%' OR
			es_trabalho.resumo_revisado LIKE '%$buscaRapida%' OR
			es_trabalho.resumo_enviado LIKE '%$buscaRapida%' OR
			es_trabalho.titulo_revisado LIKE '%$buscaRapida%' OR
			es_trabalho.titulo_enviado LIKE '%$buscaRapida%'
		)";
	}
	//filtros da pesquisa avancada
	$pa_autores = " 1";
	$pa	= $_REQUEST['pa'];
	if($pa == '1'){
		$apresentacao_obrigatoria	= $_REQUEST['apresentacao_obrigatoria'];
		$nome_autores				= $_REQUEST['nome_autores'];
		if($nome_autores!="")
			$pa_autores = " es_trabalho_autor.nome LIKE '%$nome_autores%'";
		$fgk_status					= $_REQUEST['fgk_status'];
		$fgk_area					= $_REQUEST['fgk_area'];
		$fgk_area_especifica		= $_REQUEST['fgk_area_especifica'];
		$fgk_tipo_apresentacao		= $_REQUEST['fgk_tipo_apresentacao'];
		$fgk_orgao_fomento			= $_REQUEST['fgk_orgao_fomento'];
		$fgk_categoria				= $_REQUEST['fgk_categoria'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s AND %s AND %s ",
			($_REQUEST['fgk_status'])		? "( es_trabalho.fgk_status = $fgk_status )" 	: "1",
			($_REQUEST['fgk_orgao_fomento'])? "( es_trabalho.fgk_orgao_fomento = $fgk_orgao_fomento )" 	: "1",
			($_REQUEST['fgk_categoria'])	? "( es_trabalho.fgk_categoria = $fgk_categoria )" 	: "1",
			($_REQUEST['fgk_area'])			? "( es_trabalho.fgk_area = $fgk_area )" : "1",
			($_REQUEST['fgk_area_especifica'])? "( es_trabalho.fgk_area_especifica = $fgk_area_especifica )" : "1",
			($_REQUEST['fgk_tipo_apresentacao'])? "( es_trabalho.fgk_tipo_apresentacao = '$fgk_tipo_apresentacao' )" : "1"
		);
		if(isset($_REQUEST['apresentacao_obrigatoria'])){
			if($apresentacao_obrigatoria == '0'){
				$busca_avancada .= " AND es_trabalho.apresentacao_obrigatoria = 0";
			}
			else if($apresentacao_obrigatoria == '1'){
				$busca_avancada .= " AND es_trabalho.apresentacao_obrigatoria = 1";
			}
		}
	}
	else{
		$busca_avancada = "";
	}
	//formulário
	if($_REQUEST['radio'] == 'selecionado'){
		$id = $_REQUEST['id_trabalho'];
		$trabalho = " AND es_trabalho.id = $id";
	}
	else{
		$trabalho = "";
	}
	if(isset($_REQUEST['destinatario_autor'])&&$_REQUEST['destinatario_autor']!='false')
		$autor = " fgk_tipo_autor = 1 ";
	else
		$autor = " 0 ";
	if(isset($_REQUEST['destinatario_orientador'])&&$_REQUEST['destinatario_orientador']!='false')
		$orientador = " fgk_tipo_autor = 2 ";
	else
		$orientador = " 0 ";
	if(isset($_REQUEST['destinataro_coautor'])&&$_REQUEST['destinataro_coautor']!='false')
		$coautor = " fgk_tipo_autor = 3 ";
	else
		$coautor = " 0 ";
	if(isset($_REQUEST['colaborador'])&&$_REQUEST['colaborador']!='false')
		$colaborador = " fgk_tipo_autor = 4 ";
	else
		$colaborador = " 0 ";

	$queryString = "
		SELECT es_trabalho.*, es_trabalho_autor.nome, es_trabalho_autor.cpf, es_trabalho_autor.email, es_trabalho_autor.fgk_tipo_autor
		FROM es_trabalho
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
		 INNER JOIN es_evento ON es_evento.id = es_trabalho.fgk_evento
		 LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
		 INNER JOIN es_tipo_apresentacao ON es_tipo_apresentacao.id_tipo_apresentacao = es_trabalho.fgk_tipo_apresentacao
		 INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
		 INNER JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
		 LEFT JOIN es_projeto ON es_projeto.id = es_trabalho.fgk_projeto
		 LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
		 LEFT JOIN es_trabalho_autor ON es_trabalho_autor.fgk_trabalho = es_trabalho.id
		WHERE $filtro
		 AND es_trabalho.fgk_evento = $id_evento_atual
		 $busca_avancada
		 $trabalho
		 AND ($autor OR $orientador OR $coautor OR $colaborador )
		 AND $pa_autores
		 AND es_trabalho_autor.email IS NOT NULL
		 AND es_trabalho_autor.email <> ''
		GROUP BY es_trabalho_autor.cpf
		ORDER BY datahora_registro DESC
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$emails = array();
	$contador=0;
	while($registro = mysqli_fetch_assoc($query)) {
		$contador++;
		$emails[] = $registro['email'];
	}

	echo json_encode(array(
		"success" =>true,
		"total" => $contador
	));

?>