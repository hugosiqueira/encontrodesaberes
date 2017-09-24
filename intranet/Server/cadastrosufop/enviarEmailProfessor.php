<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	//busca rapida
	$buscaRapida	= $_REQUEST['buscaRapida'];
	$filtro = " 1";
	if(isset($_REQUEST['buscaRapida']) && $_REQUEST['buscaRapida']!=''){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$filtro = "(
			es_ufop_professores.nome LIKE '%$buscaRapida%' OR
			es_ufop_professores.fgk_departamento LIKE '%$buscaRapida%' OR
			es_ufop_professores.cod_siape LIKE '%$buscaRapida%' OR
			es_ufop_professores.email LIKE '%$buscaRapida%' OR
			es_ufop_professores.cpf LIKE '%$buscaRapida%'
		)";
	}
	
	//formulário
	if($_REQUEST['professor'] == 'filtrado'){
		$professor = "";
	}
	else{
		$id = $_REQUEST['id_professor'];
		$professor = " AND es_ufop_professores.id_professor = $id";
	}	
	$texto_email	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$queryString = "
		SELECT es_ufop_professores.*
		FROM es_ufop_professores
		 INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_professores.fgk_departamento
		WHERE $filtro		
		 AND es_ufop_professores.email IS NOT NULL
		 AND es_ufop_professores.email <> ''
		 $professor
		ORDER BY nome ASC
	";
	// echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$emails = array();
	$contador=0;
	while($registro = mysqli_fetch_assoc($query)) { 
		$contador++;
		$emails[] = $registro['email'];
		$insereEmail = sprintf("
			INSERT INTO es_comunicacao_email
			(	fgk_evento, cpf_destinatario, nome_destinatario, email_destinatario, categoria, assunto, corpo_email)
			values
			(	%d, '%s', '%s', '%s', '%s', '%s', '%s')",
				mysqli_real_escape_string($mysqli,$id_evento_atual),
				mysqli_real_escape_string($mysqli,$registro['cpf']),
				mysqli_real_escape_string($mysqli,$registro['nome']),
				mysqli_real_escape_string($mysqli,$registro['email']),
				mysqli_real_escape_string($mysqli,$categoria),
				mysqli_real_escape_string($mysqli,$titulo),
				mysqli_real_escape_string($mysqli,$texto_email)
		);
		mysqli_query($mysqli,$insereEmail);
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