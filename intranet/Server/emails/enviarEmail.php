<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$id_email	= $_REQUEST['id_email'];
	$email_destinatario	= $_REQUEST['email_destinatario'];
	$texto_email	= $_REQUEST['corpo_email'];
	$titulo	 		= $_REQUEST['assunto'];
	$categoria	 	= $_REQUEST['categoria'];

	$atualizarEmail = array(
		'email_destinatario'=>$email_destinatario,
		'categoria'=>$categoria,
		'assunto'=>$titulo,
		'corpo_email'=>$texto_email,
		'datahora_envio'=> date('Y-m-d H:i:s')
	);
	$db->atualizar('es_comunicacao_email', $atualizarEmail, 'id_email', $id_email);
	$emails = array();
	$emails[] = $email_destinatario;

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
		"resposta" => $response
	));

?>