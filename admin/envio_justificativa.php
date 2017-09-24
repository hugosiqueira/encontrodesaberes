<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
include ("../../config.php");


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}
$datahora_registro = date('Y-m-d H:i:s');
$buscar_orientador = $db->sql_query("SELECT id FROM es_trabalho_autor WHERE fgk_tipo_autor = ? AND fgk_trabalho = ?", array('fgk_tipo_autor'=>2, 'fgk_trabalho'=>$id_trabalho));
    foreach ($buscar_orientador as $orientador) {
        $id_autor = $orientador->id;
    }

  try {
      
        $dados = array(
            'fgk_trabalho' => $id_trabalho,
            'fgk_autor' => $id_autor,
            'descricao' =>$justificativa,
            'datahora_registro' =>$datahora_registro
        );

        $stmt = $db->inserir('es_trabalho_justificativa', $dados); 
        $stmt2 = $db->atualizar('es_trabalho', array('fgk_status'=>10), 'id', $id_trabalho);

        if(!$stmt){
          echo "erro";
          exit();
        }    

            echo "sucesso";

  } catch(PDOException $e) {
    echo $e->getMessage();

  }
}




