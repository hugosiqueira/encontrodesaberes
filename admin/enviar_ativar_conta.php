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


$mensagem = '<h3>Sua conta não está ativada.</h3>
            <p>Prezado(a) '.$nome.',<br>

            <p>Sua conta no sistema do Encontro de Saberes não foi ativada para realizar a ativação da mesma e continuar tendo acesso. Favor clicar no link abaixo ou copie e cole em seu navegador.</p>

            <p><a href="http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'">http://encontrodesaberes.ufop.br/ativar_conta.php?token='.$email_criptografado.'</a></p>

            <p>Atenciosamente,</p>

            <p>Encontro de Saberes</p>';
            if(!envia_email( $sendgrid_apikey, $_SESSION['email'], "Encontro de Saberes - Ativar conta", $mensagem, "Ativar Conta", $remetente="encontrodesaberes@ufop.br" )){
              echo "Erro ao enviar o e-mail";
            }

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

  if(!envia_email( $sendgrid_apikey, $_SESSION['email_alternativo'], "Encontro de Saberes - Ativar conta", $mensagem, "Ativar Conta", $remetente="encontrodesaberes@ufop.br" )){
              echo "Erro ao enviar o e-mail";
            }


}
echo "sucesso";


