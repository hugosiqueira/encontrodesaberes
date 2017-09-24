<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
//include ("../../config.php");


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

try {
    $db->iniciar_transacao();
    if($fgk_status == TRABALHO_SUBMETIDO){
      $datahora_submissao = date('Y-m-d H:i:s');
    } else {
      $datahora_submissao = NULL;
    }
	
	if (!$tipo_autor_responsavel){
		echo "Preencha o tipo do autor.";
		exit();
	} 
	
	$verifica_qtd_trabalho_categoria = verificaTrabInscrito($db, ID_USUARIO, $categoria, EVENTO_ATUAL);
	if($verifica_qtd_trabalho_categoria > 0){
		echo "Prezado(a) ".NOME_USUARIO.", você já submeteu um trabalho neste evento, não é permitido adicionar mais trabalhos.";
		exit();
	}
	
	$verifica_trabalho_repetido =  verificaTrabNome($db, $titulo, CPF_USUARIO, EVENTO_ATUAL, $categoria);
	if($verifica_trabalho_repetido > 0){
		echo "Prezado(a) ".NOME_USUARIO.", você já é autor de um trabalho com o mesmo nome e não é aceito trabalhos repetidos.";
		exit();
	}

    $dados = array(
    'fgk_area' => $area,
    'fgk_area_especifica' => $area_especifica,
    'fgk_evento' => EVENTO_ATUAL, 
    'fgk_orgao_fomento' => $orgao_fomento,
    'fgk_inscrito_responsavel' => ID_USUARIO,
    'fgk_categoria' => $categoria, 
	'fgk_instituicao' => INSTITUICAO_USUARIO, 
    'fgk_tipo_apresentacao' => 1,
    'apresentacao_obrigatoria' => 0,
    'palavras_chave' => $palavras_chave,
    'resumo_enviado' => $resumo_enviado,
    'titulo_enviado' => $titulo,
    'fgk_status'=> $fgk_status,
    'datahora_ultima_atualizacao' => date('Y-m-d H:i:s'),
    'datahora_submissao' => $datahora_submissao,
	'apoio_financeiro' => $apoio_financeiro, 
	'protocolo_cep' => $protocolo_cep,
	'protocolo_ceua' => $protocolo_ceua,
	'autorizacao_repositorio' => $autorizacao_repositorio
	
    );
    
    $inserir = $db->inserir('es_trabalho', $dados);
    if(!$inserir){
        echo("Erro ao cadastrar trabalho.");
    }

    $trabalho = $db->sql_query("SELECT id FROM es_trabalho ORDER BY id DESC LIMIT 1");
    foreach ($trabalho as $key) {
        $fgk_trabalho = $key->id;
    }
	
	
		
    $dados_autor_responsavel = array(
        'fgk_instituicao' => INSTITUICAO_USUARIO,
        'fgk_trabalho' => $fgk_trabalho,
        'fgk_tipo_autor' => $tipo_autor_responsavel,
        'cpf' => CPF_USUARIO,
        'nome' => NOME_USUARIO,
        'email' => EMAIL_USUARIO,
        'ordenacao' => 1,
        'bool_apresentador' => $apresentador_responsavel
        );
	
    $inserir_autor = $db->inserir('es_trabalho_autor', $dados_autor_responsavel);
	if(!$inserir_autor){
         $db->reverter();
         echo ("Erro ao cadastrar autores");
    }
	if($qtdautor >0){
		for ($i = 1; $i <= $qtdautor; $i++){
			$instituicao_autor = "instituicao_autor".$i;
			$tipo_autor = "tipo_autor".$i;
			$cpf_autor = "cpf_autor".$i;
			$nome_autor = "nome_autor".$i;
			$email_autor = "email_autor".$i;
			$apresentador = "apresentador".$i;
			
			if(!$instituicao_autor){
				echo "Preencha a instituição do autor";
				exit();
			} else if (!$fgk_trabalho){
				echo "Faltando o campo que identifica o trabalho. Favor comunicar ao suporte.";
				exit();
			} else if (!$$tipo_autor){
				echo "Preencha o tipo do autor.";
				exit();
			} else if (!$$cpf_autor){
				echo "Faltando o cpf do autor.";
				exit();
			} else if (!$$nome_autor){
				echo "Faltando o nome do autor.";
				exit();
			} else if (!$$email_autor){
				echo "Faltando o email do autor.";
				exit();
			} 

			$dados_autor = array(
			'fgk_instituicao' => $$instituicao_autor,
			'fgk_trabalho' => $fgk_trabalho,
			'fgk_tipo_autor' => $$tipo_autor,
			'cpf' => $$cpf_autor,
			'nome' => $$nome_autor,
			'email' => $$email_autor,
			'ordenacao' => ($i+1),
			'bool_apresentador' => $$apresentador
			);
			
			

			$inserir_autor = $db->inserir('es_trabalho_autor', $dados_autor);
		}
		if(!$inserir_autor){
			 $db->reverter();
			 die("Erro ao cadastrar autores");
		}
	}

    
    
    if($fgk_status == TRABALHO_SUBMETIDO){
        $sel_autores = $db->sql_query("SELECT nome, email, cpf FROM es_trabalho_autor WHERE fgk_trabalho =?", array('fgk_trabalho'=>$fgk_trabalho));
        foreach ($sel_autores as $autores) {
            $mensagem = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- NAME: 1 COLUMN -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Encontro de Saberes</title>

  <style type="text/css">
  body,#bodyTable,#bodyCell{
    height:100% !important;
    margin:0;
    padding:0;
    width:100% !important;
  }
  table{
    border-collapse:collapse;
  }
  img,a img{
    border:0;
    outline:none;
    text-decoration:none;
  }
  h1,h2,h3,h4,h5,h6{
    margin:0;
    padding:0;
  }
  p{
    margin:1em 0;
    padding:0;
  }
  a{
    word-wrap:break-word;
  }
  .ReadMsgBody{
    width:100%;
  }
  .ExternalClass{
    width:100%;
  }
  .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
    line-height:100%;
  }
  table,td{
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
  }
  #outlook a{
    padding:0;
  }
  img{
    -ms-interpolation-mode:bicubic;
  }
  body,table,td,p,a,li,blockquote{
    -ms-text-size-adjust:100%;
    -webkit-text-size-adjust:100%;
  }
  #bodyCell{
    padding:20px;
  }
  .mcnImage{
    vertical-align:bottom;
  }
  .mcnTextContent img{
    height:auto !important;
  }

  body,#bodyTable{
    /*@editable*/background-color:#F2F2F2;
  }

  #bodyCell{
    /*@editable*/border-top:0;
  }

  #templateContainer{
    /*@editable*/border:0;
  }

  h1{
    /*@editable*/color:#606060 !important;
    display:block;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:40px;
    /*@editable*/font-style:normal;
    /*@editable*/font-weight:bold;
    /*@editable*/line-height:125%;
    /*@editable*/letter-spacing:-1px;
    margin:0;
    /*@editable*/text-align:left;
  }

  h2{
    /*@editable*/color:#404040 !important;
    display:block;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:26px;
    /*@editable*/font-style:normal;
    /*@editable*/font-weight:bold;
    /*@editable*/line-height:125%;
    /*@editable*/letter-spacing:-.75px;
    margin:0;
    /*@editable*/text-align:left;
  }

  h3{
    /*@editable*/color:#606060 !important;
    display:block;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:18px;
    /*@editable*/font-style:normal;
    /*@editable*/font-weight:bold;
    /*@editable*/line-height:125%;
    /*@editable*/letter-spacing:-.5px;
    margin:0;
    /*@editable*/text-align:left;
  }

  h4{
    /*@editable*/color:#808080 !important;
    display:block;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:16px;
    /*@editable*/font-style:normal;
    /*@editable*/font-weight:bold;
    /*@editable*/line-height:125%;
    /*@editable*/letter-spacing:normal;
    margin:0;
    /*@editable*/text-align:left;
  }

  #templatePreheader{
    /*@editable*/background-color:#FFFFFF;
    /*@editable*/border-top:0;
    /*@editable*/border-bottom:0;
  }

  .preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
    /*@editable*/color:#606060;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:11px;
    /*@editable*/line-height:125%;
    /*@editable*/text-align:left;
  }

  .preheaderContainer .mcnTextContent a{
    /*@editable*/color:#606060;
    /*@editable*/font-weight:normal;
    /*@editable*/text-decoration:underline;
  }

  #templateHeader{
    /*@editable*/background-color:#FFFFFF;
    /*@editable*/border-top:0;
    /*@editable*/border-bottom:0;
  }

  .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
    /*@editable*/color:#606060;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:15px;
    /*@editable*/line-height:150%;
    /*@editable*/text-align:left;
  }

  .headerContainer .mcnTextContent a{
    /*@editable*/color:#6DC6DD;
    /*@editable*/font-weight:normal;
    /*@editable*/text-decoration:underline;
  }

  #templateBody{
    /*@editable*/background-color:#FFFFFF;
    /*@editable*/border-top:0;
    /*@editable*/border-bottom:0;
  }

  .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
    /*@editable*/color:#606060;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:15px;
    /*@editable*/line-height:150%;
    /*@editable*/text-align:left;
  }

  .bodyContainer .mcnTextContent a{
    /*@editable*/color:#6DC6DD;
    /*@editable*/font-weight:normal;
    /*@editable*/text-decoration:underline;
  }

  #templateFooter{
    /*@editable*/background-color:#FFFFFF;
    /*@editable*/border-top:0;
    /*@editable*/border-bottom:0;
  }

  .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
    /*@editable*/color:#606060;
    /*@editable*/font-family:Helvetica;
    /*@editable*/font-size:11px;
    /*@editable*/line-height:125%;
    /*@editable*/text-align:left;
  }

  .footerContainer .mcnTextContent a{
    /*@editable*/color:#606060;
    /*@editable*/font-weight:normal;
    /*@editable*/text-decoration:underline;
  }
  @media only screen and (max-width: 480px){
    body,table,td,p,a,li,blockquote{
      -webkit-text-size-adjust:none !important;
    }

  } 
  @media only screen and (max-width: 480px){
    body{
      width:100% !important;
      min-width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[id=bodyCell]{
      padding:10px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnTextContentContainer]{
      width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnBoxedTextContentContainer]{
      width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcpreview-image-uploader]{
      width:100% !important;
      display:none !important;
    }

  } 
  @media only screen and (max-width: 480px){
    img[class=mcnImage]{
      width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnImageGroupContentContainer]{
      width:100% !important;
    }

  }
  @media only screen and (max-width: 480px){
    td[class=mcnImageGroupContent]{
      padding:9px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageGroupBlockInner]{
      padding-bottom:0 !important;
      padding-top:0 !important;
    }

  } 
  @media only screen and (max-width: 480px){
    tbody[class=mcnImageGroupBlockOuter]{
      padding-bottom:9px !important;
      padding-top:9px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
      width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
      width:100% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
      padding-right:18px !important;
      padding-left:18px !important;
      padding-bottom:0 !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardBottomImageContent]{
      padding-bottom:9px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardTopImageContent]{
      padding-top:18px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
      padding-right:18px !important;
      padding-left:18px !important;
      padding-bottom:0 !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardBottomImageContent]{
      padding-bottom:9px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnImageCardTopImageContent]{
      padding-top:18px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
      padding-top:9px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
      padding-top:18px !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=mcnBoxedTextContentColumn]{
      padding-left:18px !important;
      padding-right:18px !important;
    }

  }
  @media only screen and (max-width: 480px){
    td[class=mcnTextContent]{
      padding-right:18px !important;
      padding-left:18px !important;
    }

  } 
  @media only screen and (max-width: 480px){

    table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
      max-width:600px !important;
      /*@editable*/width:100% !important;
    }

  }
  @media only screen and (max-width: 480px){
      /*@editable*/font-size:24px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){

    h2{
      /*@editable*/font-size:20px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){
   
    h3{
      /*@editable*/font-size:18px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){

    h4{
      /*@editable*/font-size:16px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){

    table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
      /*@editable*/font-size:18px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    
    table[id=templatePreheader]{
      /*@editable*/display:block !important;
    }

  } 
  @media only screen and (max-width: 480px){
    p Make the preheader text larger in size for better readability on small screens.

    td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
      /*@editable*/font-size:14px !important;
      /*@editable*/line-height:115% !important;
    }

  } 
  @media only screen and (max-width: 480px){

    td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
      /*@editable*/font-size:18px !important;
      /*@editable*/line-height:125% !important;
    }

  }
  @media only screen and (max-width: 480px){

    td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
      /*@editable*/font-size:18px !important;
      /*@editable*/line-height:125% !important;
    }

  } 
  @media only screen and (max-width: 480px){
   
    td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
      /*@editable*/font-size:14px !important;
      /*@editable*/line-height:115% !important;
    }

  } 
  @media only screen and (max-width: 480px){
    td[class=footerContainer] a[class=utilityLink]{
      display:block !important;
    }

  }</style></head>
  <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <center>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
          <td align="center" valign="top" id="bodyCell">
            <!-- BEGIN TEMPLATE // -->
            <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN PREHEADER // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader">
                    <tr>
                      <td valign="top" class="preheaderContainer" style="padding-top:9px;"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody class="mcnTextBlockOuter">
                          <tr>
                            <td class="mcnTextBlockInner" valign="top">

                              <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366">
                                <tbody><tr>

                                  <td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">


                                  </td>
                                </tr>
                              </tbody></table>



                            </td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
                  <!-- // END PREHEADER -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN HEADER // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                    <tr>
                      <td valign="top" class="headerContainer"><table class="mcnImageBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody class="mcnImageBlockOuter">
                          <tr>
                            <td style="padding:9px" class="mcnImageBlockInner" valign="top">
                              <table class="mcnImageContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody><tr>
                                  <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0;" valign="top">


                                    <img alt="" src="../img/68a160f7-3e24-4a77-a30b-f61ae3319e94.png" style="max-width:750px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="left" width="564">
                                    

                                  </td>
                                </tr>
                              </tbody></table>
                            </td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
                  <!-- // END HEADER -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN BODY // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                    <tr>
                      <td valign="top" class="bodyContainer"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody class="mcnTextBlockOuter">
                          <tr>
                            <td class="mcnTextBlockInner" valign="top">

                              <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody><tr>

                                  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                                    <h3>Trabalho submetido.</h3>
                                    <p>Prezado(a) '.$autores->nome.',<br>
                                    <p>Recebemos o resumo do seu trabalho científico,'.$titulo.', para o Encontro de Saberes UFOP. </p>
                                    <p>Fique atento aos prazos para edição do trabalho em sua área restrita no site. </p>
                                    <p>Detalhes do trabalho:</p>
									<p><strong>Trabalho Submetido por:</strong>'.NOME_USUARIO.'</p>
                                    <p><strong>Título: </strong> '.$titulo.'</p>
                                    <p><strong>Palavras-chave: </strong>'.$palavras_chave.'</p>
                                    <p><strong>Resumo: </strong>'.$resumo_enviado.'</p>
                                    <p>Atenciosamente,</p>
                                    <p>Encontro de Saberes</p>


                                  </td>
                                </tr>
                              </tbody></table>

                            </td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
                  <!-- // END BODY -->
                </td>
              </tr>
              <tr>
                <td align="center" valign="top">
                  <!-- BEGIN FOOTER // -->
                  <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
                    <tr>
                      <td valign="top" class="footerContainer" style="padding-bottom:9px;"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody class="mcnTextBlockOuter">
                          <tr>
                            <td class="mcnTextBlockInner" valign="top">

                              <table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody><tr>

                                  <td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">

                                    <em>Copyright © Universidade Federal de Ouro Preto</em><br>
                                    <br>
                                    &nbsp;
                                  </td>
                                </tr>
                              </tbody></table>

                            </td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table>
                  <!-- // END FOOTER -->
                </td>
              </tr>
            </table>
            <!-- // END TEMPLATE -->
          </td>
        </tr>
      </table>
    </center>
  </body>
  </html>';
            $mensagem_text = 'Prezado(a) '.$autores->nome.',
                         Recebemos o resumo do seu trabalho científico,'.$titulo.', para o Encontro de Saberes UFOP.
                        Fique atento aos prazos para edição do trabalho em sua área restrita no site.
                        Detalhes do trabalho:</p>
						<p><strong>Trabalho Submetido por:</strong>'.NOME_USUARIO.'</p>
                        Título: '.$titulo.'
                        Palavras-chave: '.$palavras_chave.'
                        Resumo: '.$resumo_enviado.'
                        Atenciosamente,
                        Encontro de Saberes';

            $url = 'https://api.sendgrid.com/';
            $user = 'encontrosaberes';
            $pass = 'se2015ic';

            $json_string = array(
              'category' => 'Trabalho Submetido'
            );


            $params = array(
                'api_user'  => $user,
                'api_key'   => $pass,
                'x-smtpapi' => json_encode($json_string),
                'to'        => $autores->email,
                'subject'   => 'Encontro de Saberes - Trabalho submetido',
                'html'      => $mensagem,
                'text'      => $mensagem_text,
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

            $dados_email= array('fgk_evento'=>EVENTO_ATUAL,
                    'cpf_destinatario'=>$autores->cpf,
                    'nome_destinatario'=>$autores->nome,
                    'email_destinatario'=>$autores->email,
                    'categoria'=> 'Trabalho Submetido',
                    'assunto'=>'Encontro de Saberes - Trabalho submetido',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));
            $db->inserir('es_comunicacao_email', $dados_email);
        }
    }
    $db->commit();
    echo "sucesso";


  } catch(PDOException $e) {
    echo $e->getMessage();

  }
}