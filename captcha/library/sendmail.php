<?php
  /**
   * Sets error header and json error message response.
   *
   * @param  String $messsage error message of response
   * @return void
   */
  function errorResponse ($messsage) {
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(array('message' => $messsage)));
  }

  /**
   * Pulls posted values for all fields in $fields_req array.
   * If a required field does not have a value, an error response is given.
   */
  function constructMessageBody () {
    $fields_req =  array("name" => true, "email" => true, "message" => true);
    $message_body = "";
    foreach ($fields_req as $name => $required) {
      $postedValue = $_POST[$name];
      if ($required && empty($postedValue)) {
        errorResponse("$name is empty.");
      } else {
        $message_body .= ucfirst($name) . ":  " . $postedValue . "\n";
      }
    }
    return $message_body;
  }

  header('Content-type: application/json');
  define("FEEDBACK_HOSTNAME", "smtp.gmail.com");
  define("FEEDBACK_EMAIL", "email");
  define("FEEDBACK_PASSWORD", "senha");
  define("FEEDBACK_ENCRYPTION", "TLS");
  define("RECAPTCHA_SECRET_KEY", "6LecfAsTAAAAAPIy67UprfPZqZ9h3LGuIoZRTaoz");
 // define("FEEDBACK_SKIP_AUTH", true);

/*
  //do Captcha check, make sure the submitter is not a robot:)...
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => http_build_query(array('secret' => getenv('RECAPTCHA_SECRET_KEY'), 'response' => $_POST["g-recaptcha-response"]))
    )
  );
  $context  = stream_context_create($opts);
  $result = json_decode(file_get_contents($url, false, $context, -1, 40000));

  if (!$result->success) {
    errorResponse('reCAPTCHA checked failed!');
  }*/
  //attempt to send email
  $messageBody = 'teste novamente';
  require '/home/seic2015/encontrodesaberes.ufop.br/captcha/library/vender/php_mailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;
  $mail->CharSet = 'UTF-8';
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
 /* if (!getenv('FEEDBACK_SKIP_AUTH')) {*/
    $mail->SMTPAuth = true;
    $mail->Username = 'usuario';
    $mail->Password = 'senha';
 // }
  //if (getenv('FEEDBACK_ENCRYPTION') == 'TLS') {
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
/* } elseif (getenv('FEEDBACK_ENCRYPTION') == 'SSL') {
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
  //}*/

  $mail->setFrom('hugo@cmop.mg.gov.br', 'Hugao');
  $mail->addAddress('hugoleonardos@gmail.com', 'Hugo Siqueira');

  $mail->Subject = 'Teste';
  $mail->Body  = $messageBody;


  //try to send the message
  if($mail->send()) {
    echo json_encode(array('message' => 'Your message was successfully submitted.'));
  } else {
    errorResponse('An expected error occured while attempting to send the email: ' . $mail->ErrorInfo);
  }
?>
