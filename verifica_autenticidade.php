<?php
include ("../config.php");

foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}
try{
	$verifica_codigo = $db->existe('es_certificados', array('es_certificados.chave_autenticidade'=>$codigo));
	if($verifica_codigo){
		echo "sucesso";
	}
	else{
		echo "erro";
		exit();
	}
} catch(PDOException $e) {
    echo $e->getMessage();

  }
