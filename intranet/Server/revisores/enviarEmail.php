<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];

	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$texto_email 	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];
	
	$filtros = array();
	$queryString = "
		SELECT
		 SUM(CASE WHEN (es_avaliacao.fgk_revisor1 = es_avaliacao_revisor.id OR es_avaliacao.fgk_revisor2 = es_avaliacao_revisor.id) THEN 1 ELSE 0 END) qtd_trabalhos,
		 SUM(CASE WHEN (es_avaliacao_revisao.status < 2 OR es_avaliacao_revisao.status IS NULL ) THEN 1 ELSE 0 END) pendentes,
		es_avaliacao_revisor.*, es_inscritos.nome, es_inscritos.cpf, es_inscritos.email, es_inscritos_tipos.descricao_tipo, es_area_especifica.descricao_area_especifica, es_ufop_areas.codigo_area

		FROM es_avaliacao_revisor
		 LEFT JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
		  LEFT JOIN es_inscritos_tipos ON  es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
		 LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_avaliacao_revisor.fgk_area
		 LEFT JOIN es_area_especifica ON es_area_especifica.id = es_avaliacao_revisor.fgk_area_especifica

		 LEFT JOIN es_avaliacao ON (es_avaliacao.fgk_revisor1 = es_avaliacao_revisor.id) OR (es_avaliacao.fgk_revisor2 = es_avaliacao_revisor.id)
		 LEFT JOIN es_avaliacao_revisao ON (es_avaliacao_revisao.fgk_avaliacao = es_avaliacao.id) AND (es_avaliacao_revisao.fgk_revisor = es_avaliacao_revisor.id)
		 LEFT JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho

		WHERE es_inscritos.fgk_evento = ?
	";
	$filtros['es_inscritos.fgk_evento'] = $id_evento_atual;
	if(isset($_REQUEST['pa'])&&($_REQUEST['pa']=='1')){
		if($_REQUEST['com_trabalho']=='1'){
			$queryString.= " AND es_trabalho.id > 0 ";
		}
		if(isset($_REQUEST['nome'])&&($_REQUEST['nome']!='')){
			$nome = $_REQUEST['nome'];
			$queryString.= " AND es_inscritos.nome LIKE ?";
			$filtros['es_inscritos.nome'] = '%'.$nome.'%';
		}
		if(isset($_REQUEST['fgk_tipo'])&&($_REQUEST['fgk_tipo']!='')){
			$fgk_tipo = $_REQUEST['fgk_tipo'];
			$queryString.= " AND es_inscritos.fgk_tipo = ?";
			$filtros['es_inscritos.fgk_tipo'] = $fgk_tipo;
		}
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_avaliacao_revisor.fgk_area = ?";
			$filtros['es_avaliacao_revisor.fgk_area'] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
			$queryString.= " AND es_avaliacao_revisor.fgk_area_especifica = ?";
			$filtros['es_avaliacao_revisor.fgk_area_especifica'] = $fgk_area_especifica;

		}
		if($_REQUEST['bool_avaliador_prograd']!='-1'){
			$bool_avaliador_prograd = $_REQUEST['bool_avaliador_prograd'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_prograd = ?";
			$filtros['es_avaliacao_revisor.bool_avaliador_prograd'] = $bool_avaliador_prograd;
		}
		if($_REQUEST['bool_avaliador_proex']!='-1'){
			$bool_avaliador_proex = $_REQUEST['bool_avaliador_proex'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_proex = ?";
			$filtros['es_avaliacao_revisor.bool_avaliador_proex'] = $bool_avaliador_proex;
		}
		if($_REQUEST['bool_avaliador_caint']!='-1'){
			$bool_avaliador_caint = $_REQUEST['bool_avaliador_caint'];
			$queryString.= " AND es_avaliacao_revisor.bool_avaliador_caint = ?";
			$filtros['es_avaliacao_revisor.bool_avaliador_caint'] = $bool_avaliador_caint;
		}
	}

	if($_REQUEST['radio'] == 'true'){
		$queryString.= " AND es_avaliacao_revisor.id = ?";
		$filtros['es_avaliacao_revisor.id'] = $_REQUEST['id_revisor'];
	}

	$buscaRapida = $_REQUEST['buscaRapida'];
	$queryString.= " AND (
		es_inscritos.nome LIKE ? OR
		es_ufop_areas.codigo_area LIKE ? OR
		es_area_especifica.descricao_area_especifica LIKE ? OR
		es_inscritos.cpf LIKE ?
	)";
	$filtros['es_inscritos.nome'] = '%'.$buscaRapida.'%';
	$filtros['es_ufop_areas.codigo_area'] = '%'.$buscaRapida.'%';
	$filtros['es_area_especifica.descricao_area_especifica'] = '%'.$buscaRapida.'%';
	$filtros['es_inscritos.cpf'] = '%'.$buscaRapida.'%';
	$queryString.=" GROUP BY es_avaliacao_revisor.id HAVING 1 ";
	if(isset($_REQUEST['pa'])&&($_REQUEST['pa']=='1')){
		if($_REQUEST['com_trabalho']=='1'){
			$queryString.= " AND qtd_trabalhos > 0 ";
			if($_REQUEST['pendentes']=='1')
				$queryString.= " AND pendentes > 0 ";
			else if($_REQUEST['pendentes']=='2')
				$queryString.= " AND pendentes = 0 ";
		}
		else if($_REQUEST['com_trabalho']=='0'){
			$queryString.= " AND qtd_trabalhos = 0 ";
		}
	}
	$query = $db->sql_query($queryString,$filtros);
	
	$contador = 0;
	$emails = array();
	foreach ($query as $revisor){
		$contador++;
		$emails[] = $revisor->email;
		$novo_email = array(
			'fgk_evento'		=> $id_evento_atual,
			'cpf_destinatario'	=> $revisor->cpf,
			'nome_destinatario'	=> $revisor->nome,
			'email_destinatario'=> $revisor->email,
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