<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
	include ("../../config.php");
	$i=1;
	$sql = $db->sql_query("SELECT * FROM es_avaliacao INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0 LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica WHERE fgk_status >= 6 AND fgk_evento = 8 ");
	foreach ($sql as $registro){
		$titulo = $registro->titulo_enviado;
		$fgk_trabalho = $registro->id;
		$fgk_status = $registro->fgk_status;
		if($registro->parecer)
			$parecer = '<p>Parecer Geral:</p><p>'.$registro->parecer.'</p>';
		else 
			$parecer = "";
		$descricao_area_especifica = $registro->descricao_area_especifica;
	
	
	$sel_autores = $db->sql_query("SELECT nome, email, cpf FROM es_trabalho_autor WHERE fgk_trabalho =?", array('fgk_trabalho'=>$fgk_trabalho));

	foreach ($sel_autores as $autores) {
		if($fgk_status == 6){
          $corpo_mensagem = '<p>Prezado autor,<br />
									
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                  
                                  <p>Foi ACEITO para apresentação no Encontro de Saberes . Foi(ram) dado(s) o(s) seguinte(s) parecer(es):</p>
                                  '. $parecer .'
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>';

        } else if($fgk_status == 7){
           $corpo_mensagem = '<p>Prezado autor,<br />
									
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                           <p>Foi ACEITO COM RESTRIÇÕES para apresentação no Encontro de Saberes . Isto significa que o trabalho será aceito se atendidas as modificações indicadas na(s) avaliação(ões) descrita(s) a seguir:</p>
                                  '. $parecer .'
                                  <p>Informamos que a edição final do resumo deve ser concluída no site www.encontrodesaberes.ufop.br entre os dias 28 de outubro a 1 de novembro de 2016, usando-se o login (CPF) e senha do usuário que submeteu o trabalho.</p>
                                  <p>Atenção, é possível inserir os agradecimentos aos apoiadores financeiros no final do resumo, integrando-o ao texto. Caso ainda não tenha feito, sugerimos que o faça para que conste nos Anais do Encontro de Saberes.</p>
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>';

        } else if($fgk_status == 8){
          $corpo_mensagem = '<p>Prezado autor,<br />
									
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                  
                                  <p>NÃO FOI ACEITO para apresentação no Encontro de Saberes . Foi dado o seguinte parecer:</p>
                                  '. $parecer .'
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>'; 
        } 
		
		$url = 'https://api.sendgrid.com/';
		$user = 'encontrosaberes';
		$pass = 'se2015ic';

		$json_string = array(
		  'category' => 'Errata E-mail'
		);


		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			'x-smtpapi' => json_encode($json_string),
			'to'        => $autores->email,
			'subject'   => '[ERRATA] Encontro de Saberes - Parecer do trabalho',
			'html'      => $corpo_mensagem,
			'text'      => $corpo_mensagem,
			'from'      => 'encontrodesaberes@ufop.br'
		  );


		$request =  $url.'api/mail.send.json';

		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		// Tell PHP not to use SSLv3 (instead opting for TLS)
		curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);
		curl_close($session);
		
		echo $i++.'<br>';
           
	}
	}
	


