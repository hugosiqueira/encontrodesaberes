<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	function preparaEmail($texto_email, $listaTrabalhos ){
		$partestexto = explode('*todostrabalhos*', $texto_email);
		$texto_email = $partestexto[0].$listaTrabalhos.$partestexto[1];
		return $texto_email;
	}


	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$texto_email 	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$filtros = array();
	$queryString = "
		SELECT  es_trabalho_autor.id AS id_autor, es_trabalho_autor.nome AS nome_autor, es_trabalho_autor.fgk_tipo_autor, es_trabalho_autor.email AS email_autor, es_trabalho_autor.cpf AS cpf_autor, es_tipo_autor.descricao_tipo

		,es_trabalho.*, es_ufop_areas.id_area, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_orgao_fomento.sigla AS sigla_orgao, es_orgao_fomento.nome AS nome_orgao, es_trabalho_apresentacao.cod_poster, es_trabalho_apresentacao.id AS id_apresentacao, es_inscritos.nome AS avaliador, es_sessao.nome AS nome_sessao, es_sessao.dia, es_sessao.hora_ini, es_sessao.hora_fim, es_area_especifica.descricao_area_especifica, DATE_FORMAT(es_sessao.dia, '%d/%m/%Y') as dia_correto

		FROM es_trabalho
		 INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
		 LEFT JOIN es_trabalho_autor ON es_trabalho_autor.fgk_trabalho = es_trabalho.id
		  LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
		 LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento

		 LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_trabalho = es_trabalho.id
		 LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
		 LEFT JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor
		 LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito

		WHERE es_trabalho.fgk_evento = ?
		 AND es_trabalho.fgk_tipo_apresentacao = 1
		 AND (es_trabalho.fgk_status = 6 OR es_trabalho.fgk_status = 14)
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])&& $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.titulo_enviado LIKE ? OR
			es_trabalho.palavras_chave LIKE ? OR
			es_orgao_fomento.sigla LIKE ? OR
			es_inscritos.nome LIKE ? OR
			es_trabalho_apresentacao.cod_poster LIKE ? OR
			es_trabalho.resumo_enviado LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}

	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_trabalho.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_revisor'])&&($_REQUEST['fgk_revisor']!='')){
			$fgk_revisor = $_REQUEST['fgk_revisor'];
			$queryString.= " AND es_avaliacao_revisor.id = ?";
			$filtros[] = $fgk_revisor;
		}
		if(isset($_REQUEST['fgk_sessao'])&&($_REQUEST['fgk_sessao']!='')){
			$fgk_sessao = $_REQUEST['fgk_sessao'];
			$queryString.= " AND es_sessao.id = ?";
			$filtros[] = $fgk_sessao;
		}
		if(isset($_REQUEST['bool_alocado'])&&($_REQUEST['bool_alocado']!='')){
			$bool_alocado = $_REQUEST['bool_alocado'];
			if($bool_alocado == "1")
				$queryString.= " AND es_trabalho_apresentacao.id > 0";
			else if($bool_alocado == "0")
				$queryString.= " AND es_trabalho_apresentacao.id IS NULL";
		}
	}
	if($_REQUEST['radio'] == 'true'){
		$queryString.= " AND es_trabalho.id = ?";
		$filtros[] = $_REQUEST['id_trabalho'];
	}

	if(isset($_REQUEST['destinatario_autor'])&&$_REQUEST['destinatario_autor']!='false')
		$autor = " fgk_tipo_autor = 1 ";
	else
		$autor = " 0 ";
	// if(isset($_REQUEST['destinatario_orientador'])&&$_REQUEST['destinatario_orientador']!='false')
		// $orientador = " fgk_tipo_autor = 2 ";
	// else
		$orientador = " 0 ";
	if(isset($_REQUEST['destinataro_coautor'])&&$_REQUEST['destinataro_coautor']!='false')
		$coautor = " fgk_tipo_autor = 3 ";
	else
		$coautor = " 0 ";
	if(isset($_REQUEST['colaborador'])&&$_REQUEST['colaborador']!='false')
		$colaborador = " fgk_tipo_autor = 4 ";
	else
		$colaborador = " 0 ";
	$complemento = " AND( $autor OR $orientador OR $coautor OR $colaborador )";
	$queryString .= $complemento;

	$query = $db->sql_query($queryString,$filtros);

	$contador = 0;

	foreach ($query as $trabalhoAutores){
		$id_autor = $trabalhoAutores->id_autor;
		$nome_autor = $trabalhoAutores->nome_autor;
		$email_autor = $trabalhoAutores->email_autor;
		$descricao_tipo  = $trabalhoAutores->descricao_tipo ;
		$emails = array();
		$emails[] = $email_autor;

		$listaTrabalhos = "
			SESSÃO: ".$trabalhoAutores->nome_sessao."</br>
			Dia: ".$trabalhoAutores->dia_correto."</br>
			Horário: ".$trabalhoAutores->hora_ini." - ".$trabalhoAutores->hora_fim."</br>
			<a href='http://www.encontrodesaberes.com.br/detalhes.php?id=".$trabalhoAutores->id."'>".$trabalhoAutores->titulo_enviado."</a></br>($descricao_tipo)</br>
		";

		$texto_final = preparaEmail($texto_email, $listaTrabalhos );
		// echo $texto_final;

		$novo_email = array(
			'fgk_evento'		=> $id_evento_atual,
			'cpf_destinatario'	=> $trabalhoAutores->cpf_autor,
			'nome_destinatario'	=> $nome_autor,
			'email_destinatario'=> $email_autor,
			'categoria'			=> $categoria,
			'assunto'			=> $titulo,
			'corpo_email'		=> $texto_final
		);
		$db->inserir('es_comunicacao_email', $novo_email);

		$json_string = array(
		  'to' => $emails,
		  'category' => $categoria
		);
		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'x-smtpapi' => json_encode($json_string),
			'to'        => $emails,
			'subject'   => $titulo,
			'html'      => $texto_final,
			'text'      => $texto_final,
			'from'      => 'encontrodesaberes@ufop.br',
		);
		$request =  $url.'api/mail.send.json';
		$session = curl_init($request);
		curl_setopt ($session, CURLOPT_POST, true);
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($session);
		curl_close($session);

	}

	echo json_encode(array(
		"success" =>true,
		"total" => $contador
	));
?>