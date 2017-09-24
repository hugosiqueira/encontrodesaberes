<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

  try {
       $buscar_dados = $db->sql_query('Select revisao1.justificativa as justificativa1, revisao1.nota as nota1,  revisao1.resultado as resultado1,
                                        revisao2.justificativa as justificativa2, revisao2.nota as nota2, revisao2.resultado as resultado2, es_avaliacao.fgk_trabalho, 
                                        es_trabalho.titulo_enviado, es_area_especifica.descricao_area_especifica

                                        from es_avaliacao

                                        INNER JOIN es_trabalho ON es_trabalho.id = es_avaliacao.fgk_trabalho AND es_avaliacao.bool_caint = 0
                                        LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica

                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor1 ON es_avaliacao.fgk_revisor1 = avaliacao_revisor1.id
                                        LEFT JOIN es_area_especifica as area_especifica_revisor1 ON avaliacao_revisor1.fgk_area_especifica = area_especifica_revisor1.id
                                        LEFT JOIN es_inscritos as nome_inscrito1 ON nome_inscrito1.id = avaliacao_revisor1.fgk_inscrito

                                        LEFT JOIN es_avaliacao_revisao as revisao1 ON revisao1.fgk_avaliacao = es_avaliacao.id and revisao1.fgk_revisor = es_avaliacao.fgk_revisor1
                                        LEFT JOIN es_avaliacao_revisor as revisor1 ON revisor1.id = revisao1.fgk_revisor
                                        LEFT JOIN es_inscritos as inscrito1 ON inscrito1.id = revisor1.fgk_inscrito

                                        LEFT JOIN es_avaliacao_revisor as avaliacao_revisor2 ON es_avaliacao.fgk_revisor2 = avaliacao_revisor2.id
                                        LEFT JOIN es_area_especifica as area_especifica_revisor2 ON avaliacao_revisor2.fgk_area_especifica = area_especifica_revisor2.id
                                        LEFT JOIN es_inscritos as nome_inscrito2 ON nome_inscrito2.id = avaliacao_revisor2.fgk_inscrito

                                        LEFT JOIN es_avaliacao_revisao as revisao2 ON revisao2.fgk_avaliacao = es_avaliacao.id and revisao2.fgk_revisor = es_avaliacao.fgk_revisor2
                                        LEFT JOIN es_avaliacao_revisor as revisor2 ON revisor2.id = revisao2.fgk_revisor
                                        LEFT JOIN es_inscritos as inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                        WHERE es_avaliacao.id = ?', array('es_avaliacao.id'=>$id_avaliacao));
       foreach ($buscar_dados as $registro) {
           $nota1 = $registro->nota1;
           $nota2 = $registro->nota2;
           $resultado1 =$registro->resultado1;
           $resultado2 =$registro->resultado2;
           $justificativa1  =$registro->justificativa1;
           $justificativa2  =$registro->justificativa2;
           $fgk_trabalho = $registro->fgk_trabalho;
           $titulo = $registro->titulo_enviado;
           $descricao_area_especifica = $registro->descricao_area_especifica;
       }
        if($nota1 && $nota2){
          $nota_final = ceil(($nota1 + $nota2)/2);
        } else if($nota1 && !$nota2){
          $nota_final = $nota1;
        } else if(!$nota1 && $nota2){
          $nota_final = $nota2;
        }

        if($justificativa1 && $justificativa2){
            $parecer_final = 'Parecer 1:
            '.$justificativa1 .'

Parecer 2: 
            '. $justificativa2;
        } else if($justificativa1 && !$justificativa2){
            $parecer_final = 'Parecer 1: 
            '.$justificativa1;
        } else if(!$justificativa1 && $justificativa2){
            $parecer_final = 'Parecer 2:
            '. $justificativa2;
        } else {
            $parecer_final = "";
        }

       if($resultado == "A" || $resultado =="R"){
           $status = 4;
       } else if($resultado == "AR"){
           $status = 3;
       }
       
       $stmt = $db->atualizar('es_avaliacao', array('nota'=>$nota_final,'resultado'=>$resultado, 'parecer'=>$parecer_final, 'status'=>$status), 'id', $id_avaliacao);
      

        if(!$stmt){
          echo "erro";
          exit();
        }
       

        $sel_autores = $db->sql_query("SELECT nome, email, cpf FROM es_trabalho_autor WHERE fgk_trabalho =?", array('fgk_trabalho'=>$fgk_trabalho));
        foreach ($sel_autores as $autores) {

        if($resultado == "A"){
          $status_trabalho = 6;
          $corpo_mensagem = '<p>Prezado(a) '. $autores->nome . ',</p>
                                  <p>Temos a satisfação de informá-lo(a) que o trabalho:</p>
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                  
                                  <p>Foi ACEITO para apresentação no Encontro de Saberes. Foi(ram) dado(s) o(s) seguinte(s) parecer(es):</p>
                                  <p>Parecer Geral:</p>
                                  <p>'. $parecer_final .'</p>
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>';

        } else if($resultado == "AR"){
          $status_trabalho = 7;
           $corpo_mensagem = '<p>Prezado(a) '. $autores->nome . ',</p>
                                  <p>Temos a satisfação de informá-lo(a) que o trabalho:</p>
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                           <p>Foi ACEITO COM RESTRIÇÕES para apresentação no Encontro de Saberes. Isto significa que o trabalho será aceito se atendidas as modificações indicadas na(s) avaliação(ões) descrita(s) a seguir:</p>
                                  <p>Parecer Geral:</p>
                                  <p>'. $parecer_final .'</p>
                                  <p>Informamos que a edição final do resumo deve ser concluída no site www.encontrodesaberes.ufop.br, usando-se o login (CPF) e senha do usuário que submeteu o trabalho.</p>
                                  <p>Atenção, é possível inserir os agradecimentos aos apoiadores financeiros no final do resumo, integrando-o ao texto. Caso ainda não tenha feito, sugerimos que o faça para que conste nos Anais do Encontro de Saberes.</p>
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>';

        } 
        else if($resultado == "R"){
          $status_trabalho = 8;
          $corpo_mensagem = '<p>Prezado(a) '. $autores->nome . ',</p>
                                  <p>Infelizmente informamos que o trabalho:</p>
                                  <p>Evento: Encontro de Saberes</p>
                                  <p>Título: ' . $titulo . '</p>
                                  <p>Área de Conhecimento: ' . $descricao_area_especifica. ' </p>
                                  
                                  <p>NÃO FOI ACEITO para apresentação no Encontro de Saberes. Foi dado o seguinte parecer:</p>
                                  <p>Parecer Geral:</p>
                                  <p>'. $parecer_final .'</p>
                                  <p>Atenciosamente</p>
                                  <p>--</p>
                                  <p>Coordenação do Encontro de Saberes<br>
                                    Centro de Artes e Convenções da UFOP<br>
                                    Ouro Preto, MG
                                    </p>'; 
        } 
 $stmt = $db->atualizar('es_trabalho', array('fgk_status'=>$status_trabalho),'id', $fgk_trabalho) ;
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
                                  '.$corpo_mensagem.' 
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
                'subject'   => 'Encontro de Saberes - Situação do seu trabalho',
                'html'      => $mensagem,
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

           $dados_email= array('fgk_evento'=>EVENTO_ATUAL,
                    'cpf_destinatario'=>$autores->cpf,
                    'nome_destinatario'=>$autores->nome,
                    'email_destinatario'=>$autores->email,
                    'categoria'=> 'Parecer',
                    'assunto'=>'Encontro de Saberes - Parecer do trabalho',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));
            $db->inserir('es_comunicacao_email', $dados_email);
        }


     

            echo "sucesso";

  } catch(PDOException $e) {
    echo $e->getMessage();

  }
}
