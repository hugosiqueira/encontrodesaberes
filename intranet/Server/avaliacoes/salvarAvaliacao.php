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



	$id = $_REQUEST['id'];

	$fgk_revisor = $_REQUEST['fgk_revisor'];

	$status = $_REQUEST['status'];



	$nota_a = $_REQUEST['nota_a'];

	$nota_b = $_REQUEST['nota_b'];

	$nota_c = $_REQUEST['nota_c'];

	$nota_d = $_REQUEST['nota_d'];

	$nota_e = $_REQUEST['nota_e'];

	

	$db->iniciar_transacao();

	

	if(is_numeric($fgk_revisor)){	//se trocaram o revisor

		$notas = array(

			'fgk_revisor'		=> $fgk_revisor,

			'nota_a'			=> $nota_a,

			'nota_b'			=> $nota_b,

			'nota_c'			=> $nota_c,

			'nota_d'			=> $nota_d,

			'nota_e'			=> $nota_e,

			'status'			=> 1

		);

		$db->atualizar('es_trabalho_apresentacao', $notas, 'id', $id);

	}

	else{

		$notas = array(

			'nota_a'			=> $nota_a,

			'nota_b'			=> $nota_b,

			'nota_c'			=> $nota_c,

			'nota_d'			=> $nota_d,

			'nota_e'			=> $nota_e,

			'status'			=> 1

		);

		$db->atualizar('es_trabalho_apresentacao', $notas, 'id', $id);

	}



	$apresentacao = $db->listar('es_trabalho_apresentacao', 'id', $id);	

	$db->atualizar('es_trabalho', array('fgk_status' =>16), 'id', $apresentacao->fgk_trabalho);

	

	if($_REQUEST['certificadoemail'] == '1'){

		//pegar apresentador

		

		$filtros = array();

		$qryAutores = "

			SELECT es_trabalho_autor.*, es_trabalho.titulo_enviado, es_tipo_autor.sigla, es_trabalho.fgk_categoria,

			(SELECT GROUP_CONCAT(nome SEPARATOR ', ') FROM es_trabalho_autor WHERE fgk_trabalho = ?) AS nome_autores

			FROM es_trabalho_autor

			 INNER JOIN es_trabalho ON es_trabalho.id = es_trabalho_autor.fgk_trabalho

			 INNER JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor

			WHERE es_trabalho_autor.fgk_trabalho = ? AND es_trabalho_autor.bool_apresentador = 1

			ORDER BY es_trabalho_autor.bool_apresentador DESC, es_trabalho_autor.ordenacao ASC, es_trabalho_autor.nome ASC

		";

		$filtros[] = $apresentacao->fgk_trabalho;

		$filtros[] = $apresentacao->fgk_trabalho;



		$qryAutores = $db->sql_query2($qryAutores, $filtros);

		foreach ($qryAutores as $autores) {

			// PARA CADA APRESENTADOR

			$titulo_enviado = $autores->titulo_enviado;

			$fgk_categoria 	= $autores->fgk_categoria;

			$id_apresentador 	= $autores->id;

			$cpf_apresentador 	= $autores->cpf;

			$email_apresentador = $autores->email;

			$nome_apresentador 	= $autores->nome;

			$nome_autores 		= $autores->nome_autores;



			if($fgk_categoria == 1){

				$tipo_certificado = 28;

			}

			else if($fgk_categoria == 2){

				$tipo_certificado = 30;

			}

			else if($fgk_categoria == 3){

				$tipo_certificado = 31;

			}

			else if($fgk_categoria == 4){

				$tipo_certificado = 32;

			}

			else if($fgk_categoria == 5){

				$tipo_certificado = 32;

			}

			else if($fgk_categoria == 6){

				$tipo_certificado = 33;

			}

			else if($fgk_categoria == 7){

				$tipo_certificado = 34;

			}

			$certificadoTipo = $db->listar('es_certificados_tipos', 'id_tipo_certificado', $tipo_certificado);

			$partestexto = explode('NOME DO ALUNO', $certificadoTipo->modelo_padrao);

			$texto_certificado = $partestexto[0].$nome_apresentador.$partestexto[1];

			$partestexto = explode('NOME DO TRABALHO', $texto_certificado);

			$texto_certificado = $partestexto[0].$titulo_enviado.$partestexto[1];

			$partestexto = explode('NOME DOS AUTORES', $texto_certificado);

			$texto_certificado = $partestexto[0].$nome_autores.$partestexto[1];



			//cadastra novo certificado e envia email

			$novo_certificado = array(

				'fgk_tipo'				=> $tipo_certificado,

				'dizeres_certificado'	=> $texto_certificado,

				'data_emissao'			=> date('Y-m-d H:i:s'),

				'fgk_evento'			=> $id_evento_atual,

				'cpf'					=> $cpf_apresentador,

				'nome'					=> $nome_apresentador,

				'email'					=> $email_apresentador,

				'chave_autenticidade'	=> uniqid(time())

			);

			$db->inserir('es_certificados', $novo_certificado);

			$id_certificado = $db->lastInsertId();

			$certificado = $db->listar('es_certificados', 'id_certificado', $id_certificado);

			$chave_autenticidade = $certificado->chave_autenticidade;



			$texto_email = '

			<!-- NAME: 1 COLUMN --> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Encontro de Saberes</title>  <style type="text/css"> body,#bodyTable,#bodyCell{ height:100% !important; margin:0; padding:0; width:100% !important; } table{ border-collapse:collapse; } img,a img{ border:0; outline:none; text-decoration:none; } h1,h2,h3,h4,h5,h6{ margin:0; padding:0; } p{ margin:1em 0; padding:0; } a{ word-wrap:break-word; } .ReadMsgBody{ width:100%; } .ExternalClass{ width:100%; } .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{ line-height:100%; } table,td{ mso-table-lspace:0pt; mso-table-rspace:0pt; } #outlook a{ padding:0; } img{ -ms-interpolation-mode:bicubic; } body,table,td,p,a,li,blockquote{ -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; } #bodyCell{ padding:20px; } .mcnImage{ vertical-align:bottom; } .mcnTextContent img{ height:auto !important; }  body,#bodyTable{ /*@editable*/background-color:#F2F2F2; }  #bodyCell{ /*@editable*/border-top:0; }  #templateContainer{ /*@editable*/border:0; }  h1{ /*@editable*/color:#606060 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:40px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-1px; margin:0; /*@editable*/text-align:left; }  h2{ /*@editable*/color:#404040 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:26px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-.75px; margin:0; /*@editable*/text-align:left; }  h3{ /*@editable*/color:#606060 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:18px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-.5px; margin:0; /*@editable*/text-align:left; }  h4{ /*@editable*/color:#808080 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:16px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:normal; margin:0; /*@editable*/text-align:left; }  #templatePreheader{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:11px; /*@editable*/line-height:125%; /*@editable*/text-align:left; }  .preheaderContainer .mcnTextContent a{ /*@editable*/color:#606060; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateHeader{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:15px; /*@editable*/line-height:150%; /*@editable*/text-align:left; }  .headerContainer .mcnTextContent a{ /*@editable*/color:#6DC6DD; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateBody{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:15px; /*@editable*/line-height:150%; /*@editable*/text-align:left; }  .bodyContainer .mcnTextContent a{ /*@editable*/color:#6DC6DD; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateFooter{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:11px; /*@editable*/line-height:125%; /*@editable*/text-align:left; }  .footerContainer .mcnTextContent a{ /*@editable*/color:#606060; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; } @media only screen and (max-width: 480px){ body,table,td,p,a,li,blockquote{ -webkit-text-size-adjust:none !important; }  } @media only screen and (max-width: 480px){ body{ width:100% !important; min-width:100% !important; }  } @media only screen and (max-width: 480px){ td[id=bodyCell]{ padding:10px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnBoxedTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcpreview-image-uploader]{ width:100% !important; display:none !important; }  } @media only screen and (max-width: 480px){ img[class=mcnImage]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnImageGroupContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageGroupContent]{ padding:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageGroupBlockInner]{ padding-bottom:0 !important; padding-top:0 !important; }  } @media only screen and (max-width: 480px){ tbody[class=mcnImageGroupBlockOuter]{ padding-bottom:9px !important; padding-top:9px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{ padding-right:18px !important; padding-left:18px !important; padding-bottom:0 !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardBottomImageContent]{ padding-bottom:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardTopImageContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{ padding-right:18px !important; padding-left:18px !important; padding-bottom:0 !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardBottomImageContent]{ padding-bottom:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardTopImageContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{ padding-top:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnBoxedTextContentColumn]{ padding-left:18px !important; padding-right:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnTextContent]{ padding-right:18px !important; padding-left:18px !important; }  } @media only screen and (max-width: 480px){  table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{ max-width:600px !important; /*@editable*/width:100% !important; }  } @media only screen and (max-width: 480px){  h1{ /*@editable*/font-size:24px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h2{ /*@editable*/font-size:20px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h3{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h4{ /*@editable*/font-size:16px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  table[id=templatePreheader]{ /*@editable*/display:block !important; }  } @media only screen and (max-width: 480px){ p Make the preheader text larger in size for better readability on small screens.  td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:14px !important; /*@editable*/line-height:115% !important; }  } @media only screen and (max-width: 480px){  td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:14px !important; /*@editable*/line-height:115% !important; }  } @media only screen and (max-width: 480px){ td[class=footerContainer] a[class=utilityLink]{ display:block !important; }  }</style>  <center> <table id="bodyTable" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"> <tbody><tr> <td id="bodyCell" align="center" valign="top"> <!-- BEGIN TEMPLATE // --> <table id="templateContainer" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td align="center" valign="top"> <!-- BEGIN PREHEADER // --> <table id="templatePreheader" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="preheaderContainer" style="padding-top:9px;" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">   <br></td> </tr> </tbody></table>    </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END PREHEADER --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN HEADER // --> <table id="templateHeader" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="headerContainer" valign="top"><table class="mcnImageBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnImageBlockOuter"> <tr> <td style="padding:9px" class="mcnImageBlockInner" valign="top"> <table class="mcnImageContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody><tr> <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0;" valign="top">   <img alt="" src="http://encontrodesaberes.ufop.br/img/68a160f7-3e24-4a77-a30b-f61ae3319e94.png" style="max-width:750px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="left" width="564">   </td> </tr> </tbody></table> </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END HEADER --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN BODY // --> <table id="templateBody" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="bodyContainer" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">  <h3>Apresentação do trabalho "'.$titulo_enviado.'" registrada com sucesso.</h3> <p>Prezado(a),<br> </p><p>Agradecemos pela sua apresentação de trabalho durante o Encontro de Saberes. </p> <p>Segue o link para baixar o seu certificado de apresentador do Encontro de Saberes: </p> <p><a href="http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c='.$chave_autenticidade.'&f=1">http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c='.$chave_autenticidade.'&f=1</a></p> <p>Atenciosamente,</p> <p>Encontro de Saberes</p>   </td> </tr> </tbody></table>  </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END BODY --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN FOOTER // --> <table id="templateFooter" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="footerContainer" style="padding-bottom:9px;" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">  <em>Copyright © 2016 Universidade Federal de Ouro Preto</em><br> <br> &nbsp; </td> </tr> </tbody></table>  </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END FOOTER --> </td> </tr> </tbody></table> <!-- // END TEMPLATE --> </td> </tr> </tbody></table> </center>

			';

			$emails = array();

			$emails[] = $email_apresentador;

			$novo_email = array(

				'fgk_evento'		=> $id_evento_atual,

				'cpf_destinatario'	=> $cpf_apresentador,

				'nome_destinatario'	=> $nome_apresentador,

				'email_destinatario'=> $email_apresentador,

				'categoria'			=> "Certificado de apresentação",

				'assunto'			=> "Certificado de Apresentação - Encontro de Saberes",

				'corpo_email'		=> $texto_email

			);

			$db->inserir('es_comunicacao_email', $novo_email);

			$json_string = array(

			  'to' => $emails,

			  'category' => "Certificado de apresentação"

			);

			$params = array(

				'api_user'  => $user,

				'api_key'   => $pass,

				'x-smtpapi' => json_encode($json_string),

				'to'        => $emails,

				'subject'   => 'Certificado de Apresentação - Encontro de Saberes',

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

		}



		//verifica se o revisor já possui certificado

		$filtros = array();

		$qryRevisor = "

			SELECT es_avaliacao_revisor.id, es_inscritos.cpf, es_inscritos.nome, es_inscritos.email

			FROM es_avaliacao_revisor

			 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito

			WHERE es_avaliacao_revisor.id = ? AND es_inscritos.fgk_evento = ?

		";

		$filtros[] = $apresentacao->fgk_revisor;

		$filtros[] = $id_evento_atual;

		$qryRevisor = $db->sql_query2($qryRevisor, $filtros);

		foreach ($qryRevisor as $revisor);

		

		$filtros2 = array();

		$qryCertificadoRevisor = "

			SELECT es_certificados.id_certificado

			FROM es_certificados

			WHERE fgk_tipo = 29 AND fgk_evento = ? AND cpf = ?

		";

		$filtros2[] = $id_evento_atual;

		$filtros2[] = $revisor->cpf;

		$qryCertificadoRevisor = $db->sql_query2($qryCertificadoRevisor, $filtros2);

		

		if($qryCertificadoRevisor->rowCount() < 1){

			

			//cadastra novo certificado e envia email

			$certificadoTipo = $db->listar('es_certificados_tipos', 'id_tipo_certificado', 29);

			$partestexto = explode('NOME DO AVALIADOR', $certificadoTipo->modelo_padrao);

			$texto_certificado = $partestexto[0].$revisor->nome.$partestexto[1];

			$novo_certificado = array(

				'fgk_tipo'				=> 29,

				'dizeres_certificado'	=> $texto_certificado,

				'data_emissao'			=> date('Y-m-d H:i:s'),

				'fgk_evento'			=> $id_evento_atual,

				'email'					=> $revisor->email,

				'cpf'					=> $revisor->cpf,

				'nome'					=> $revisor->nome,

				'chave_autenticidade'	=> uniqid(time())

			);

			$db->inserir('es_certificados', $novo_certificado);

			$id_certificado = $db->lastInsertId();

			$certificado = $db->listar('es_certificados', 'id_certificado', $id_certificado);

			$chave_autenticidade = $certificado->chave_autenticidade;



			$texto_email = '

				<!-- NAME: 1 COLUMN --> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Encontro de Saberes</title>  <style type="text/css"> body,#bodyTable,#bodyCell{ height:100% !important; margin:0; padding:0; width:100% !important; } table{ border-collapse:collapse; } img,a img{ border:0; outline:none; text-decoration:none; } h1,h2,h3,h4,h5,h6{ margin:0; padding:0; } p{ margin:1em 0; padding:0; } a{ word-wrap:break-word; } .ReadMsgBody{ width:100%; } .ExternalClass{ width:100%; } .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{ line-height:100%; } table,td{ mso-table-lspace:0pt; mso-table-rspace:0pt; } #outlook a{ padding:0; } img{ -ms-interpolation-mode:bicubic; } body,table,td,p,a,li,blockquote{ -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; } #bodyCell{ padding:20px; } .mcnImage{ vertical-align:bottom; } .mcnTextContent img{ height:auto !important; }  body,#bodyTable{ /*@editable*/background-color:#F2F2F2; }  #bodyCell{ /*@editable*/border-top:0; }  #templateContainer{ /*@editable*/border:0; }  h1{ /*@editable*/color:#606060 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:40px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-1px; margin:0; /*@editable*/text-align:left; }  h2{ /*@editable*/color:#404040 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:26px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-.75px; margin:0; /*@editable*/text-align:left; }  h3{ /*@editable*/color:#606060 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:18px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:-.5px; margin:0; /*@editable*/text-align:left; }  h4{ /*@editable*/color:#808080 !important; display:block; /*@editable*/font-family:Helvetica; /*@editable*/font-size:16px; /*@editable*/font-style:normal; /*@editable*/font-weight:bold; /*@editable*/line-height:125%; /*@editable*/letter-spacing:normal; margin:0; /*@editable*/text-align:left; }  #templatePreheader{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:11px; /*@editable*/line-height:125%; /*@editable*/text-align:left; }  .preheaderContainer .mcnTextContent a{ /*@editable*/color:#606060; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateHeader{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:15px; /*@editable*/line-height:150%; /*@editable*/text-align:left; }  .headerContainer .mcnTextContent a{ /*@editable*/color:#6DC6DD; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateBody{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:15px; /*@editable*/line-height:150%; /*@editable*/text-align:left; }  .bodyContainer .mcnTextContent a{ /*@editable*/color:#6DC6DD; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; }  #templateFooter{ /*@editable*/background-color:#FFFFFF; /*@editable*/border-top:0; /*@editable*/border-bottom:0; }  .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{ /*@editable*/color:#606060; /*@editable*/font-family:Helvetica; /*@editable*/font-size:11px; /*@editable*/line-height:125%; /*@editable*/text-align:left; }  .footerContainer .mcnTextContent a{ /*@editable*/color:#606060; /*@editable*/font-weight:normal; /*@editable*/text-decoration:underline; } @media only screen and (max-width: 480px){ body,table,td,p,a,li,blockquote{ -webkit-text-size-adjust:none !important; }  } @media only screen and (max-width: 480px){ body{ width:100% !important; min-width:100% !important; }  } @media only screen and (max-width: 480px){ td[id=bodyCell]{ padding:10px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnBoxedTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcpreview-image-uploader]{ width:100% !important; display:none !important; }  } @media only screen and (max-width: 480px){ img[class=mcnImage]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnImageGroupContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageGroupContent]{ padding:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageGroupBlockInner]{ padding-bottom:0 !important; padding-top:0 !important; }  } @media only screen and (max-width: 480px){ tbody[class=mcnImageGroupBlockOuter]{ padding-bottom:9px !important; padding-top:9px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{ width:100% !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{ width:100% !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{ padding-right:18px !important; padding-left:18px !important; padding-bottom:0 !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardBottomImageContent]{ padding-bottom:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardTopImageContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{ padding-right:18px !important; padding-left:18px !important; padding-bottom:0 !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardBottomImageContent]{ padding-bottom:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnImageCardTopImageContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{ padding-top:9px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{ padding-top:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnBoxedTextContentColumn]{ padding-left:18px !important; padding-right:18px !important; }  } @media only screen and (max-width: 480px){ td[class=mcnTextContent]{ padding-right:18px !important; padding-left:18px !important; }  } @media only screen and (max-width: 480px){  table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{ max-width:600px !important; /*@editable*/width:100% !important; }  } @media only screen and (max-width: 480px){  h1{ /*@editable*/font-size:24px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h2{ /*@editable*/font-size:20px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h3{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  h4{ /*@editable*/font-size:16px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  table[id=templatePreheader]{ /*@editable*/display:block !important; }  } @media only screen and (max-width: 480px){ p Make the preheader text larger in size for better readability on small screens.  td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:14px !important; /*@editable*/line-height:115% !important; }  } @media only screen and (max-width: 480px){  td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:18px !important; /*@editable*/line-height:125% !important; }  } @media only screen and (max-width: 480px){  td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{ /*@editable*/font-size:14px !important; /*@editable*/line-height:115% !important; }  } @media only screen and (max-width: 480px){ td[class=footerContainer] a[class=utilityLink]{ display:block !important; } }</style>  <center> <table id="bodyTable" align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"> <tbody><tr> <td id="bodyCell" align="center" valign="top"> <!-- BEGIN TEMPLATE // --> <table id="templateContainer" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td align="center" valign="top"> <!-- BEGIN PREHEADER // --> <table id="templatePreheader" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="preheaderContainer" style="padding-top:9px;" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">   <br></td> </tr> </tbody></table>    </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END PREHEADER --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN HEADER // --> <table id="templateHeader" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="headerContainer" valign="top"><table class="mcnImageBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnImageBlockOuter"> <tr> <td style="padding:9px" class="mcnImageBlockInner" valign="top"> <table class="mcnImageContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody><tr> <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0;" valign="top">  <img alt="" src="http://encontrodesaberes.ufop.br/img/68a160f7-3e24-4a77-a30b-f61ae3319e94.png" style="max-width:750px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="left" width="564">   </td> </tr> </tbody></table> </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END HEADER --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN BODY // --> <table id="templateBody" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="bodyContainer" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">  <h3>Avaliação de pôster registrada com sucesso.</h3> <p>Prezado(a),<br> </p><p>Agradecemos pela sua avaliação de trabalhos durante o Encontro de Saberes. </p> <p>Segue o link para baixar o seu certificado de avaliador de trabalhos do Encontro de Saberes: </p> <p><a href="http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c='.$chave_autenticidade.'&f=1">http://www.encontrodesaberes.ufop.br/gerar_certificado.php?c='.$chave_autenticidade.'&f=1</a></p> <p>Atenciosamente,</p> <p>Encontro de Saberes</p>   </td> </tr> </tbody></table>  </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END BODY --> </td> </tr> <tr> <td align="center" valign="top"> <!-- BEGIN FOOTER // --> <table id="templateFooter" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr> <td class="footerContainer" style="padding-bottom:9px;" valign="top"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%"> <tbody class="mcnTextBlockOuter"> <tr> <td class="mcnTextBlockInner" valign="top">  <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600"> <tbody><tr>  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">  <em>Copyright © 2016 Universidade Federal de Ouro Preto</em><br> <br> &nbsp; </td> </tr> </tbody></table>  </td> </tr> </tbody> </table></td> </tr> </tbody></table> <!-- // END FOOTER --> </td> </tr> </tbody></table> <!-- // END TEMPLATE --> </td> </tr> </tbody></table> </center>

			';

			$emails = array();

			$emails[] = $revisor->email;

			$novo_email = array(

				'fgk_evento'		=> $id_evento_atual,

				'cpf_destinatario'	=> $revisor->cpf,

				'nome_destinatario'	=> $revisor->nome,

				'email_destinatario'=> $revisor->email,

				'categoria'			=> "Certificado de avaliação",

				'assunto'			=> "Certificado de Avaliação - Encontro de Saberes",

				'corpo_email'		=> $texto_email

			);

			$db->inserir('es_comunicacao_email', $novo_email);

			

			$json_string = array(

			  'to' => $emails,

			  'category' => "Certificado de avaliação"

			);

			$params = array(

				'api_user'  => $user,

				'api_key'   => $pass,

				'x-smtpapi' => json_encode($json_string),

				'to'        => $emails,

				'subject'   => 'Certificado de Avaliação - Encontro de Saberes',

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

		}

	}

	$db->commit();

	echo json_encode(array(

		"success" => true

	));

?>