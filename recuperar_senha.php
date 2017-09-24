<?php
include "../config.php";
$tipo = $_GET['tipo'];
$cpf = $_GET['cpf'];
$existe_usuario = $db->existe('es_inscritos',array('cpf'=>$cpf));
if(!$existe_usuario){
  header('location: http://encontrodesaberes.ufop.br/esqueceu.php?erro=1');
}  else {
include "header.php"; 
include "bibliotecas.php";
?>
<div id="highlighted">

    <div class="container">

        <div class="header">

            <h2 class="page-title">

                <span>Redefinir minha senha</span> 
                <small></small>
            
            </h2>

        </div>

    </div>

</div>
<div id="content">

    <div class="container">
    	<?php 

      $sql = "SELECT * FROM es_inscritos WHERE cpf= ?";
      $dados = array('cpf' => $cpf );
      $query = $db->sql_query($sql, $dados);
      foreach ($query as $registro) {
          $nome = $registro->nome;
          $email = $registro->email;
          $email_alternativo = $registro->email_alternativo;
          $email_criptografado = base64_encode($email);
      }
      function enviar_sms($cpf, $db){
        include "/home/encontrosaberes/encontrodesaberes.ufop.br/includes/_BrasbipClass.php";
        $sql = "SELECT * FROM es_inscritos WHERE cpf = ?";
        $dados = array('cpf' => $cpf );
        $query = $db->sql_query($sql, $dados);
        foreach ($query as $registro) {
          $nome= $registro->nome;
          $email_criptografado= base64_encode($registro->email);
          $telefone_celular = "55".preg_replace("/[^0-9\s]/", "",$registro->telefone_celular);
          $cod_recuperacao_sms = rand(10000, 99999);
        }
        $atualizar = $db->atualizar('es_inscritos', array('cod_recuperacao_sms'=>$cod_recuperacao_sms), 'cpf', $cpf);
        $sender = "SEIC";
        $nome = substr($nome, 0, strpos($nome, ' '));
        $sender = str_replace("+","%2b",$sender);
        
        $messagetext=$nome.", segue o codigo para recuperacao da senha do encontro de saberes:".$cod_recuperacao_sms;
        
       $sendSMS = new BrasbipSMS();
       $resposta = $sendSMS->enviaSMS("seic_sms","se2015ic",$sender,$messagetext,0, $telefone_celular, "longSMS", "");

        echo '
        <div class="row">
          <div class="form-group col-md-12">
            <label for="codigo">Codigo SMS</label>
            <input type="text" class="form-control"  id="codigo" name ="codigo" >
            <p class="help-block"></p>
          </div>
          <div class="form-actions" style="background: #fff;">
            <button class="btn btn-primary btn-large pull-left" id="button_enviar" type="submit">Enviar</button>
          </div>
        </div>
         <script type="text/javascript" charset="utf-8">
          
        $("#button_enviar").click(function() {
            var codigo = $("#codigo").val();
          $.post("verifica_codigo.php", {cpf: "'.$cpf.'", codigo: codigo},
            function(resposta) {
              if (resposta != false) {
                 window.location="recuperar_senha.php?token='.$email_criptografado.'&cpf='.$cpf.'";

              } 
              else {
                  BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: "Erro",
                    message: "Codigo incorreto.",
                    buttons: [{
                        label: "Tentar novamente",
                        cssClass: "btn-primary",
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                       },{
                        label: "Enviar outro código",
                        cssClass: "btn-primary",
                        icon: "glyphicon glyphicon-phone",
                        action: function(dialogRef){    
                            window.location="recuperar_senha.php?tipo=sms&cpf='.$cpf.'";
                        }
                       }]
                     });
              }
            });
        });

        </script>';

        
      }


      function enviar_email($cpf, $db){

        $sql = "SELECT * FROM es_inscritos WHERE cpf = ?";
        $dados = array('cpf' => $cpf );
        $query = $db->sql_query($sql, $dados);
        foreach ($query as $registro) {
          $nome = $registro->nome;
          $email = $registro->email;
          $email_criptografado = base64_encode($email);
          $email_alternativo = $registro->email_alternativo;
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
          /*
          @tab Page
          @section background style
          @tip Set the background color and top border for your email. You may want to choose colors that match your companys branding.
          */
            body,#bodyTable{
              /*@editable*/background-color:#F2F2F2;
            }
          /*
          @tab Page
          @section background style
          @tip Set the background color and top border for your email. You may want to choose colors that match your companys branding.
          */
            #bodyCell{
              /*@editable*/border-top:0;
            }
          /*
          @tab Page
          @section email border
          @tip Set the border for your email.
          */
            #templateContainer{
              /*@editable*/border:0;
            }
          /*
          @tab Page
          @section heading 1
          @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
          @style heading 1
          */
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
          /*
          @tab Page
          @section heading 2
          @tip Set the styling for all second-level headings in your emails.
          @style heading 2
          */
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
          /*
          @tab Page
          @section heading 3
          @tip Set the styling for all third-level headings in your emails.
          @style heading 3
          */
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
          /*
          @tab Page
          @section heading 4
          @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
          @style heading 4
          */
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
          /*
          @tab Preheader
          @section preheader style
          @tip Set the background color and borders for your emails preheader area.
          */
            #templatePreheader{
              /*@editable*/background-color:#FFFFFF;
              /*@editable*/border-top:0;
              /*@editable*/border-bottom:0;
            }
          /*
          @tab Preheader
          @section preheader text
          @tip Set the styling for your emails preheader text. Choose a size and color that is easy to read.
          */
            .preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
              /*@editable*/color:#606060;
              /*@editable*/font-family:Helvetica;
              /*@editable*/font-size:11px;
              /*@editable*/line-height:125%;
              /*@editable*/text-align:left;
            }
          /*
          @tab Preheader
          @section preheader link
          @tip Set the styling for your emails header links. Choose a color that helps them stand out from your text.
          */
            .preheaderContainer .mcnTextContent a{
              /*@editable*/color:#606060;
              /*@editable*/font-weight:normal;
              /*@editable*/text-decoration:underline;
            }
          /*
          @tab Header
          @section header style
          @tip Set the background color and borders for your emails header area.
          */
            #templateHeader{
              /*@editable*/background-color:#FFFFFF;
              /*@editable*/border-top:0;
              /*@editable*/border-bottom:0;
            }
          /*
          @tab Header
          @section header text
          @tip Set the styling for your emails header text. Choose a size and color that is easy to read.
          */
            .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
              /*@editable*/color:#606060;
              /*@editable*/font-family:Helvetica;
              /*@editable*/font-size:15px;
              /*@editable*/line-height:150%;
              /*@editable*/text-align:left;
            }
          /*
          @tab Header
          @section header link
          @tip Set the styling for your emails header links. Choose a color that helps them stand out from your text.
          */
            .headerContainer .mcnTextContent a{
              /*@editable*/color:#6DC6DD;
              /*@editable*/font-weight:normal;
              /*@editable*/text-decoration:underline;
            }
          /*
          @tab Body
          @section body style
          @tip Set the background color and borders for your emails body area.
          */
            #templateBody{
              /*@editable*/background-color:#FFFFFF;
              /*@editable*/border-top:0;
              /*@editable*/border-bottom:0;
            }
          /*
          @tab Body
          @section body text
          @tip Set the styling for your emails body text. Choose a size and color that is easy to read.
          */
            .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
              /*@editable*/color:#606060;
              /*@editable*/font-family:Helvetica;
              /*@editable*/font-size:15px;
              /*@editable*/line-height:150%;
              /*@editable*/text-align:left;
            }
          /*
          @tab Body
          @section body link
          @tip Set the styling for your emails body links. Choose a color that helps them stand out from your text.
          */
            .bodyContainer .mcnTextContent a{
              /*@editable*/color:#6DC6DD;
              /*@editable*/font-weight:normal;
              /*@editable*/text-decoration:underline;
            }
          /*
          @tab Footer
          @section footer style
          @tip Set the background color and borders for your emails footer area.
          */
            #templateFooter{
              /*@editable*/background-color:#FFFFFF;
              /*@editable*/border-top:0;
              /*@editable*/border-bottom:0;
            }
          /*
          @tab Footer
          @section footer text
          @tip Set the styling for your emails footer text. Choose a size and color that is easy to read.
          */
            .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
              /*@editable*/color:#606060;
              /*@editable*/font-family:Helvetica;
              /*@editable*/font-size:11px;
              /*@editable*/line-height:125%;
              /*@editable*/text-align:left;
            }
          /*
          @tab Footer
          @section footer link
          @tip Set the styling for your emails footer links. Choose a color that helps them stand out from your text.
          */
            .footerContainer .mcnTextContent a{
              /*@editable*/color:#606060;
              /*@editable*/font-weight:normal;
              /*@editable*/text-decoration:underline;
            }
          @media only screen and (max-width: 480px){
            body,table,td,p,a,li,blockquote{
              -webkit-text-size-adjust:none !important;
            }

        } @media only screen and (max-width: 480px){
            body{
              width:100% !important;
              min-width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            td[id=bodyCell]{
              padding:10px !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnTextContentContainer]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnBoxedTextContentContainer]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcpreview-image-uploader]{
              width:100% !important;
              display:none !important;
            }

        } @media only screen and (max-width: 480px){
            img[class=mcnImage]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnImageGroupContentContainer]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageGroupContent]{
              padding:9px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageGroupBlockInner]{
              padding-bottom:0 !important;
              padding-top:0 !important;
            }

        } @media only screen and (max-width: 480px){
            tbody[class=mcnImageGroupBlockOuter]{
              padding-bottom:9px !important;
              padding-top:9px !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
              width:100% !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
              padding-right:18px !important;
              padding-left:18px !important;
              padding-bottom:0 !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardBottomImageContent]{
              padding-bottom:9px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardTopImageContent]{
              padding-top:18px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
              padding-right:18px !important;
              padding-left:18px !important;
              padding-bottom:0 !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardBottomImageContent]{
              padding-bottom:9px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnImageCardTopImageContent]{
              padding-top:18px !important;
            }

        } @media only screen and (max-width: 480px){
            table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
              padding-top:9px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
              padding-top:18px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnBoxedTextContentColumn]{
              padding-left:18px !important;
              padding-right:18px !important;
            }

        } @media only screen and (max-width: 480px){
            td[class=mcnTextContent]{
              padding-right:18px !important;
              padding-left:18px !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section template width
          @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesnt work for you, set the width to 300px instead.
          */
            table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
              /*@tab Mobile Styles
        @section template width
        @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesnt work for you, set the width to 300px instead.*/max-width:600px !important;
              /*@editable*/width:100% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section heading 1
          @tip Make the first-level headings larger in size for better readability on small screens.
          */
            h1{
              /*@editable*/font-size:24px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section heading 2
          @tip Make the second-level headings larger in size for better readability on small screens.
          */
            h2{
              /*@editable*/font-size:20px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section heading 3
          @tip Make the third-level headings larger in size for better readability on small screens.
          */
            h3{
              /*@editable*/font-size:18px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section heading 4
          @tip Make the fourth-level headings larger in size for better readability on small screens.
          */
            h4{
              /*@editable*/font-size:16px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section Boxed Text
          @tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
          */
            table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
              /*@editable*/font-size:18px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section Preheader Visibility
          @tip Set the visibility of the emails preheader on small screens. You can hide it to save space.
          */
            table[id=templatePreheader]{
              /*@editable*/display:block !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section Preheader Text
          @tip Make the preheader text larger in size for better readability on small screens.
          */
            td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
              /*@editable*/font-size:14px !important;
              /*@editable*/line-height:115% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section Header Text
          @tip Make the header text larger in size for better readability on small screens.
          */
            td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
              /*@editable*/font-size:18px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section Body Text
          @tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
          */
            td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
              /*@editable*/font-size:18px !important;
              /*@editable*/line-height:125% !important;
            }

        } @media only screen and (max-width: 480px){
          /*
          @tab Mobile Styles
          @section footer text
          @tip Make the body content text larger in size for better readability on small screens.
          */
            td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
              /*@editable*/font-size:14px !important;
              /*@editable*/line-height:115% !important;
            }

        } @media only screen and (max-width: 480px){
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

                                  <p>Esqueceu sua senha '.$nome.'?<br>
                                  <p>O Encontro de Saberes recebeu uma solicitação para redefinir a senha da sua conta.</p>
                                  <p>Para redefinir sua senha, clique no link abaixo (ou copie e cole no seu navegador):
                                  <p><a href="http://encontrodesaberes.ufop.br/recuperar_senha.php?token='.$email_criptografado.'&cpf='.$cpf.'">http://encontrodesaberes.ufop.br/recuperar_senha.php?token='.$email_criptografado.'&cpf='.$cpf.'</a></p>
                                 
                                  <p>Atenciosamente,</p>
                                  <p>Encontro de SabereS</p>
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

        $mensagem_text = 'Esqueceu sua senha '.$nome.'?
                           O Encontro de Saberes recebeu uma solicitação para redefinir a senha da sua conta.
                           Para redefinir sua senha, copie e cole o link abaixo no seu navegador:
                           http://encontrodesaberes.ufop.br/recuperar_senha.php?token='.$email_criptografado.'     
                           Atenciosamente,
                           Encontro de Saberes';


        $url = 'https://api.sendgrid.com/';
        $user = 'encontrosaberes';
        $pass = 'se2015ic';


        $json_string = array(

          'category' => 'Recuperar Senha'
        );


        $params = array(
            'api_user'  => $user,
            'api_key'   => $pass,
            'x-smtpapi' => json_encode($json_string),
            'to'        => $email,
            'subject'   => 'Encontro de Saberes - Redefinir Senha',
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
                    'cpf_destinatario'=>$cpf,
                    'nome_destinatario'=>$nome,
                    'email_destinatario'=>$email,
                    'categoria'=> 'Recuperar Senha',
                    'assunto'=>'Encontro de Saberes - Redefinir Senha',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));
        $db->inserir('es_comunicacao_email', $dados_email);

        if($email_alternativo){

          $url = 'https://api.sendgrid.com/';
        $user = 'encontrosaberes';
        $pass = 'se2015ic';


        $json_string = array(

          'category' => 'Recuperar Senha'
        );


        $params = array(
            'api_user'  => $user,
            'api_key'   => $pass,
            'x-smtpapi' => json_encode($json_string),
            'to'        => $email_alternativo,
            'subject'   => 'Encontro de Saberes - Redefinir Senha',
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
          
        }

        echo '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Atenção</h4>
                Foi enviado um e-mail para redefinir sua senha. Aguarde você será redirecionado para a pagina de login.
                </div>
                <meta http-equiv=refresh content=4;URL=login.php />';
      }

      switch($tipo){
        case 'email':
          enviar_email($cpf, $db);
        break;
        case 'sms':
          enviar_sms($cpf, $db);
        break;
        default:
          $token = base64_decode($_GET['token']);
          $sql = "SELECT * FROM es_inscritos WHERE email = ?";
          $dados = array('email' => $token);
          $query = $db->sql_query($sql, $dados);
          foreach ($query as $registro) {
            $cpf = $registro->cpf;
          }

          echo '
          <form action="javascript:void(0)"  id="recuperar_senha" name="recuperar_senha">
            <div class="modal fade" id="myModal" role="dialog"></div>
            <div class="row" style="text-align:center; margin: 0 auto; width:30%;">
              <div class="form-group col-md-12">
                <label for="senha">Digite sua nova senha</label>
                <input type="password" class="form-control"  id="senha" minlength="8" name ="senha">
                <p class="help-block"></p>
              </div>
              <div class="form-group col-md-12">
                <label for="csenha">Digite novamente sua senha</label>
                <input type="password" class="form-control"  id="csenha" name ="csenha">
                <p class="help-block"></p>
              </div>
              <div class="form-actions col-md-12" style="background: #fff;">
                <button class="btn btn-primary btn-large pull-left" id="button_enviar" type="submit">Enviar</button>
              </div>
            </div>
          </form>
        <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
          var $validator = $("#recuperar_senha").validate({
            rules: {
                senha: { required: true },
                csenha: { required: true, equalTo: "#senha" }
            }
          });
        });
          
        $("#button_enviar").click(function() {
            var senha = $("#senha").val();
          $.post("envia_senha.php", {cpf: "'.$cpf.'", senha: senha},
            function(resposta) {
              if (resposta != false) {
                 BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: "Sucesso",
                    message: "Sua senha foi alterada com sucesso.",
                    buttons: [{
                        label: "Fazer Login",
                        cssClass: "btn-primary",
                        icon: "glyphicon glyphicon-lock",
                        action: function(){
                           window.location="login.php";
                         }
                       }]
                     });
              } 
              else {
                  BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: "Erro",
                    message: "Aconteceu um erro ao tentar atualizar sua senha",
                    buttons: [{
                        label: "Fazer Login",
                        cssClass: "btn-primary",
                        icon: "glyphicon glyphicon-lock",
                        action: function(){
                           window.location="login.php";
                         }
                       }]
                     });
              }
            });
        });

        </script>'; 
        break;
      }


    	?>
       



      </div>

    </div>

  </div>


  
  <?php  include ("footer.php");

}
?>