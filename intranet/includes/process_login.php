<?php
require_once("C:/xampp/htdocs/config.php");
require_once 'functions.php';

sec_session_start(); // Nossa segurança personalizada para iniciar uma sessão php.

if (isset($_POST['login'], $_POST['p'])) {
    $login = $_POST['login'];
    $password = $_POST['p'];
    if (login($login, $password, $db) == true) {
           header('Location: ../desktop.php');
    } else {
       	header('Location: ../index.php');
		// echo $_SESSION['login_string']."<br>";
		// echo $_SESSION['teste_pass'];
    }
} else {
    // As variáveis POST corretas não foram enviadas para esta página.
    echo 'Invalid Request';
}