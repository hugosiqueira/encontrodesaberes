<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/functions.php");
	require_once("../../includes/boletos.php");

	sec_session_start();
	$id_evento = $_SESSION['id_evento_atual'];
	$id_boleto = $_POST["id_boleto"];

	$qUserData="SELECT email, charge_id 
				FROM es_inscritos_boletos 
				INNER JOIN es_inscritos ON es_inscritos_boletos.fgk_inscrito = es_inscritos.id 
				WHERE id_boleto = ?;";

	$resultSet = $db->sql_query($qUserData, array('id-boleto'=>$id_boleto));
      foreach($resultSet as $result) {
        $email_cliente = $result->email;
        $id_cobranca = $result->charge_id;
      }

    if(reenviaEmail($db, $id_cobranca, $id_evento, $email_cliente))
    	echo json_encode( array("success" => true) );
    else
    	echo json_encode( array("success" => false) );

?>