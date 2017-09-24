<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	date_default_timezone_set('America/Sao_Paulo');
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$texto_email 	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$filtros = array();
	$queryString = "
		SELECT es_trabalho_caint.*, es_inscritos.email, es_inscritos.nome, es_inscritos.cpf
		FROM es_trabalho_caint
		 INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho_caint.fgk_status
		 INNER JOIN es_inscritos ON es_inscritos.id = es_trabalho_caint.fgk_inscrito
		WHERE es_trabalho_caint.fgk_evento = ?
	";
	$filtros[] = intval($id_evento_atual);
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho_caint.nome_aluno 			LIKE ? OR
			es_trabalho_caint.curso_aluno 			LIKE ? OR
			es_trabalho_caint.cidade_destino		LIKE ? OR
			es_trabalho_caint.pais_destino 			LIKE ? OR
			es_trabalho_caint.curso_destino 		LIKE ? OR
			es_trabalho_caint.universidade_destino	LIKE ?
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['cpf'])&&($_REQUEST['cpf']!='')){
			$cpf = $_REQUEST['cpf'];
			$queryString.= " AND es_trabalho_caint.cpf LIKE ?";
			$filtros[] = $cpf;
		}
		if(isset($_REQUEST['nome_aluno'])&&($_REQUEST['nome_aluno']!='')){
			$nome_aluno = $_REQUEST['nome_aluno'];
			$queryString.= " AND es_trabalho_caint.nome_aluno = ?";
			$filtros[] = $nome_aluno;
		}
		if(isset($_REQUEST['curso_aluno'])&&($_REQUEST['curso_aluno']!='')){
			$curso_aluno = $_REQUEST['curso_aluno'];
			$queryString.= " AND es_trabalho_caint.curso_aluno = ?";
			$filtros[] = $curso_aluno;
		}
		if(isset($_REQUEST['universidade_destino'])&&($_REQUEST['universidade_destino']!='')){
			$universidade_destino = $_REQUEST['universidade_destino'];
			$queryString.= " AND es_trabalho_caint.universidade_destino = ?";
			$filtros[] = $universidade_destino;
		}
		if(isset($_REQUEST['tempo_afastamento'])&&($_REQUEST['tempo_afastamento']!='')){
			$tempo_afastamento = $_REQUEST['tempo_afastamento'];
			$queryString.= " AND es_trabalho_caint.tempo_afastamento = ?";
			$filtros[] = $tempo_afastamento;
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho_caint.fgk_status = ?";
			$filtros[] = $fgk_status;
		}

	}
	if($_REQUEST['radio'] == 'true'){
		$queryString.= " AND es_trabalho_caint.id = ?";
		$filtros[] = $_REQUEST['id_trabalho'];
	}
	$query = $db->sql_query($queryString,$filtros);

	$contador = 0;
	$emails = array();
	foreach ($query as $trabalho){
		$contador++;
		$emails[] = $trabalho->email;
		$novo_email = array(
			'fgk_evento'		=> $id_evento_atual,
			'cpf_destinatario'	=> $trabalho->cpf,
			'nome_destinatario'	=> $trabalho->nome,
			'email_destinatario'=> $trabalho->email,
			'categoria'			=> $categoria,
			'assunto'			=> $titulo,
			'corpo_email'		=> $texto_email
		);
		$db->inserir('es_comunicacao_email', $novo_email);
		if( ($contador % 995) == 0){ //estourou o limite recomendado pelo SendGrid de emails, envia o acumulado no array e o limpa depois
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
				'html'      => $texto_email,
				'text'      => $texto_email,
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
			if($response){
				$emails = array();
			}
			else{
				echo json_encode(array(
					"success" =>false,
					"total" => $contador
				));
				exit;
			}
		}
	}
	//finalizado o loop, envia para os emails restantes
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
		'html'      => $texto_email,
		'text'      => $texto_email,
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

	echo json_encode(array(
		"success" =>true,
		"total" => $contador
	));
?>