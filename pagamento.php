<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
    /**
    * String $URL
    * URL para onde deve ser enviada a requisição XML via post para emissão de boleto.
    */
    $url = "https://integracao.gerencianet.com.br/xml/boleto/emite/xml";
    
    /**
    * String $token
    * Variável que armazena o token de integração utilizado na geração do boleto.
    * Gere o token em sua conta Gerencianet e atribua à variável.
    */
    $token = '1aa64743d6e2eb35ec9f4fcb942fb4b4';
    
    /**
    * String $XML
    * XML com os dados necessários para emissão de um boleto pelo sistema Gerencianet.
    */
    
    $xml = "<?xml version='1.0' encoding='utf-8'?>
    <boleto>
    <token>$token</token>
    <clientes>
    <cliente>
    <nomeRazaoSocial>Waleria de Paula</nomeRazaoSocial>
    <cpfcnpj>10700241639</cpfcnpj>
    <cel>+553199999999</cel>
    </cliente>
    </clientes>
    <itens>
    <item>
    <descricao>Encontro de Saberes</descricao>
    <valor>2500</valor>
    <qtde>1</qtde>
    </item>
    </itens>
    <vencimento>01/11/2015</vencimento>
    </boleto>";
    
    /**
    * O XML enviado não pode conter quebras de linha e tabulações.
    */
    $xml = str_replace("\n", '', $xml);
    $xml = str_replace("\r",'',$xml);
    $xml = str_replace("\t",'',$xml);
    
    /**
    * Handle $ch : Manipulador de comunicação para transferência de dados, via CURL.
    */
    $ch = curl_init();
    
    /**
    * Atualiza a URL de destino da variável $ch para a URL definida pela variável $url.
    */
    curl_setopt($ch, CURLOPT_URL, $url);
    
    /**
    * Configura a variável $ch para retornar o resultado da comunicação, ao invés de exibir diretamente.
    */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    /**
    * Configura o máximo de redirecionamentos permitido.
    */
    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
    
    /**
    * Configura para que seja inserido automaticamente o campo Referer: nas requisições que seguem um redirecionamento Location:
    */
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    
    /**
    * Array $data: Armazena o xml a ser enviado($data['entrada']=$xml)
    */
    $data = array('entrada' => $xml);
    
    /**
    * Configura para que a requisição seja enviada via POST
    */
    curl_setopt($ch, CURLOPT_POST, true);
    
    /**
    * Define os dados a serem enviados na requisição via POST
    */
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    /**
    * Define o tempo limite de tentativa de conexão
    */
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    
    /**
    * Configura o USERAGENT da requisição
    */
    curl_setopt($ch, CURLOPT_USERAGENT, 'seu agente');
    
    /**
    * Envia a requisição via POST com o XML e retorna o resultado da requisição
    * String $resposta: Resposta da requisição
    */
    $resposta = curl_exec($ch);
    
    /**
    * Encerra a ponte de comunicação
    */
    curl_close($ch);
    
    /**
    * Imprime a resposta da requisição.
    */


    //Para transformar a resposta em objeto, costumo utilizar a função simplexml_load_string (SUGESTÃO)
    $retorno = simplexml_load_string($resposta);

   RecurseXML($retorno);

    function RecurseXML($xml,$parent="")
    {
       $child_count = 0;
       foreach($xml as $key=>$value)
       {
          $child_count++;    
          if(RecurseXML($value,$parent.".".$key) == 0)  // no childern, aka "leaf node"
          {
             print($parent . "." . (string)$key . " = " . (string)$value . "<BR>\n");       
          }    
       }
       return $child_count;
    } 

    if($retorno->statusCod == 2){

      /*  $metodo = $retorno->metodo;
        $statusCod = $retorno->statusCod;
        $statusMsg = $retorno->statusMsg;
        $status = $retorno->status;
        $lote = $retorno->lote;
        $nome = $retorno->nome;
        $email = $retorno->email;
        $cpf = $retorno->cpf;
        $cnpj = $retorno->cnpj;
        $chave = $retorno->chave;
        $retorno = $retorno->retorno;
        $vencimento = $retorno->vencimento;*/
        $link = $retorno->resposta->cobrancasGeradas->cliente->cobranca->link;
       /* $valor = $retorno->valor;
        $erro = $retorno->erro;*/

        // O link aqui fica vazio
        echo "<a href='".$link."'>Visualize seu boleto</a>";

    } else {
        if($retorno->resposta->erro->status == 1012){ // significa que é um erro de cobrança já gerada anteriormente. Logo, iremos tratar a resposta anterior.
        $retornoAnterior = $retorno->resposta->erro->entrada;
      /*  $metodo = $retornoAnterior->metodo;
        $statusCod = $retornoAnterior->statusCod;
        $statusMsg = $retornoAnterior->statusMsg;
        $status = $retornoAnterior->status;
        $lote = $retornoAnterior->lote;
        $nome = $retornoAnterior->nome;
        $email = $retornoAnterior->email;
        $cpf = $retornoAnterior->cpf;
        $cnpj = $retornoAnterior->cnpj;
        $chave = $retornoAnterior->chave;
        $retorno = $retornoAnterior->retorno;
        $vencimento = $retornoAnterior->vencimento;*/
        $link = $retornoAnterior->emitirCobranca->resposta->cobrancasGeradas->cliente->cobranca->link;
      /*  $valor = $retornoAnterior->valor;
        $erro = $retornoAnterior->erro;*/

        // O link aqui fica vazio
        echo "<a href='".$link."'>Visualize seu boleto</a>";

        } else {
            //Foi outro tipo de erro. Nesse caso, pode ser tratado, ou então mostrar o erro na página
            die('Erro na geração da cobrança. Entre em contato com o desenvolvedor.');
        }
    }