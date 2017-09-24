<?php

$cpf = $_POST['cpf'];
$codigo = $_POST['codigo'];
  include ("../config.php");
  $query = $db->existe( "es_inscritos", array("cpf" => $cpf, "cod_recuperacao_sms"=> $codigo));
  if($query)
    echo"true";
  else
    return false;





