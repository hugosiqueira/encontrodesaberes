<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/db_connect.php');
	require_once('../../includes/functions.php');
	sec_session_start();
	date_default_timezone_set('America/Sao_Paulo');

	$barcode = $_POST['barcode'];
	$barcode = str_replace('*', '', $barcode);
	$fgk_local = $_POST['id_local'];
	$now = date("Y-m-d H:i:s");

	$vars0 = array('codigo_credenciamento'=> $barcode);
	$credencial = $db->existe('es_inscritos_credencial', $vars0);

	if($credencial){

		$buscaInscrito = $db->listar('es_inscritos_credencial', 'codigo_credenciamento', $barcode);
			$fgk_inscrito = $buscaInscrito->fgk_inscrito;
			$id_evento = $buscaInscrito->fgk_evento;

		$insertData = array('fgk_evento'=> $id_evento, 'fgk_inscrito'=> $fgk_inscrito, 'fgk_local_presenca'=> $fgk_local, 'datahora_presenca'=> $now );
		$db->iniciar_transacao();

		$db->inserir('es_presencas', $insertData);

		///////////////// ENVIO DE CERTIFICADO POR EMAIL

		$id_evento_atual 	= $_SESSION['id_evento_atual'];
		$sigla_evento_atual = $_SESSION['sigla_evento_atual'];

		$InscritoDados = $db->listar('es_inscritos', 'id', $fgk_inscrito);

		$cert_query = "SELECT id_tipo_certificado, modelo_padrao FROM es_certificados_tipos WHERE fgk_evento = ? AND bool_presenca = ?";

		$cert_data = $db->sql_query2($cert_query, array(8, 1));
		foreach($cert_data as $certificadoDados) {


				if(!$db->existe('es_certificados',array('cpf'=> $InscritoDados->cpf, 'fgk_tipo'=>$certificadoDados->id_tipo_certificado ))){
					function geraToken($id_evento, $tamanho=8, $maiusculas=true, $numeros=true, $simbolos=false){
						$lmin = 'abcdefghijklmnopqrstuvwxyz';
						$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$num = '1234567890';
						$simb = '!@#$%*';
						$retorno = '';
						$caracteres = '';
						$caracteres .= $lmin;
						if ($maiusculas)
							$caracteres .= $lmai;
						if ($numeros)
							$caracteres .= $num;
						if ($simbolos)
							$caracteres .= $simb;
						$len = strlen($caracteres);
						for ($n = 1; $n <= $tamanho; $n++) {
							$rand = mt_rand(1, $len);
							$retorno .= $caracteres[$rand-1];
						}
						return $id_evento.'-'.$retorno;
					}

					$texto_cert = str_replace("%nome_participante%", $InscritoDados->nome, $certificadoDados->modelo_padrao);
					$add = array(
						'fgk_tipo'				=> $certificadoDados->id_tipo_certificado,
						'dizeres_certificado'	=> $texto_cert,
						'data_emissao'			=> date('Y-m-d H:i:s'),
						'fgk_evento'			=> $id_evento_atual,
						'cpf'					=> $InscritoDados->cpf,
						'nome'					=> $InscritoDados->nome,
						'email'					=> $InscritoDados->email,
						'chave_autenticidade'	=> geraToken($id_evento_atual)
					);
					$db->inserir('es_certificados', $add);

					$id_certificado = $db->lastInsertId();
					$certificado = $db->listar('es_certificados', 'id_certificado', $id_certificado);
					$tipo_certificado = $db->listar('es_certificados_tipos', 'id_tipo_certificado', $certificado->fgk_tipo);

					$texto_email="
						Prezado(a),<br>Agradecemos a sua participação no ".$sigla_evento_atual.".<br>Segue o link para baixar o seu certificado:<br><br>http://www.encontrodesaberes.com.br/gerar_certificado.php?c=".$certificado->chave_autenticidade."&f=1<br><br>Atenciosamente,<br>Comissão organizadora.";
					$add = array(
						'fgk_evento'		=> $id_evento_atual,
						'cpf_destinatario'	=> $InscritoDados->cpf,
						'nome_destinatario'	=> $InscritoDados->nome,
						'email_destinatario'=> $InscritoDados->email,
						'categoria'			=> "certificado ".$sigla_evento_atual,
						'assunto'			=> $sigla_evento_atual.": ".$tipo_certificado->descricao_certificado.".",
						'corpo_email'		=> $texto_email
					);
					$db->inserir('es_comunicacao_email', $add);

					require '../../../includes/sendgrid-php/vendor/autoload.php';
					$API_sendgrid = "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";

					$sendgrid = new SendGrid($API_sendgrid);
					$email    = new SendGrid\Email();
					$email->addTo($InscritoDados->email)
						->setFrom("encontrodesaberes@ufop.br")
						->setCategory("certificado ".$sigla_evento_atual)
						->setSubject($sigla_evento_atual.": ".$tipo_certificado->descricao_certificado.".")
						->setHtml($texto_email);

					if(!$sendgrid->send($email)){
						echo json_encode(array(
							"success" =>false,
							"msg" => "Erro ao enviar email. Favor entrar em contato com o administrador do sistema."
						));
					}

				}
			///////////////// ENVIO DE CERTIFICADO POR EMAIL
		}

		$db->commit();
		echo json_encode(array(
			"success" => true,
			"status" => "Okay", //Okay, Error, Info, NULL
			"msg"=> "Presenca confirmada com sucesso."
		));
	}else{
		echo json_encode(array(
			"success" => false,
			"status" => "ERRO", //Okay, Error, Info, NULL
			"msg"=> "Credencial não encontrada.</br>Número: ".$barcode
		));
	}
?>