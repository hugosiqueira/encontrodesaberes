<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if($_SESSION['logado'] == true){
  $nome = $_SESSION['nome_usuario'];
  $cpf = $_SESSION['cpf'];
  $email = $_SESSION['email'];
}
$email_criptografado = base64_encode($_SESSION['email']);
$mensagem ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- NAME: 1 COLUMN -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Encontro de Saberes </title>
</head>
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


                                    <img alt="" src="http://encontrodesaberes.com.br/img/68a160f7-3e24-4a77-a30b-f61ae3319e94.png" style="max-width:750px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="left" width="564">
                                    

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

                                    <h3>Sua conta não está ativada.</h3>

                                    <p>Prezado(a) '.$nome.',<br>
                                    <p>Sua conta no sistema do Encontro de Saberes não foi ativada para realizar a ativação da mesma e continuar tendo acesso. Favor clicar no link abaixo ou copie e cole em seu navegador.</p>
                                    <p><a href="http://encontrodesaberes.com.br/ativar_conta.php?token='.$email_criptografado.'">http://encontrodesaberes.com.br/ativar_conta.php?token='.$email_criptografado.'</a></p>
                                    <p>Atenciosamente,</p>
                                    <p>Encontro de Saberes </p>
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
$mensagem_text = '<h3>Sua conta não está ativada.</h3>

                                    <p>Prezado(a) '.$nome.',<br>
                                    <p>Sua conta no sistema do Encontro de Saberes não foi ativada para realizar a ativação da mesma e continuar tendo acesso. Favor clicar no link abaixo ou copie e cole em seu navegador.</p>
                                    <p><a href="http://encontrodesaberes.com.br/ativar_conta.php?token='.$email_criptografado.'">http://encontrodesaberes.com.br/ativar_conta.php?token='.$email_criptografado.'</a></p>
                                    <p>Atenciosamente,</p>
                                    <p>Encontro de Saberes</p>';
	/*								
								include '../plugins/Mailin.php';
$mailin = new Mailin('encontrodesaberes2017@gmail.com', 'mN2pkYnr8DTtsExC');
$mailin->
	addTo($_SESSION['email'], 'Encontro de Saberes 2017')->
	setFrom('encontrodesaberes@ufop.br', 'Encontro de Saberes 2017')->
	setReplyTo('encontrodesaberes2017@gmail.com','Encontro de Saberes 2017')->
	setSubject('Encontro de Saberes - Ativar conta')->
	setText($mensagem_text)->
	setHtml($mensagem);
$res = $mailin->send();
	*/						
									
require '../includes/sendgrid-php/vendor/autoload.php';
/*$request = new HttpRequest();
$request->setUrl('https://api.sendgrid.com/v3/mail/send');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'content-type' => 'application/json',
  'authorization' => 'Bearer <<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>>'
));

$request->setBody('{"personalizations":[{"to":[{"email":'.$_SESSION["email"].',"name":'.$nome.'}],"subject":"Encontro de Saberes: Ative sua conta!"}],"from":{"email":"encontrodesaberes@ufop.br","name":"Encontro de Saberes"},"reply_to":{"email":"encontrodesaberes@ufop.br","name":"Encontro de Saberes"},"subject":"Encontro de Saberes: Ative sua conta!","content":[{"type":"text/html","value":'.$mensagem.'}]}');

try {
  $response = $request->send();
echo "sucesso";
  //echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}

$sendgrid = new SendGrid("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");
$email    = new SendGrid\Email();

$email->addTo($_SESSION["email"])
      ->setFrom("encontrodesaberes@ufop.br")
      ->setSubject("Encontro de Saberes - Ativar conta")
      ->setHtml($mensagem);

$sendgrid->send($email);
*/
$url = 'https://api.sendgrid.com/';
$user = 'encontrosaberes';
$pass = 'se2015ic';

$json_string = array(
  'category' => 'Ativar Conta'
);


$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'x-smtpapi' => json_encode($json_string),
    'to'        => $_SESSION['email'],
    'subject'   => 'Encontro de Saberes - Ativar conta',
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
@curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);


curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);
echo "sucesso";
$dados_email= array('fgk_evento'=>EVENTO_ATUAL,
                    'cpf_destinatario'=>$cpf,
                    'nome_destinatario'=>$nome,
                    'email_destinatario'=>$email,
                    'categoria'=> 'Ativar Conta',
                    'assunto'=>'Encontro de Saberes - Ativar Conta',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));
$db->inserir('es_comunicacao_email', $dados_email);

if($_SESSION['email_alternativo']){
  $url = 'https://api.sendgrid.com/';
$user = 'encontrosaberes';
$pass = 'se2015ic';

$json_string = array(
  'category' => 'Ativar Conta'
);


$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'x-smtpapi' => json_encode($json_string),
    'to'        => $_SESSION['email_alternativo'],
    'subject'   => 'Encontro de Saberes - Ativar conta',
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

