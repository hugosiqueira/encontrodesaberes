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

$id_autor = filter_input(INPUT_GET, 'id');
$id_trabalho = filter_input(INPUT_GET, 'id_trabalho');

$excluir_trabalho = $db->excluir("es_trabalho_autor", 'id', $id_autor);

header("location: exibir_trabalho.php?id=".$id_trabalho);



}