<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$url = 'https://api.sendgrid.com/';
	$user = 'encontrosaberes';
	$pass = 'se2015ic';
	
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
	if($_REQUEST['trabalho'] == 'selecionado'){
		$id = $_REQUEST['id_trabalho'];
		$trabalho = " AND es_trabalho.id = $id";
	}
	else{
		$trabalho = "";
	}

	if(isset($_REQUEST['destinatario_autor']))
		$autor = " fgk_tipo_autor = 1 ";
	else
		$autor = " 0 ";
	if(isset($_REQUEST['destinatario_orientador']))
		$orientador = " fgk_tipo_autor = 2 ";
	else
		$orientador = " 0 ";
	if(isset($_REQUEST['destinataro_coautor']))
		$coautor = " fgk_tipo_autor = 3 ";
	else
		$coautor = " 0 ";
	if(isset($_REQUEST['colaborador']))
		$colaborador = " fgk_tipo_autor = 4 ";
	else
		$colaborador = " 0 ";
	$texto_email	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$queryString = "
		SELECT es_trabalho.*
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
		WHERE $filtro
		 AND es_trabalho.fgk_evento = $id_evento_atual
		 $busca_avancada
		 $trabalho
		ORDER BY datahora_registro DESC
	";
	echo $queryString;
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));
	$emails = array();
	// $autores = array();
	$contador=0;
	while($registro = mysqli_fetch_assoc($query)) { //todos os trabalhos listados ou selecionado
		$id_trabalho = $registro['id'];
		$queryAutores ="
			SELECT es_trabalho_autor.nome, es_trabalho_autor.cpf, es_trabalho_autor.email, es_trabalho_autor.fgk_tipo_autor
			FROM es_trabalho_autor
			WHERE es_trabalho_autor.fgk_trabalho = $id_trabalho
			 AND ($autor OR $orientador OR $coautor OR $colaborador )
			 AND $pa_autores
			 AND es_trabalho_autor.email IS NOT NULL
			 AND es_trabalho_autor.email <> ''
			ORDER BY es_trabalho_autor.ordenacao
		";
		echo $queryAutores;
		$queryAutores = mysqli_query($mysqli,$queryAutores) or die(mysqli_error($mysqli));
		while($reg = mysqli_fetch_assoc($queryAutores)) {
			$contador++;
			$emails[] = $reg['email'];
			// $insereEmail = sprintf("
				// INSERT INTO es_comunicacao_email
				// (	cpf_destinatario, email_destinatario, categoria, assunto, corpo_email)
				// values
				// (	'%s', '%s', '%s', '%s', '%s')",
					// mysqli_real_escape_string($mysqli,$reg['cpf']),
					// mysqli_real_escape_string($mysqli,$reg['email']),
					// mysqli_real_escape_string($mysqli,$categoria),
					// mysqli_real_escape_string($mysqli,$titulo),
					// mysqli_real_escape_string($mysqli,$texto_email)
			// );
			// mysqli_query($mysqli,$insereEmail);
			if( ($contador % 995) == 0){
				echo "estourou o limite, envia tudo até agora: ".$contador;
			}
		}
	}

	
	// $json_string = array(
	  // 'to' => $emails,
	  // 'category' => $categoria
	// );
	// $params = array(
		// 'api_user'  => $user,
		// 'api_key'   => $pass,
		// 'x-smtpapi' => json_encode($json_string),
		// 'to'        => $emails,
		// 'subject'   => $titulo,
		// 'html'      => $texto_email,
		// 'text'      => $texto_email,
		// 'from'      => 'encontrodesaberes@ufop.br',
	// );
	// $request =  $url.'api/mail.send.json';
	// // Generate curl request
	// $session = curl_init($request);
	// // Tell curl to use HTTP POST
	// curl_setopt ($session, CURLOPT_POST, true);
	// // Tell curl that this is the body of the POST
	// curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
	// // Tell curl not to return headers, but do return the response
	// curl_setopt($session, CURLOPT_HEADER, false);
	// // Tell PHP not to use SSLv3 (instead opting for TLS)
	// curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
	// curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	// $response = curl_exec($session);
	// curl_close($session);
	//"result" =>$response,
	
	echo json_encode(array(
		"success" =>true,

		"emails" => $emails,
		"total" => $contador
	));

?>