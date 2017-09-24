<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
  include ("../../config.php");


  foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}
  $datahora_registro = date('Y-m-d H:i:s');
  switch($tipo_inscrito){
    case 1:
    $fgk_servico = 6;
    $descricao_servico = "MINICURSO - ALUNO UFOP";
    break;
    case 2:
    $fgk_servico = 7;
    $descricao_servico = "MINICURSO - PROFESSOR UFOP";
    break;
    case 3:
    $fgk_servico = 8;
    $descricao_servico = "MINICURSO - ALUNO EXTERNO";
    break;
    case 4:
    $fgk_servico = 9;
    $descricao_servico = "MINICURSO - PROFESSOR EXTERNO";
    break;
    case 5:
    $fgk_servico = 10;
    $descricao_servico = "MINICURSO - TÉCNICO ADMINISTRATIVO";
    break;
  }

  $verifica_valor = $db->sql_query("SELECT * FROM es_servicos WHERE id_servico = ?", array('id_servico' => $fgk_servico));
  foreach ($verifica_valor as $key) {
    $valor_inscricao = $key->valor_servico;
  }
  if(!$verifica_valor){
    echo "Houve um problema ao verificar o valor do serviço";
    exit();
  }


  try {

   $buscar_token = $db->sql_query("SELECT token, token_url FROM es_pagamentos_tipos WHERE fgk_evento = ? AND id_tipo_pagamento = ?", array('fgk_evento'=>1, 'id_tipo_pagamento'=> 2));
   foreach ($buscar_token as $registro) {
    $token = $registro->token;
    $url = $registro->token_url;
  }
   if(!$buscar_token){
    echo "Houve um problema ao buscar o token da empresa.";
    exit();
  }

  $cpf = preg_replace("/[^0-9\s]/", "", $_SESSION['cpf']);
  $telefone_celular = str_replace(' ', '', $_SESSION['celular']);
  $telefone_celular = preg_replace("/[^0-9\s]/", "", $telefone_celular);
  $xml = "<?xml version='1.0' encoding='utf-8'?>
  <boleto>
  <token>".$token."</token>
  <clientes><cliente>
  <nomeRazaoSocial>".$_SESSION['nome_usuario']."</nomeRazaoSocial>
  <cpfcnpj>".$cpf."</cpfcnpj>
  </cliente></clientes>
  <itens><item>
  <descricao>".$descricao_servico." - ".$titulo."</descricao>
  <valor>".preg_replace("/[^0-9\s]/", "", $valor_inscricao)."</valor>
  <qtde>1</qtde>
  </item></itens>
  <vencimento>01/11/2017</vencimento>
  </boleto>";
  $xml = str_replace("\n", '', $xml);
  $xml = str_replace("\r",'',$xml);
  $xml = str_replace("\t",'',$xml);


  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_MAXREDIRS, 2);

  curl_setopt($ch, CURLOPT_AUTOREFERER, true);

  $data = array('entrada' => $xml);

  curl_setopt($ch, CURLOPT_POST, true);

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

  curl_setopt($ch, CURLOPT_USERAGENT, 'seu agente');

  $resposta = curl_exec($ch); 

  curl_close($ch);

  $retorno = simplexml_load_string($resposta);

  if($retorno->statusCod == 2){
    $chave = $retorno->resposta->cobrancasGeradas->cliente->cobranca->chave; 
    $link = $retorno->resposta->cobrancasGeradas->cliente->cobranca->link;
    $vencimento = $retorno->resposta->cobrancasGeradas->cliente->cobranca->vencimento; 
    $valor = $retorno->resposta->cobrancasGeradas->cliente->cobranca->valor; 
    } else if($retorno->resposta->erro->status == 1012){ // significa que é um erro de cobrança já gerada anteriormente. Logo, iremos tratar a resposta anterior.
      $retornoAnterior = $retorno->resposta->erro->entrada;
      $link = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link;
      $chave = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->chave;
      $vencimento = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->vencimento;
      $valor = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->valor;
    } else {
        //Foi outro tipo de erro. Nesse caso, pode ser tratado, ou então mostrar o erro na página
      echo "Houve um problema ao gerar o boleto. Erro:".$retorno->resposta->erro->status;
      exit();
    }


    $dados_boleto = array('fgk_inscrito' => $id_inscrito, 
      'chave' => $chave,
      'data_emissao' => date('Y-m-d'),
      'valor' => $valor,
      'data_vencimento' => $vencimento,
      'link' => $link);

    $stmt_boleto = $db->inserir('es_inscritos_boletos', $dados_boleto); 

    if(!$stmt_boleto){
      echo "Houve um problema ao cadastrar o boleto";
      exit();
    }

    $boleto = $db->sql_query("SELECT id_boleto FROM es_inscritos_boletos ORDER BY id_boleto DESC LIMIT 1");
    foreach ($boleto as $registro) {
      $id_boleto = $registro->id_boleto;
    }

    if(!$boleto){
      echo "Houve um problema ao selecionar o id do boleto";
      exit();
    }

    $dados_servico = array('fgk_inscrito' => $id_inscrito,
      'fgk_servico' => $fgk_servico,
      'fgk_boleto' => $id_boleto,
      'valor_servico' => $valor,
      'bool_pago' => 0);

    $stmt_servico = $db->inserir('es_inscritos_servicos', $dados_servico);
    if(!$stmt_servico){
      echo "Houve um problema ao inserir o serviço inscritos";
      exit();
    }
    $verifica_inscrito_servico = $db->sql_query("SELECT id_inscrito_servico  FROM es_inscritos_servicos ORDER BY id_inscrito_servico DESC LIMIT 1");
    foreach ($verifica_inscrito_servico as $registro) {
      $id_inscrito_servico = $registro->id_inscrito_servico;
    }
    if(!$verifica_inscrito_servico){
      echo "Houve um problema ao selecionar o id_inscrito_servico";
      exit();
    }

    $inscrever = $db->inserir('es_minicursos_inscritos', array('fgk_minicurso'=>$id_minicurso, 'fgk_inscrito_servico'=>$id_inscrito_servico, 'datahora_registro'=>$datahora_registro));

    if(!$inscrever){
      echo "Houve um problema ao cadastrar sua inscricao";
      exit();
    }

    $mensagem = '
          <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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

              h1{
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


                                              <img alt="" src="http://encontrodesaberes.ufop.br/img/68a160f7-3e24-4a77-a30b-f61ae3319e94.png" style="max-width:750px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="left" width="564">
                                              

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

                                              <p>Prezado(a) '.$_SESSION['nome_usuario'].',<br>
                                              <p>A sua inscrição no minicurso '.$titulo.', foi realizada com sucesso. </p>
                                              <p>Data: '.$data_curso.' - '.$hora_ini.' - '.$hora_fim.'</p>
                                              <p>Local: '.$local.'</p>
                                              <p>Lembramos que para efetivar a sua participação no minicurso, você deverá efetuar o pagamento do boleto até o dia 01 de novembro de 2015. Caso já queira efetuar o pagamento, clique no link abaixo para gerar o seu boleto:</p>
                                              <p><a href="'.$link.'" target="_blank">'.$link.'</a></p>
                                              <p>Atenção: a inscrição no minicurso só será confirmada se o participante estiver com a inscrição confirmada no evento. Portanto, a inscrição no evento deverá ser confirmada para que a vaga no minicurso seja garantida.</p>

                                              <p>* não há reembolso, em nenhuma hipótese.</p>
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
            </html>
          ';
            $mensagem_text = '<p>Prezado(a) '.$_SESSION['nome_usuario'].',<br>
                              <p>A sua inscrição no minicurso, '.$titulo.', foi realizada com sucesso. </p>
                              <p>Data: '.$data.' - '.$hora_ini.' - '.$hora_fim.'</p>
                              <p>Local: '.$local.'</p>
                              <p>Lembramos que para efetivar a sua participação no minicurso, você deverá efetuar o pagamento do boleto até o dia 01 de novembro. Caso já queira efetuar o pagamento, clique no link abaixo para gerar o seu boleto:</p>
                              <p><a href="'.$link.'" target="_blank">'.$link.'</a></p>
                              <p>Atenciosamente,</p>
                              <p>Encontro de Saberes</p>';

            $url = 'https://api.sendgrid.com/';
            $user = 'encontrosaberes';
            $pass = 'se2015ic';

            $json_string = array(
              'category' => 'Inscrição Minicurso'
            );


            $params = array(
                'api_user'  => $user,
                'api_key'   => $pass,
                'x-smtpapi' => json_encode($json_string),
                'to'        => $_SESSION['email'],
                'subject'   => 'Encontro de Saberes - Inscrição em minicurso',
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
            
            $dados_email= array('fgk_evento'=>1,
                    'cpf_destinatario'=>$_SESSION['cpf'],
                    'nome_destinatario'=>$_SESSION['nome_usuario'],
                    'email_destinatario'=>$_SESSION['email'],
                    'categoria'=> 'Inscrição Minicurso',
                    'assunto'=>'Encontro de Saberes - Inscrição em minicurso',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));

            $db->inserir('es_comunicacao_email', $dados_email);

    echo "sucesso";

  } catch(PDOException $e) {
    echo $e->getMessage();

  }
}




