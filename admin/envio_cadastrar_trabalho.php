<?php
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
//include ("../../config.php");


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

try {
    $db->iniciar_transacao();
    if($fgk_status == TRABALHO_SUBMETIDO){
      $datahora_submissao = date('Y-m-d H:i:s');
    } else {
      $datahora_submissao = NULL;
    }
	
	if (!$tipo_autor_responsavel){
		echo "Preencha o tipo do autor.";
		exit();
	} 
	
	$verifica_qtd_trabalho_categoria = verificaTrabInscrito($db, ID_USUARIO, $categoria, EVENTO_ATUAL);
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
      break;

    // Mostra Monitoria
    case 6:
      $area = 9;
      $area_especifica = 107;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      break;

    //Mostra PIBID
    case 7:
      $area = 10;
      $area_especifica = 105;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      break;

    //Mostra PET
    case 8:
      $area = 11;
      $area_especifica = 106;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      break;

    //Mostra Material Didático
    case 10:
      $area = 13;
      $area_especifica = 117;
      $orgao_fomento = 368;
      $protocolo_cep = NULL;
      $protocolo_ceua = NULL; 
      break;
  }

  $apoio_financeiro = (isset($apoio_financeiro)) ? $apoio_financeiro : NULL ;
  $programa_ic = (isset($programa_ic)) ? $programa_ic : NULL ;

    $dados = array(
    'fgk_area' => $area,
    'fgk_area_especifica' => $area_especifica,
    'fgk_evento' => EVENTO_ATUAL, 
    'fgk_orgao_fomento' => $orgao_fomento,
    'fgk_inscrito_responsavel' => ID_USUARIO,
    'fgk_categoria' => $categoria, 
	'fgk_instituicao' => INSTITUICAO_USUARIO, 
    'fgk_tipo_apresentacao' => 1,
    'apresentacao_obrigatoria' => 0,
    'palavras_chave' => $palavras_chave,
    'resumo_enviado' => $resumo_enviado,
    'titulo_enviado' => $titulo,
    'fgk_status'=> $fgk_status,
    'datahora_ultima_atualizacao' => date('Y-m-d H:i:s'),
    'datahora_submissao' => $datahora_submissao,
	'apoio_financeiro' => $apoio_financeiro, 
	'protocolo_cep' => $protocolo_cep,
	'protocolo_ceua' => $protocolo_ceua,
	'autorizacao_repositorio' => $autorizacao_repositorio,
  'fgk_programa_ic' => $programa_ic
	
    );
    
    $inserir = $db->inserir('es_trabalho', $dados);
    if(!$inserir){
        echo("Erro ao cadastrar trabalho.");
    }

    $trabalho = $db->sql_query("SELECT id FROM es_trabalho ORDER BY id DESC LIMIT 1");
    foreach ($trabalho as $key) {
        $fgk_trabalho = $key->id;
    }
	
	
		
    $dados_autor_responsavel = array(
        'fgk_instituicao' => INSTITUICAO_USUARIO,
        'fgk_trabalho' => $fgk_trabalho,
        'fgk_tipo_autor' => $tipo_autor_responsavel,
        'cpf' => CPF_USUARIO,
        'nome' => NOME_USUARIO,
        'email' => EMAIL_USUARIO,
        'ordenacao' => 1,
        'bool_apresentador' => $apresentador_responsavel
        );
	
    $inserir_autor = $db->inserir('es_trabalho_autor', $dados_autor_responsavel);
	if(!$inserir_autor){
         $db->reverter();
         echo ("Erro ao cadastrar autores");
    }
	if($qtdautor >0){
		for ($i = 1; $i <= $qtdautor; $i++){
			$instituicao_autor = "instituicao_autor".$i;
			$tipo_autor = "tipo_autor".$i;
			$cpf_autor = "cpf_autor".$i;
			$nome_autor = "nome_autor".$i;
			$email_autor = "email_autor".$i;
			$apresentador = "apresentador".$i;
			
			if(!$instituicao_autor){
				echo "Preencha a instituição do autor";
				exit();
			} else if (!$fgk_trabalho){
				echo "Faltando o campo que identifica o trabalho. Favor comunicar ao suporte.";
				exit();
			} else if (!$$tipo_autor){
				echo "Preencha o tipo do autor.";
				exit();
			} else if (!$$cpf_autor){
				echo "Faltando o cpf do autor.";
				exit();
			} else if (!$$nome_autor){
				echo "Faltando o nome do autor.";
				exit();
			} else if (!$$email_autor){
				echo "Faltando o email do autor.";
				exit();
			} 

			$dados_autor = array(
			'fgk_instituicao' => $$instituicao_autor,
			'fgk_trabalho' => $fgk_trabalho,
			'fgk_tipo_autor' => $$tipo_autor,
			'cpf' => $$cpf_autor,
			'nome' => $$nome_autor,
			'email' => $$email_autor,
			'ordenacao' => ($i+1),
			'bool_apresentador' => $$apresentador
			);
			
			

			$inserir_autor = $db->inserir('es_trabalho_autor', $dados_autor);
		}
		if(!$inserir_autor){
			 $db->reverter();
			 die("Erro ao cadastrar autores");
		}
	}

    
    
    if($fgk_status == TRABALHO_SUBMETIDO){
        $sel_autores = $db->sql_query("SELECT nome, email, cpf FROM es_trabalho_autor WHERE fgk_trabalho =?", array('fgk_trabalho'=>$fgk_trabalho));
        foreach ($sel_autores as $autores) {
            
            $mensagem = '<h3>Trabalho submetido.</h3>
                                    <p>Prezado(a) '.$autores->nome.',<br>
                                    <p>Recebemos o resumo do seu trabalho científico,'.$titulo.', para o Encontro de Saberes UFOP. </p>
                                    <p>Fique atento aos prazos para edição do trabalho em sua área restrita no site. </p>
                                    <p>Detalhes do trabalho:</p>
                                    <p><strong>Trabalho Submetido por:</strong>'.NOME_USUARIO.'</p>
                                    <p><strong>Título: </strong> '.$titulo.'</p>
                                    <p><strong>Palavras-chave: </strong>'.$palavras_chave.'</p>
                                    <p><strong>Resumo: </strong>'.$resumo_enviado.'</p>
                                    <p>Atenciosamente,</p>
                                    <p>Encontro de Saberes</p>';
            $mensagem_text = 'Prezado(a) '.$autores->nome.',
                         Recebemos o resumo do seu trabalho científico,'.$titulo.', para o Encontro de Saberes UFOP.
                        Fique atento aos prazos para edição do trabalho em sua área restrita no site.
                        Detalhes do trabalho:</p>
						<p><strong>Trabalho Submetido por:</strong>'.NOME_USUARIO.'</p>
                        Título: '.$titulo.'
                        Palavras-chave: '.$palavras_chave.'
                        Resumo: '.$resumo_enviado.'
                        Atenciosamente,
                        Encontro de Saberes';
            if(!envia_email( SENDGRID_API_KEY, $autores->email, "Encontro de Saberes - Trabalho submetido", $mensagem, "Trabalho Submetido", $remetente="encontrodesaberes@ufop.br" )){
              echo "Erro ao enviar o e-mail";
            }
            

           /* $url = 'https://api.sendgrid.com/';
            $user = 'encontrosaberes';
            $pass = 'se2015ic';

            $json_string = array(
              'category' => 'Trabalho Submetido'
            );


            $params = array(
                'api_user'  => $user,
                'api_key'   => $pass,
                'x-smtpapi' => json_encode($json_string),
                'to'        => $autores->email,
                'subject'   => 'Encontro de Saberes - Trabalho submetido',
                'html'      => $mensagem,
                'text'      => $mensagem_text,
                'from'      => 'encontrodesaberes@ufop.br'
              );


            $request =  $url.'api/mail.send.json';

            // Generate curl request
            $session = curl_init($request);
            // Tell curl to use HTTP POST
            curl_setopt ($session, CURLOPT_POST, true);
            // Tell curl that this is the body of the POST
            curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
            // Tell curl not to return headers, but do return the response
            curl_setopt($session, CURLOPT_HEADER, false);
            // Tell PHP not to use SSLv3 (instead opting for TLS)
            curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

            // obtain response
            $response = curl_exec($session);
            curl_close($session);*/

            $dados_email= array('fgk_evento'=>EVENTO_ATUAL,
                    'cpf_destinatario'=>$autores->cpf,
                    'nome_destinatario'=>$autores->nome,
                    'email_destinatario'=>$autores->email,
                    'categoria'=> 'Trabalho Submetido',
                    'assunto'=>'Encontro de Saberes - Trabalho submetido',
                    'corpo_email'=>$mensagem,
                    'datahora_envio'=>date('Y-m-d H:i:s'));
            $db->inserir('es_comunicacao_email', $dados_email);
        }
    }
    $db->commit();
    echo "sucesso";


  } catch(PDOException $e) {
    echo $e->getMessage();

  }
}