<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("../../includes/db_connect.php");
	require_once '../../includes/functions.php';
	sec_session_start();
	$id_evento_atual = $_SESSION['id_evento_atual'];
	$url = 'https://api.sendgrid.com/';
	$user = 'eventsystem';
	$pass = 'event2016system';

	$filtros = array();
	$queryString = "
		SELECT es_trabalho.*, es_trabalho_autor.nome, es_trabalho_autor.cpf, es_trabalho_autor.email, es_trabalho_autor.fgk_tipo_autor
		FROM es_trabalho
			INNER JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
			LEFT JOIN es_area_especifica ON es_area_especifica.id = es_trabalho.fgk_area_especifica
			INNER JOIN es_evento ON es_evento.id = es_trabalho.fgk_evento
			LEFT JOIN es_inscritos ON es_inscritos.id = es_trabalho.fgk_inscrito_responsavel
			LEFT JOIN es_instituicao ON es_instituicao.id = es_trabalho.fgk_instituicao
			INNER JOIN es_tipo_apresentacao ON es_tipo_apresentacao.id_tipo_apresentacao = es_trabalho.fgk_tipo_apresentacao
			INNER JOIN es_trabalho_status ON es_trabalho_status.id_status = es_trabalho.fgk_status
			INNER JOIN es_categorias ON es_categorias.id_categoria = es_trabalho.fgk_categoria
			LEFT JOIN es_projeto ON es_projeto.id = es_trabalho.fgk_projeto
			LEFT JOIN es_orgao_fomento ON es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento
			LEFT JOIN es_trabalho_justificativa ON es_trabalho_justificativa.fgk_trabalho = es_trabalho.id
			LEFT JOIN es_trabalho_autor ON es_trabalho_autor.fgk_trabalho = es_trabalho.id
		WHERE es_trabalho.fgk_evento = ?
			AND es_trabalho_autor.email IS NOT NULL
			AND es_trabalho_autor.email <> ''
	";
	$filtros[] = intval($id_evento_atual);

	if(isset($_REQUEST['buscaRapida'])){
		$buscaRapida = $_REQUEST['buscaRapida'];
		$queryString.= " AND (
			es_trabalho.palavras_chave 	LIKE ? OR
			es_trabalho.resumo_revisado LIKE ? OR
			es_trabalho.resumo_enviado 	LIKE ? OR
			es_trabalho.titulo_revisado LIKE ? OR
			es_trabalho.titulo_enviado 	LIKE ? OR
			es_trabalho.id IN (
				SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
			)
		)";
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
		$filtros[] = '%'.$buscaRapida.'%';
	}
	//filtros da pesquisa avancada
	if(isset($_REQUEST['pa'])){
		if(isset($_REQUEST['nome_autores'])&&($_REQUEST['nome_autores']!='')){
			$queryString.= "
				AND es_trabalho.id IN (
					SELECT fgk_trabalho FROM es_trabalho_autor WHERE nome LIKE ?
				)
			";
			$filtros[] = '%'.$_REQUEST['nome_autores'].'%';
		}
		if(isset($_REQUEST['apresentacao_obrigatoria'])&&($_REQUEST['apresentacao_obrigatoria']!='')){
			$queryString.= "  AND es_trabalho.apresentacao_obrigatoria = ?";
			$filtros[] = $_REQUEST['apresentacao_obrigatoria'];
		}
		if(isset($_REQUEST['fgk_status'])&&($_REQUEST['fgk_status']!='')){
			$fgk_status = $_REQUEST['fgk_status'];
			$queryString.= " AND es_trabalho.fgk_status = ? ";
			$filtros[] = $fgk_status;
		}
		if(isset($_REQUEST['fgk_orgao_fomento'])&&($_REQUEST['fgk_orgao_fomento']!='')){
			$fgk_orgao_fomento = $_REQUEST['fgk_orgao_fomento'];
			$queryString.= " AND es_trabalho.fgk_orgao_fomento = ?";
			$filtros[] = $fgk_orgao_fomento;
		}
		if(isset($_REQUEST['fgk_categoria'])&&($_REQUEST['fgk_categoria']!='')){
			$fgk_categoria = $_REQUEST['fgk_categoria'];
			$queryString.= " AND es_trabalho.fgk_categoria = ?";
			$filtros[] = $fgk_categoria;
		}
		if(isset($_REQUEST['fgk_area'])&&($_REQUEST['fgk_area']!='')){
			$fgk_area = $_REQUEST['fgk_area'];
			$queryString.= " AND es_trabalho.fgk_area = ?";
			$filtros[] = $fgk_area;
		}
		if(isset($_REQUEST['fgk_area_especifica'])&&($_REQUEST['fgk_area_especifica']!='')){
			$fgk_area_especifica = $_REQUEST['fgk_area_especifica'];
			$queryString.= " AND es_trabalho.fgk_area_especifica = ?";
			$filtros[] = $fgk_area_especifica;
		}
		if(isset($_REQUEST['fgk_tipo_apresentacao'])&&($_REQUEST['fgk_tipo_apresentacao']!='')){
			$fgk_tipo_apresentacao = $_REQUEST['fgk_tipo_apresentacao'];
			$queryString.= " AND es_trabalho.fgk_tipo_apresentacao = ?";
			$filtros[] = $fgk_tipo_apresentacao;
		}
		if(isset($_REQUEST['avaliacao'])&&($_REQUEST['avaliacao']!='-1')){
			$avaliacao = $_REQUEST['avaliacao'];
			if($avaliacao=='0'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status = 0
					)
				";
			}
			else if($avaliacao=='1'){
				$queryString.= "
					AND es_trabalho.id IN (
						SELECT fgk_trabalho FROM es_avaliacao WHERE status > 0
					)
				";
			}
		}
	}
	//formulário
	if(isset($_REQUEST['radio'])&&$_REQUEST['radio'] == 'selecionado'){
		$id = $_REQUEST['id_trabalho'];
		$queryString .= " AND es_trabalho.id = ? ";
		$filtros[] = $id;
	}
	$tipo_autores = array(0);
	if(isset($_REQUEST['destinatario_autor'])&&($_REQUEST['destinatario_autor']))
		$tipo_autores[] = 1;
	if(isset($_REQUEST['destinatario_orientador'])&&($_REQUEST['destinatario_orientador']))
		$tipo_autores[] = 2;
	if(isset($_REQUEST['destinataro_coautor'])&&($_REQUEST['destinataro_coautor']))
		$tipo_autores[] = 3;
	if(isset($_REQUEST['colaborador'])&&($_REQUEST['colaborador']))
		$tipo_autores[] = 4;
	$tipo_autores = implode(",",$tipo_autores);

	$texto_email	= $_REQUEST['email'];
	$titulo	 		= $_REQUEST['titulo'];
	$categoria	 	= $_REQUEST['categoria'];

	$queryString.= " AND ( es_trabalho_autor.fgk_tipo_autor IN ($tipo_autores) ) GROUP BY es_trabalho_autor.cpf ";
	$query = $db->sql_query2($queryString,$filtros);

	$emails = array();
	$contador=0;
	foreach($query as $res){
		$contador++;
		$emails[] = $res->email;
		$add = array(
			'fgk_evento'		=> $id_evento_atual,
			'cpf_destinatario'	=> $res->cpf,
			'nome_destinatario'	=> $res->nome,
			'email_destinatario'=> $res->email,
			'categoria'			=> $categoria,
			'assunto'			=> $titulo,
			'corpo_email'		=> $texto_email,
			'datahora_envio'	=> date('Y-m-d H:i:s')
		);
		$db->inserir('es_comunicacao_email', $add);
		
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