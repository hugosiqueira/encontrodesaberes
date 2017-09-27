<?php

	header('Content-Type: application/json; charset=utf-8');

	require_once '../../includes/functions.php';

	require_once('../../includes/db_connect.php');

	sec_session_start();



	$id_evento_atual = $_SESSION['id_evento_atual'];

	$envia_email = $_POST['envia_email'];

	$json = $_POST['certificado'];

	$dados = json_decode($json);



	$atualizar_certificado = array(

		'fgk_tipo'				=> $dados->fgk_tipo,

		'dizeres_certificado'	=> $dados->dizeres_certificado,

		'fgk_evento'			=> $id_evento_atual,

		'cpf'					=> $dados->cpf,

		'email'					=> $dados->email,

		'nome'					=> $dados->nome

	);

	$db->atualizar('es_certificados', $atualizar_certificado, 'id_certificado', $dados->id_certificado);

	if($envia_email=='1'){

		$certificado = $db->listar('es_certificados', 'id_certificado', $dados->id_certificado);



		$texto_email="

			Prezado(a),<br>Agradecemos a sua participação no Encontro de Saberes.<br>Segue o link para baixar o seu certificado:<br><br>http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c=".$certificado->chave_autenticidade."&f=1<br><br>Atenciosamente,<br>Encontro de Saberes.";

		$url = 'https://api.sendgrid.com/';
            $user = 'encontrosaberes';
            $pass = 'se2015ic';

		$novo_email = array(

			'fgk_evento'		=> $id_evento_atual,

			'cpf_destinatario'	=> $dados->cpf,

			'nome_destinatario'	=> $dados->nome,

			'email_destinatario'=> $dados->email,

			'categoria'			=> "Certificado - Encontro de Saberes",

			'assunto'			=> "Certificado - Encontro de Saberes",

			'corpo_email'		=> $texto_email

		);

		$db->inserir('es_comunicacao_email', $novo_email);



		$emails = array();

		$emails[] = $dados->email;

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

		@curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

		curl_setopt($session, CURLOPT_HEADER, false);

		curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($session);

		curl_close($session);

	}

	echo json_encode(array(

		"success" => true,

		"msg" => "Certificado atualizado com sucesso."

	));

?>