<?php
include ("../config.php");
require __DIR__.'/admin/vendor/autoload.php';
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}


  try {
	$today=date('Y-m-d');
	if($today > DATA_INSCRICAO_FIM || $today < DATA_INSCRICAO_INI){
		echo "Desculpe-nos, mas não estamos dentro do prazo de inscrições.";
		exit();
	}
    $db->iniciar_transacao();
	
    $buscar_token = $db->sql_query("SELECT client_id, client_secret, notification_url FROM es_pagamentos_tipos WHERE fgk_evento = ? AND id_tipo_pagamento = ?", array('fgk_evento'=>EVENTO_ATUAL, 'id_tipo_pagamento'=> BOLETO));
    foreach ($buscar_token as $registro) {
      //$client_id = $registro->client_id;
      //$client_secret = $registro->client_secret;
     //$notification_url = $registro->notification_url;
      $notification_url = "http://www.encontrodesaberes.ufop.br/gerencianet/update.php?pgt=2";
    }
	/*Desenvolvimento*/
    $client_id = 'Client_Id_fc99ef8b2c40ab157c9aef876fd62eec3bb9a2f5';
    $client_secret = 'Client_Secret_9fd6f712c7d5e8f2b320d98db128905af0fe1609';

    $verifica_inscricao = $db->existe("es_inscritos", array("cpf"=>$cpf, "bool_temp"=>0, "fgk_evento"=>EVENTO_ATUAL));

    if($verifica_inscricao){
        echo "Você já está inscrito no Encontro de Saberes.";
        exit();
    }
	
 if(!$cpf){
		echo "Favor preencher seu cpf";
		exit();
	} else if(!$nome){
		echo "Favor preencher seu nome";
		exit();
	} else if((! isset( $email ) || ! filter_var( $email, FILTER_VALIDATE_EMAIL )  )){
		echo "Favor preencher um e-mail válido";
		exit();
	} else if(!$cpf){
		echo "Favor preencher seu cpf";
		exit();
	} else if(!$cep){
		echo "Favor preencher seu cep";
		exit();
	} else if(!$cidade){
		echo "Favor preencher sua cidade";
		exit();
	} else if(!$bairro){
		echo "Favor preencher seu bairro";
		exit();
	} else if(!$endereco){
		echo "Favor preencher seu endereco";
		exit();
	} else if(!$estado){
		echo "Favor preencher seu estado";
		exit();
	} else if(!$telefone_celular){
		echo "Favor preencher seu telefone_celular";
		exit();
	} else if(!$senha){
		echo "Favor preencher sua senha";
		exit();
	} else if(!$nome_cracha){
		echo "Favor preencher seu nome no crachá";
		exit();
	}

    if(!$autoriza_envio_emails){
        $autoriza_envio_emails = 0;
    }

    $salt = base64_encode(time());
    $senha = crypt($senha, $salt);
    
    $dados = array(
    'ip' => $ip,
    'fgk_evento' => EVENTO_ATUAL,
    'fgk_instituicao' => $instituicao,
    'fgk_tipo' => $tipo_inscricao,
    'cpf' => $cpf,
    'password' => $senha,
    'autoriza_envio_emails' => $autoriza_envio_emails,
    'certificado_participacao' => 0,
    'conta_ativada' => 0,
    'fgk_departamento' => $id_departamento,
    'departamento' => $departamento,
    'fgk_curso' => $id_curso,
    'curso' => $curso,
    'email' => $email, 
    'email_alternativo' =>$emaila,
    'matricula' => $matricula,
    'nome' => $nome,
    'cep' => $cep,
    'cidade' => $cidade,
    'bairro' => $bairro,
    'endereco' => $endereco,
    'numero' => $numero,
    'complemento' => $complemento,
    'estado' => $estado,
    'telefone' => $telefone,
    'telefone_celular' => $telefone_celular,
    'datahora_registro' => date('Y-m-d H:i:s'),
    'salt' => $salt,
    'mobilidade_ano_atual' => $mobilidade_ano_atual,
    'mobilidade_ano_passado' => $mobilidade_ano_passado,
    'bool_temp' => 0,
    'bool_monitoria' => $bool_monitoria,
    'bool_necessidade_especial' => $bool_necessidade_especial,
    'necessidade_especial_descricao' => $necessidade_especial_descricao,
    'nome_cracha' => $nome_cracha
    );
    
    if($bool_temp == 0){    
        $cadastrar = $db->inserir('es_inscritos', $dados);
        if(!$cadastrar){
            echo "Erro ao fazer sua inscrição. Verifique se todos os dados foram preenchidos corretamente.";
            exit();
        }
        $id_inscrito = $db->lastInsertId("es_inscritos");
    }
    else if($bool_temp == 1 ){
         $atualizar = $db->atualizar('es_inscritos', $dados, 'cpf', $cpf);
        if(!$atualizar){
            echo "Erro ao fazer sua inscrição. Verifique se todos os dados foram preenchidos corretamente.";
            exit();
        }
          $inscrito = $db->sql_query("SELECT id FROM es_inscritos WHERE cpf = ?", array('cpf'=>$cpf));
            foreach ($inscrito as $registro) {
              $id_inscrito = $registro->id;
            }
    }


   

/*
    $options       = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'sandbox' => true
        ];

        $valor_servico = (int) preg_replace('/[^0-9]/', '', $valor_inscricao);
        
        $item_1 = [
        'name' => 'Encontro de Saberes',
        'amount' => 1,
        'value' => $valor_servico
        ];
        
        
        $items = [
            $item_1
        ];
        
        $body = [
           'items' => $items,
           'metadata' => [
              'custom_id' => '8',
              'notification_url' => $notification_url
          ]
        ];
        
        try {
            $api              = new Gerencianet($options);
            $charge           = $api->createCharge([], $body);
            $id               = $charge[ 'data' ][ 'charge_id' ];
            $valor            = $charge[ 'data' ][ 'total' ];
            $data_emissao     = $charge[ 'data' ][ 'created_at' ];
            $params           = [ 'id' => $id ];
            $cpf              = preg_replace('/[^0-9]/', '', $cpf);
            $telefone_celular = preg_replace('/[^0-9]/', '', $telefone_celular); 
            $data_vencimento= DATA_VENCIMENTO_BOLETO;
			
            $customer         = [
            'name' => $nome,
            'cpf' => $cpf ,
            'phone_number' => $telefone_celular,
            'email' => $email
            ];
            
            $bankingBillet = [
            'expire_at' => $data_vencimento,
            'customer' => $customer
            ];
            
            $payment = [
            'banking_billet' => $bankingBillet
            ];
            
            $body = [
            'payment' => $payment
            ];
            
            try {
                $api    = new Gerencianet($options);
                $charge = $api->payCharge($params, $body);
                
                $data_vencimento = $charge[ 'data' ][ 'expire_at' ];
                $link            = $charge[ 'data' ][ 'link' ];
                $status          = 0;
                
                
                
            }
            catch (GerencianetException $e) {
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
                exit();
            }
            catch (Exception $e) {
                print_r($e->getMessage());
                exit();
            }
            
        }
        catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
            exit();
        }
        catch (Exception $e) {
            print_r($e->getMessage());
            exit();
        }

    $dados_boleto = array('fgk_inscrito' => $id_inscrito, 
                        'charge_id' => $id,
                        'fgk_evento' => EVENTO_ATUAL,
                        'data_emissao' => date('Y-m-d'),
                        'valor' => $valor,
                        'data_vencimento' => $data_vencimento,
                        'link' => $link);

    $stmt_boleto = $db->inserir('es_inscritos_boletos', $dados_boleto); 
    if(!$stmt_boleto){
        echo "Erro ao gerar o boleto. Por favor informe à administração.";
        $db->reverter();
        exit();
    }
    $boleto = $db->sql_query("SELECT id_boleto FROM es_inscritos_boletos ORDER BY id_boleto DESC LIMIT 1");
    foreach ($boleto as $registro) {
		$id_boleto = $registro->id_boleto;
    }
	$tipo_servico = $db->sql_query("SELECT fgk_servico_inscricao FROM es_inscritos_tipos WHERE id_tipo_inscrito =?", array ('id_tipo_inscrito'=>$tipo_inscricao));
    foreach ($tipo_servico as $registro) {
		$id_servico_inscricao = $registro->fgk_servico_inscricao;
    }
	
	$dados_servico = array('fgk_inscrito' => $id_inscrito,
							'fgk_servico' => $id_servico_inscricao,
							'fgk_boleto' => $id_boleto,
							'valor_servico' => $valor,
							'bool_pago' => 0);
	$stmt_servico = $db->inserir('es_inscritos_servicos', $dados_servico);
    if(!$stmt_servico){
        echo "Erro ao inserir o serviço. Por favor informe à administração.";
        $db->reverter();
        exit();
    }
   */ 
include "enviar_ativar_conta.php";
$db->commit();
echo 'sucesso';
    


  } catch(PDOException $e) {
    echo $e->getMessage();

  }




