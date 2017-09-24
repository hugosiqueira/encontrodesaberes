<?php


include ("../config.php");
function recupera($cpf){
  $db = new PdoDB(
	DB_DSN,
	DB_USERNAME,
	DB_PASSWORD,
	DB_CHARACSET
);
  $sql = "SELECT * FROM es_inscritos WHERE cpf = ? AND fgk_evento = ? AND bool_temp = ? ";
  $query = $db->sql_query( $sql, array("cpf" => $cpf, 'fgk_evento' => EVENTO_ATUAL, 'bool_temp'=>0));

  $arr = Array();

  foreach ($query as $aluno) {
    $arr['celular_mascara'] = strstr($aluno->telefone_celular, '-', true)."****";
    $arr['email_mascara']  = strstr($aluno->email, '@', true)."**********";
    $arr['cpf'] = $aluno->cpf;

  }
  return json_encode( $arr );
}

try {
    foreach ($_GET as $campo => $valor) { $$campo = trim(strip_tags($valor));}
    $dados = array('cpf'=> $cpf, 'bool_temp' => 0);
    $login = $db->existe('es_inscritos', $dados);
    
    if($login){
     echo  recupera($cpf);
      exit();
    }


} catch(PDOException $e) {
  echo $e->getMessage();

}




