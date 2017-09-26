<?php



$email_criptografado = base64_encode($email);

$mensagem ='<h1>Bem-vindo</h1>



<h3>Cadastro efetuado com sucesso!</h3>



<p>Prezado(a) '.$nome.',<br>

<p>Sua nova conta no sistema do Encontro de Saberes foi criada com sucesso e você precisa agora realizar a ativação da mesma para continuar tendo acesso. Favor clicar no link abaixo ou copie e cole em seu navegador.</p>

<p><a href="http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'">http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'</a>

<p> Lembramos que para efetivar a sua participação no evento, você deverá efetuar o pagamento do boleto até a data de vencimento. Caso já queira efetuar o pagamento, clique no link abaixo para gerar o seu boleto:</p>

<p> <a href="'.$link.'" target="_blank">'.$link.'</a></p> 

<p>O participante que se cadastrou no sistema e submeteu o trabalho não poderá realizar a apresentação do seu trabalho no evento se não efetivar o pagamento da inscrição. Por isso, não se esqueça de efetuar o pagamento no prazo.</p>

<p>Atenciosamente,</p>

<p>Encontro de Saberes</p>';

$mensagem_text = '<h1>Bem-vindo</h1>



<h3>Cadastro efetuado com sucesso!</h3>



<p>Prezado(a) '.$nome.',<br>

<p>Sua nova conta no sistema do Encontro de Saberes foi criada com sucesso e você precisa agora realizar a ativação da mesma para continuar tendo acesso. Favor clicar no link abaixo ou copie e cole em seu navegador.</p>

<p><a href="http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'">http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'</a>

<p> Lembramos que para efetivar a sua participação no evento, você deverá efetuar o pagamento do boleto até a data de vencimento. Caso já queira efetuar o pagamento, clique no link abaixo para gerar o seu boleto:</p>

<p> <a href="'.$link.'" target="_blank">'.$link.'</a></p> 

<p>O participante que se cadastrou no sistema e submeteu o trabalho não poderá realizar a apresentação do seu trabalho no evento se não efetivar o pagamento da inscrição. Por isso, não se esqueça de efetuar o pagamento no prazo.</p>

<p>Atenciosamente,</p>

<p>Encontro de Saberes</p>';



/*$url = 'https://api.sendgrid.com/';

$user = 'encontrosaberes';

$pass = 'se2015ic';



$json_string = array(

  'category' => 'Cadastro'

);



$params = array(

    'api_user'  => $user,

    'api_key'   => $pass,

    'x-smtpapi' => json_encode($json_string),

    'to'        => $email,

    'subject'   => 'Bem-vindo ao Encontro de Saberes',

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

                    'cpf_destinatario'=>$cpf,

                    'nome_destinatario'=>$nome,

                    'email_destinatario'=>$email,

                    'categoria'=> 'Cadastro',

                    'assunto'=>'Bem-vindo ao Encontro de Saberes',

                    'corpo_email'=>$mensagem,

                    'datahora_envio'=>date('Y-m-d H:i:s'));



$db->inserir('es_comunicacao_email', $dados_email);



if($emaila){



$params = array(

    'api_user'  => $user,

    'api_key'   => $pass,

    'x-smtpapi' => json_encode($json_string),

    'to'        => $emaila,

    'subject'   => 'Bem-vindo ao Encontro de Saberes',

    'html'      => $mensagem,

    'text'      => $mensagem_text,

    'from'      => 'encontrodesaberes@ufop.br'

  );



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

/*



//echo $mensagem;