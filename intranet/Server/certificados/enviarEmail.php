<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();
	date_default_timezone_set('America/Sao_Paulo');
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';
	
	$id_certificado = $_REQUEST['id_certificado'];
	$certificado = $db->listar('es_certificados', 'id_certificado', $id_certificado);
	
	$texto_email="
		Prezado(a),<br>Agradecemos a sua participação no Encontro de Saberes.<br>Segue o link para baixar o seu certificado:<br><br>http://www.encontrodesaberes.com.br/gerar_certificado.php?c=".$certificado->chave_autenticidade."&f=1<br><br>Atenciosamente,<br>Encontro de Saberes";

	$novo_email = array(
		'fgk_evento'		=> $id_evento_atual,
		'cpf_destinatario'	=> $certificado->cpf,
		'nome_destinatario'	=> $certificado->nome,
		'email_destinatario'=> $certificado->email,
		'categoria'			=> "Certificado - Encontro de Saberes",
		'assunto'			=> "Certificado - Encontro de Saberes",
		'corpo_email'		=> $texto_email
	);
	$db->inserir('es_comunicacao_email', $novo_email);

	$emails = array();
	$emails[] = $certificado->email;
	$json_string = array(
	  'to' => $emails,
	  'category' => "Certificado"
	);
	$params = array(
		'api_user'  => $user,
		'api_key'   => $pass,
		'x-smtpapi' => json_encode($json_string),
		'to'        => $emails,
		'subject'   => 'Certificado - Encontro de Saberes',
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
		"success" => true
	));
?>