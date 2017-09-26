<?php

	header('Content-Type: application/json; charset=utf-8');

	require_once('../../includes/functions.php');

	require_once("$_SERVER[DOCUMENT_ROOT]/admin/vendor/autoload.php");

	set_time_limit(14400); //4 horas

     

    use Gerencianet\Exception\GerencianetException;

    use Gerencianet\Gerencianet;

    

	sec_session_start();



	$query= "SELECT * FROM es_inscritos_boletos WHERE fgk_evento = 8 AND status != 'paid' AND status != 'waiting';";

	$result = $db->sql_query($query);

	 

	$clientId = 'Client_Id_6587b95fd276cf592a9c435e7e9280a41e9492fe'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)

	$clientSecret = 'Client_Secret_b31bd33ad0c86cb6d68dd760acb9e90322166ad3'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)



	$countSuccess = 0;

	foreach ($result as $boleto){

		$countSuccess = $countSuccess + 1;

		$options = [

		  'client_id' => $clientId,

		  'client_secret' => $clientSecret,

		  'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)

		];

		 

		// $charge_id refere-se ao ID da transação gerada anteriormente

		$params = [

		  'id' => $boleto->charge_id

		];

		 

		$body = [

		  'custom_id' => '8', // associar transação Gerencianet com seu identificador próprio

		  'notification_url' => 'http://www.encontrodesaberes.ufop.br/gerencianet/update.php?pgt=2' // url de notificação

		];

		 

		try {

		    $api = new Gerencianet($options);

		    $charge = $api->updateChargeMetadata($params, $body);

		 

		    print_r($charge);

		} catch (GerencianetException $e) {

		    print_r($e->code);

		    print_r($e->error);

		    print_r($e->errorDescription);

		} catch (Exception $e) {

		    print_r($e->getMessage());

		}

	}



	print_r("Boletos atualizados: ".$countSuccess);

?>