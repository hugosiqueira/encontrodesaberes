<?php

	header('Content-Type: text/html; charset=utf-8');

	require_once("../../includes/db_connect.php");

	require_once '../../includes/functions.php';

	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];



	function preparaEmail($texto_email, $nome_avaliador, $listaTrabalhos ){

		$partestexto = explode('*nomerevisor*', $texto_email);

		$texto_email = $partestexto[0].$nome_avaliador.$partestexto[1];

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

		SELECT es_trabalho.*, es_ufop_areas.id_area, es_ufop_areas.descricao_area, es_ufop_areas.codigo_area, es_orgao_fomento.sigla AS sigla_orgao, es_orgao_fomento.nome AS nome_orgao, es_trabalho_apresentacao.cod_poster, es_trabalho_apresentacao.id AS id_apresentacao, es_inscritos.nome AS avaliador,es_inscritos.email,es_inscritos.cpf, es_sessao.nome AS nome_sessao, es_area_especifica.descricao_area_especifica, es_trabalho_apresentacao.fgk_revisor

		FROM es_trabalho

			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area

			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica

			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento



			LEFT JOIN es_trabalho_apresentacao ON es_trabalho_apresentacao.fgk_trabalho = es_trabalho.id

			LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao

			LEFT JOIN es_avaliacao_revisor ON es_avaliacao_revisor.id = es_trabalho_apresentacao.fgk_revisor

			LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito

		WHERE es_trabalho.fgk_evento = ? AND es_trabalho.fgk_tipo_apresentacao = 1 AND (es_trabalho.fgk_status = 6 OR es_trabalho.fgk_status = 14) AND es_trabalho_apresentacao.id IS NOT NULL

	";

	$filtros[] = intval($id_evento_atual);



	if(isset($_REQUEST['buscaRapida'])){

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

	$queryString.= " GROUP BY es_trabalho_apresentacao.fgk_revisor";

	$query = $db->sql_query($queryString,$filtros);



	$contador = 0;



	foreach ($query as $trabalhoPosters){

		$id_revisor = $trabalhoPosters->fgk_revisor;

		$nome_avaliador = $trabalhoPosters->avaliador;

		$email_avaliador = $trabalhoPosters->email;

		$emails = array();

		$emails[] = $email_avaliador;

		$filtros2 = array();

		$queryString = "

			SELECT es_trabalho.id, es_trabalho.titulo_enviado, es_sessao.nome, DATE_FORMAT(es_sessao.dia, '%d/%m/%Y') as dia_correto , es_sessao.hora_ini, es_sessao.hora_fim

			FROM es_trabalho_apresentacao

				INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho

			 INNER JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao

			WHERE es_trabalho_apresentacao.fgk_revisor = ? AND es_trabalho.fgk_evento = ?

			ORDER BY es_sessao.dia ASC

		";

		$filtros2[] = $id_revisor;

		$filtros2[] = $id_evento_atual;

		$query = $db->sql_query2($queryString,$filtros2);

		$listaTrabalhos = "";

		foreach ($query as $titulos){

			$listaTrabalhos .= "

				SESSÃO: ".$titulos->nome."</br>

				Dia: ".$titulos->dia_correto."</br>

				Horário: ".$titulos->hora_ini." - ".$titulos->hora_fim."</br>

				<a href='http://www.encontrodesaberes.ufop.br/detalhes.php?id=".$titulos->id."'>".$titulos->titulo_enviado."</a></br></br>

			";

		}

		$texto_final = preparaEmail($texto_email, $nome_avaliador, $listaTrabalhos );

		// echo $texto_final;



		$novo_email = array(

			'fgk_evento'		=> $id_evento_atual,

			'cpf_destinatario'	=> $trabalhoPosters->cpf,

			'nome_destinatario'	=> $nome_avaliador,

			'email_destinatario'=> $email_avaliador,

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