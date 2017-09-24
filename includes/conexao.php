<?php
include ('../../config.php');

$pdo = new PDO(
    sprintf(
    'mysql:host=%s;dbname=%s;port=%s;charset=%s',
    $config['host'],
    $config['banco'],
    $config['porta'],
    $config['charset']
    ),
    $config['usuario'],
    $config['senha']
);