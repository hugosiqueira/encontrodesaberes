<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
    include "../../config.php";
    include "/home/encontrosaberes/encontrodesaberes.ufop.br/includes/_BrasbipClass.php";
    $sql = "SELECT * FROM es_inscritos WHERE cpf = ?";
    $dados = array('cpf' => $_GET['cpf'] );
    $query = $db->sql_query($sql, $dados);
    if($query){
        foreach ($query as $registro) {
        $nome= $registro->nome;
        $telefone_celular = "55".preg_replace("/[^0-9\s]/", "",$registro->telefone_celular);
        $cod_ativacao = rand(10000, 99999);
    }
        $atualizar = $db->atualizar('es_inscritos', array('cod_recuperacao_sms'=>$cod_ativacao), 'cpf', $_GET['cpf']);
        $sender = "SEIC";
        $nome = substr($nome, 0, strpos($nome, ' '));
        $sender = str_replace("+","%2b",$sender);

        $messagetext=$nome.", segue o codigo para ativação da conta do encontro de saberes:".$cod_ativacao;

        $sendSMS = new BrasbipSMS();
        $resposta = $sendSMS->enviaSMS("seic_sms","se2015ic",$sender,$messagetext,0, $telefone_celular, "longSMS", "");
        if($resposta)
          echo "sucesso";
        else
          echo "erro";
  } else {
    echo "Erro na query";
  }
    
  }