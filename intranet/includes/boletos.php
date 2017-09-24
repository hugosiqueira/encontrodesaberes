<?php
    require_once("$_SERVER[DOCUMENT_ROOT]/admin/vendor/autoload.php");
     
    use Gerencianet\Exception\GerencianetException;
    use Gerencianet\Gerencianet;

    /* //Define os dados do cliente e da cobrança
    $cliente = array( 'nome'=>'Harley Quinn', 
                      'cpf'=>'123.123.123-12', 
                      'telefone'=>'(12) 12345-1234',
                      'email'=>'teste@exemplo.com')
                      ;
    $cobranca = array('valor'=>1000, 
                      'vencimento'=>'2016-12-28', 
                      'servico'=>'Incrição');
    
    $boleto = criaBoleto($cliente, $cobranca);
      //int Status de criação cobrança
      $boleto['code']; 

      //string Codigo de barras do boleto
      $boleto['data']['barcode']; 

      //string Link para o boleto criado
      $boleto['data']['link']; 

      //string Data de vencimento do boleto
      $boleto['data']['expire_at']; 

      //int id da cobrança/boleto
      $boleto['data']['charge_id']; 

      //string Status do boleto
      $boleto['data']['status'];

      //int Valor do boleto
      $boleto['data']['total']; 

      //string Método de pagamento padrao: banking_billet
      $boleto['data']['payment']; 
      */

    // // REEVIAR EMAIL
    function reenviaEmail($db, $id_cobranca, $id_evento, $email_cliente){ 

      $pagamento = $db->listar_condicional('es_pagamentos_tipos', array('client_id, client_secret'), array('fgk_evento'=>$id_evento, 'bool_boleto'=>1));
      foreach($pagamento as $pgData) {
        $client_id = $pgData->client_id;
        $client_secret = $pgData->client_secret;
      }
        
        $options = [
          'client_id' => $client_id,
          'client_secret' => $client_secret,
          'sandbox' => false
        ];
         
        $params = [
          'id' => intval($id_cobranca)
        ];
         
        $body = [
          'email' => $email_cliente
        ];
         
        try {
            $api = new Gerencianet($options);
            $response = $api->resendBillet($params, $body);
            
            return true;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

    } 
    // // REEVIAR EMAIL

    // // CRIAR BOLETO
    function criaBoleto($db, $id_inscrito, $id_inscrito_servico, $id_forma_pagamento, $data_vencimento = NULL){

      //Buscanco os dados necessários para a cobrança
      $tipo_pagamento = $db->listar('es_pagamentos_tipos', 'id_tipo_pagamento', $id_forma_pagamento);
        $client_id = $tipo_pagamento->client_id;
        $client_secret = $tipo_pagamento->client_secret;
        $notification_url = $tipo_pagamento->notification_url;

      $cliente = array(); //Cria o array com dados necessarios do cliente
      $rsCliente = $db->listar_condicional('es_inscritos', array('nome, cpf, telefone_celular, email'), array('id'=>$id_inscrito));
      foreach($rsCliente as $registro) {
        $cliente['nome'] = $registro->nome;
        $cliente['cpf'] = preg_replace("/[^0-9]+/", "", $registro->cpf);
        $cliente['telefone'] = preg_replace("/[^0-9]+/", "", $registro->telefone_celular);
        $cliente['email'] = $registro->email;
      }

      $servico = array(); //Cria o array com dados necessarios do servico
      $rsServico = $db->listar('es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
        $servico['valor'] = intval($rsServico->valor_servico);
        $id_servico = $rsServico->fgk_servico;

      $rsNomeServ = $db->listar('es_servicos', 'id_servico', $id_servico);
        $servico['nome'] = $rsNomeServ->descricao_servico;
       
      $buscaDataLimite = $db->listar('es_evento', 'id', $_SESSION['id_evento_atual']);
        $db_limite_boleto = $buscaDataLimite->data_max_vencimento_boleto;

      $Hoje = new DateTime();

      if(!$data_vencimento){
        $data_limite = date_create_from_format('Y-m-d', $db_limite_boleto);
        $diffDays = intval($Hoje->diff($data_limite)->format('%a'), 10);

        if($diffDays > 14)
          $data_vencimento = date('Y-m-d', strtotime('+14 days'));
        else
          $data_vencimento = date_format($data_limite, 'Y-m-d');
        }

      /// Configuracões do boleto
      $apiConfig = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'sandbox' => false
      ];
       
      $dadosCobranca  =  [
          'items' => [[
              'name' => $servico['nome'],
              'amount' => 1,
              'value' => $servico['valor']
          ]],
          'metadata' => [
              'custom_id' => $_SESSION['id_evento_atual'],
              'notification_url' => $notification_url
          ]
      ];
       
      $dadosBoleto = [
        'payment' => [
            'banking_billet' => [
                'expire_at' => $data_vencimento,
                'instructions' => [$_SESSION['formatacao_evento_atual']],
                'customer' => [ //dados do cliente
                    'name' => $cliente['nome'],
                    'cpf' => $cliente['cpf'],
                    'phone_number' => $cliente['telefone'],
                    'email' => $cliente['email']
                  ]
              ]
          ]
      ];
       
      try {
          $api = new Gerencianet($apiConfig);
          $NovaCobranca = $api->createCharge([], $dadosCobranca); //gera a cobrança

          $id_cobranca = $NovaCobranca['data']['charge_id'];

          $boleto = $api->payCharge(array('id'=>$id_cobranca), $dadosBoleto); //gera o boleto

          $db->iniciar_transacao();
            $rsInscritoId = $db->listar('es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
              $id_inscrito = $rsInscritoId->fgk_inscrito;

            $boleto_insc_dados = array('fgk_evento'=>$_SESSION['id_evento_atual'], 'fgk_inscrito'=>$id_inscrito, 'data_emissao'=>$Hoje->format('Y-m-d'), 'valor'=>$servico['valor'], 'data_vencimento'=>$data_vencimento, 'link'=>$boleto['data']['link'], 'charge_id'=>$boleto['data']['charge_id']);
            $db->inserir('es_inscritos_boletos', $boleto_insc_dados);

            $last_id_boleto = $db->lastInsertId();

            $db->atualizar('es_inscritos_servicos', array('fgk_boleto'=>$last_id_boleto), 'id_inscrito_servico', $id_inscrito_servico);

          $db->commit();
       
        print_r( json_encode( array("success"=>true, "msg"=>"Boleto criado com sucesso.") ));
      } catch (GerencianetException $e) {
        print_r( json_encode( array("success"=>false, "msg"=>"Erro: ".$e->error." Codigo: ".$e->code." ".var_export($e->errorDescription, true)) ));
      } catch (Exception $e) {
        print_r( json_encode( array("success"=>false, "msg"=>"Erro: ".$e->getMessage()) ));
      }
    } 
    // // CRIAR BOLETO
?>