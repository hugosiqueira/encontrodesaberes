<?php
include ("../../config.php");

try {
    foreach ($_GET as $campo => $valor) { $$campo = trim(strip_tags($valor));}
    foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}
    $dados = array('cpf'=> $cpf);
    $aluno = $db->existe('es_ufop_alunos', $dados);
    
    if($aluno){
		echo "aluno";

    } else if($db->existe('es_trabalho_autor', array('cpf'=> $cpf, 'fgk_trabalho'=>$id_trabalho))){
		echo "existe";
	} else {
		echo "externo";
	}


} catch(PDOException $e) {
  echo $e->getMessage();

}




