<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$id_apresentacao = $_REQUEST['id_apresentacao'];
	$titulo_enviado = $_REQUEST['titulo_enviado'];
	$apresentacao = $db->listar('es_trabalho_apresentacao', 'id', $id_apresentacao);
	$filtros = array();
	$qryautores = "
		SELECT es_trabalho_autor.*
		FROM es_trabalho_autor
		WHERE es_trabalho_autor.fgk_trabalho = ?
	";
	$filtros[] = $apresentacao->fgk_trabalho;
	$qryautores = $db->sql_query2($qryautores, $filtros);
	$emails = array();
	$texto_email = "Prezado autor,<br><br>Gostaríamos de notificar que a apresentação do trabalho: ".$titulo_enviado." não foi realizada no Encontro de Saberes.<br><br>Atenciosamente,<br>Encontro de Saberes";
	foreach ($qryautores as $autores) {
		$emails[] = $autores->email;
		$novo_email = array(
			'fgk_evento'		=> $id_evento_atual,
			'cpf_destinatario'	=> $autores->cpf,
			'nome_destinatario'	=> $autores->nome,
			'email_destinatario'=> $autores->email,
			'categoria'			=> "Apresentador ausente",
			'assunto'			=> "Apresentação não realizada - Encontro de Saberes",
			'corpo_email'		=> $texto_email
		);
		$db->inserir('es_comunicacao_email', $novo_email);
	}
	$json_string = array(
	  'to' => $emails,
	  'category' => "Apresentador ausente"
	);
	$params = array(
		'api_user'  => $user,
		'api_key'   => $pass,
		'x-smtpapi' => json_encode($json_string),
		'to'        => $emails,
		'subject'   => 'Apresentação não realizada - Encontro de Saberes',
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

	$db->atualizar('es_trabalho_apresentacao', array('status' => 2), 'id', $id_apresentacao);
	$db->atualizar('es_trabalho', array('fgk_status' =>17), 'id', $apresentacao->fgk_trabalho);

	echo json_encode(array(
		"success" => true
	));
?>