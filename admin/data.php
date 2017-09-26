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

foreach ($_GET as $campo => $valor) { $$campo = trim(strip_tags($valor));}

try {

    if(TIPO_USUARIO  == ADMINISTRADOR){
      if(isset($area_especifica)){ 
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
        FROM es_avaliacao_revisor
          LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
          LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
          WHERE es_area_especifica.descricao_area_especifica like ? 
          ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.fgk_area_especifica'=>'%'.$area_especifica.'%'));
        } else if(isset($id_departamento)){
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
          INNER JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
          INNER JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
          WHERE es_inscritos.fgk_departamento = ? 
          ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_inscritos.fgk_departamento'=>$id_departamento));
      } else{
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
        INNER JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
        INNER JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
        ';
        $stmt = $db->sql_query($query);
      }
        
    } else {
      if(AREA_COORDENACAO <= 5){
       if(isset($area_especifica) ){ 
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                  FROM es_avaliacao_revisor
                  LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                  LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                  WHERE es_area_especifica.descricao_area_especifica like ? AND es_avaliacao_revisor.fgk_area = ? 
                  ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.fgk_area_especifica'=>'%'.$area_especifica.'%',  'es_avaliacao_revisor.fgk_area'=>AREA_COORDENACAO));
        } else if(isset($id_departamento)){
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                    FROM es_avaliacao_revisor
                    LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.fgk_area = ? AND es_inscritos.fgk_departamento = ?
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array( 'es_avaliacao_revisor.fgk_area'=>AREA_COORDENACAO,'es_inscritos.fgk_departamento'=>$id_departamento));
        } else {
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                    left JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    left JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.fgk_area = ? 
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.fgk_area'=>AREA_COORDENACAO));
        }
      } else if(AREA_COORDENACAO == 6){
       if(isset($area_especifica) ){ 
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                  FROM es_avaliacao_revisor
                  LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                  LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                  WHERE  es_avaliacao_revisor.bool_avaliador_prograd = ? 
                  ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array(  'es_avaliacao_revisor.bool_avaliador_prograd'=>1));
        } else if(isset($id_departamento)){
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                    FROM es_avaliacao_revisor
                    LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_prograd = ? 
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array( 'es_avaliacao_revisor.bool_avaliador_prograd'=>1));
        } else {
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                    left JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    left JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_prograd = ? 
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.bool_avaliador_prograd'=>1));
        }

      } else if(AREA_COORDENACAO == 7){
       if(isset($area_especifica) ){ 
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                  FROM es_avaliacao_revisor
                  LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                  LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                  WHERE es_area_especifica.descricao_area_especifica like ? AND es_avaliacao_revisor.bool_avaliador_proex = ? 
                  ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.fgk_area_especifica'=>'%'.$area_especifica.'%',  'es_avaliacao_revisor.bool_avaliador_proex'=>1));
        } else if(isset($id_departamento)){
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                    FROM es_avaliacao_revisor
                    LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_proex = ? AND es_inscritos.fgk_departamento = ?
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array( 'es_avaliacao_revisor.bool_avaliador_proex'=>1,'es_inscritos.fgk_departamento'=>$id_departamento));
        } else {
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                    left JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    left JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_proex = ? 
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.bool_avaliador_proex'=>1));
        }

      } else if(AREA_COORDENACAO == 8){
       if(isset($area_especifica) ){ 
        $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                  FROM es_avaliacao_revisor
                  LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                  LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                  WHERE es_area_especifica.descricao_area_especifica like ? AND es_avaliacao_revisor.bool_avaliador_caint = ? 
                  ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.fgk_area_especifica'=>'%'.$area_especifica.'%',  'es_avaliacao_revisor.bool_avaliador_caint'=>1));
        } else if(isset($id_departamento)){
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor 
                    FROM es_avaliacao_revisor
                    LEFT JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    LEFT JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_caint = ? AND es_inscritos.fgk_departamento = ?
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array( 'es_avaliacao_revisor.bool_avaliador_caint'=>1,'es_inscritos.fgk_departamento'=>$id_departamento));
        } else {
          $query = 'SELECT nome,fgk_departamento, descricao_area_especifica, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                    left JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  
                    left JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                    WHERE es_avaliacao_revisor.bool_avaliador_caint = ? 
                    ORDER BY nome ASC';
          $stmt = $db->sql_query($query, array('es_avaliacao_revisor.bool_avaliador_caint'=>1));
        }

      }


    }

    foreach ($stmt as $registro) {
        $conta = $db->sql_query('SELECT COUNT(es_avaliacao.id) as total FROM es_avaliacao LEFT JOIN es_trabalho ON es_avaliacao.fgk_trabalho = es_trabalho.id WHERE fgk_evento = '.EVENTO_ATUAL.' AND (fgk_revisor1 = '.$registro->id_revisor.' OR fgk_revisor2 = '.$registro->id_revisor.')' );
        foreach ($conta as $key) {
            $total = $key->total;
        }
        $customers[] = array(
          'nome' => $registro->nome,
          'departamento'=> $registro->fgk_departamento,
          'total' => $total,
          'descricao_area_especifica' => $registro->descricao_area_especifica,
          'id_revisor'=> $registro->id_revisor
          );

      }

	
      echo @json_encode($customers);
    
    

} catch(PDOException $e) {
  echo $e->getMessage();

}
}




