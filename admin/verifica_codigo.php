<?php

$cpf = $_POST['cpf'];
$codigo = $_POST['codigo'];
  include ("../../config.php");
  $query = $db->existe( "es_inscritos", array("cpf" => $cpf, "cod_recuperacao_sms"=> $codigo));
  if($query){
  	$atualizar = $db->atualizar('es_inscritos', array('conta_ativada'=>1, 'bool_spam'=>1), 'cpf', $cpf);
    echo"sucesso";
  } else
    echo "false";





