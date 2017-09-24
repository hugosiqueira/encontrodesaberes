<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
// $_SESSION = array();
// session_destroy();

require_once '../../includes/functions.php';
require_once('../../includes/db_connect.php');

$data = json_decode($_POST['data']);	
$_SESSION['logado']       = true;
$_SESSION['nome_usuario'] = $data->nome;
$_SESSION['conta_ativada'] = $data->conta_ativada;
$_SESSION['email'] =  $data->email;
$_SESSION['email_alternativo'] = $data->email_alternativo;
$_SESSION['cpf'] = $data->cpf;
$_SESSION['id_inscrito'] = $data->id;
$_SESSION['area_coordenacao'] = $data->fgk_area_coordenacao;
$_SESSION['id_tipo_inscrito'] = $data->fgk_tipo;
$_SESSION['bool_monitoria'] = $data->bool_monitoria;
$last_login = $db->atualizar('es_inscritos',  array('last_login' => date('Y-m-d H:i:s') ), 'cpf', $data->cpf);

header('location: http://encontrodesaberes.com.br/admin/index.php');

// 

?>