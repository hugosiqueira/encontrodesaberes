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
			es_ufop_alunos.nome LIKE '%$buscaRapida%' OR
			es_ufop_alunos.cpf LIKE '%$buscaRapida%' OR
			es_ufop_alunos.matricula LIKE '%$buscaRapida%' OR
			es_ufop_cursos.descricao_curso LIKE '%$buscaRapida%' OR
			es_ufop_alunos.email LIKE '%$buscaRapida%'
		)";
	}

	//formulário
	$aluno = "";
	if($_REQUEST['aluno'] == 'true'){
		$id = $_REQUEST['id_aluno'];
		$aluno = " AND es_ufop_alunos.id_aluno = $id";
	}
	if(isset($_REQUEST['pa'])){
		$fgk_curso 		= $_REQUEST['fgk_curso'];
		$bool_monitoria 		= $_REQUEST['bool_monitoria'];
		$mobilidade_ano_passado = $_REQUEST['mobilidade_ano_passado'];
		$mobilidade_ano_atual = $_REQUEST['mobilidade_ano_atual'];
		$busca_avancada = sprintf("AND %s AND %s AND %s AND %s ",
			($fgk_curso!="")	? "( es_ufop_alunos.fgk_curso = '$fgk_curso' )" 	: "1",
			($bool_monitoria!="-1")	? "( es_ufop_alunos.bool_monitoria = $bool_monitoria )" 	: "1",
			($mobilidade_ano_passado!="-1")? "( es_ufop_alunos.mobilidade_ano_passado = $mobilidade_ano_passado )" 	: "1",
			($mobilidade_ano_atual!="-1")? "( es_ufop_alunos.mobilidade_ano_atual = $mobilidade_ano_atual )" 	: "1"
		);
	}
	else{
		$busca_avancada = "";
	}
	$texto_email	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$queryString = "
		SELECT es_ufop_alunos.*, es_ufop_cursos.descricao_curso
		FROM es_ufop_alunos
		 INNER JOIN es_ufop_cursos ON es_ufop_cursos.codigo = es_ufop_alunos.fgk_curso
		WHERE $filtro
		$aluno $busca_avancada
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