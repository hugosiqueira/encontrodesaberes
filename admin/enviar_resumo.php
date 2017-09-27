<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {

  foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

    try {
      if($fgk_status == TRABALHO_SUBMETIDO){
        $datahora_submissao = date('Y-m-d H:i:s');
      } else {
        $datahora_submissao = NULL;
      }
	  
	  $verifica_qtd_trabalho_categoria = verificaTrabInscrito($db, CPF_USUARIO, $categoria, EVENTO_ATUAL);
		if($verifica_qtd_trabalho_categoria > 0){
			echo "Prezado(a) ".NOME_USUARIO.", você já submeteu um trabalho neste evento, não é permitido adicionar mais trabalhos.";
			exit();
		}
		
		$verifica_trabalho_repetido =  verificaTrabNome($db, $titulo, CPF_USUARIO, EVENTO_ATUAL, $categoria);
		if($verifica_trabalho_repetido > 0){
			echo "Prezado(a) ".NOME_USUARIO.", você já é autor de um trabalho com o mesmo nome e não é aceito trabalhos repetidos.";
			exit();
		}

    switch ($categoria) {
    //Mostra Pró-Ativa
    case 3:
      $area = 6;
      $area_especifica = 96;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      $programa_ic = 0;
      break;

    // Mostra Monitoria
    case 6:
      $area = 9;
      $area_especifica = 107;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      $programa_ic = 0;
      break;

    //Mostra PIBID
    case 7:
      $area = 10;
      $area_especifica = 105;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL;
      $programa_ic = 0; 
      break;

    //Mostra PET
    case 8:
      $area = 11;
      $area_especifica = 106;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL;
      $programa_ic = 0;
      break;

      //Mostra Material Didático
    case 10:
      $area = 13;
      $area_especifica = 117;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      $programa_ic = 0;
      break;

    case 2:
     $area = 7;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      $programa_ic = 0;
      break;
  }

  $apoio_financeiro = (isset($apoio_financeiro)) ? $apoio_financeiro : NULL ;

      $dados = array(
      'fgk_status' => $fgk_status,
      'fgk_area' => $area,
	   'fgk_categoria' => $categoria, 
      'fgk_area_especifica' => $area_especifica,
      'palavras_chave' => $palavras_chave,
      'resumo_enviado' => $resumo_enviado,
      'titulo_enviado' => $titulo,
      'fgk_inscrito_responsavel' => ID_USUARIO,
      'fgk_orgao_fomento' =>$orgao_fomento,
      'datahora_ultima_atualizacao' => date('Y-m-d H:i:s'),
      'datahora_submissao' => $datahora_submissao,
	  'apoio_financeiro' => $apoio_financeiro, 
	  'protocolo_cep' => $protocolo_cep,
	  'protocolo_ceua' => $protocolo_ceua,
    'fgk_programa_ic' =>$programa_ic

      );
      
      if($db->atualizar('es_trabalho', $dados, 'id', $id_trabalho)) {
        if($fgk_status == TRABALHO_SUBMETIDO){
          $sel_autores = $db->sql_query("SELECT nome, email FROM es_trabalho_autor WHERE fgk_trabalho =?", array('fgk_trabalho'=>$id_trabalho));
          foreach ($sel_autores as $autores) {
           

            $mensagem = 'Prezado(a) '.$autores->nome.',
                         <h3>Trabalho submetido.</h3>
						<p>Prezado(a) '.$autores->nome.',<br>
						<p>Recebemos o resumo do seu trabalho científico,'.$titulo.', para o Encontro de Saberes. </p>
						<p>Fique atento aos prazos para edição do trabalho em sua área restrita no site. </p>
						<p>Detalhes do trabalho:</p>
						<p><strong>Trabalho Submetido por:</strong>'.NOME_USUARIO.'</p>
						<p><strong>Título: </strong> '.$titulo.'</p>
						<p><strong>Palavras-chave: </strong>'.$palavras_chave.'</p>
						<p><strong>Resumo: </strong>'.$resumo_enviado.'</p>
						<p>Atenciosamente,</p>
						<p>Encontro de Saberes</p>';

            $enviar_email = envia_email( SENDGRID_API_KEY, $autores->email, "Encontro de Saberes - Trabalho submetido", $mensagem, 'Trabalho Submetido', $remetente="encontrodesaberes@ufop.br" );

            if(!$enviar_email){
              echo "Houve um erro ao enviar o e-mail de confirmação.";
              exit;
            }
          }
        }
        

        echo "sucesso";
      } else 
        echo "Desculpe houve um erro ao atualizar o seu trabalho.";
      
      

    } catch(PDOException $e) {
      echo $e->getMessage();

    }
}




