<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once('../../includes/functions.php');
	require_once('../../includes/db_connect.php');
	sec_session_start();
	error_reporting(0);
	$now = date("Y-m-d H:i:s");

	if(isset($_POST['insc'])){
		$json = $_POST['insc'];
		$dados = json_decode($json);
			$fgk_evento = $_SESSION['id_evento_atual'];
			$estrangeiro = $dados->estrangeiro;
			$nome = $dados->nome;
			$fgk_tipo = $dados->fgk_tipo;
			$email = $dados->email;
			$email_alternativo = $dados->email_alternativo;
			$telefone_celular = $dados->telefone_celular;
			$telefone = $dados->telefone;
			$autoriza_envio_emails = $dados->autoriza_envio_emails;
			$estado = $dados->estado;
			$cidade = $dados->cidade;
			$bairro = $dados->bairro;
			$endereco = $dados->endereco;
			$numero = $dados->numero;
			$complemento = $dados->complemento;
			$fgk_instituicao = $dados->fgk_instituicao;
			$fgk_servico = $dados->fgk_servico;

			if($estrangeiro){
				$passaporte = $dados->passaporte;
				$vars = array('fgk_evento'=>$fgk_evento,'fgk_instituicao'=>$fgk_instituicao, 'fgk_tipo'=>$fgk_tipo, 'cpf'=>$passaporte, 'autoriza_envio_emails'=>$autoriza_envio_emails, 'certificado_participacao'=>0, 'conta_ativada'=>0, 'email'=>$email, 'email_alternativo'=>$email_alternativo, 'nome'=>$nome, 'cidade'=>$cidade, 'bairro'=>$bairro, 'endereco'=>$endereco, 'numero'=>$numero, 'complemento'=>$complemento, 'estado'=>$estado, 'telefone'=>$telefone, 'telefone_celular'=>$telefone_celular,'datahora_registro'=>$now , 'mobilidade_ano_passado'=>0, 'mobilidade_ano_atual'=>0, 'bool_monitoria'=>0, 'bool_coordenador'=>0, 'bool_revisor'=>0, 'fgk_area_coordenacao'=>0, 'bool_spam'=>0, 'bool_temp'=>0, 'bool_estrangeiro'=>$estrangeiro);
			
				$cadastroCpf = $db->existe('es_inscritos', array('cpf'=>$passaporte, 'fgk_evento'=>$fgk_evento));
				if($cadastroCpf){
					echo json_encode(array(
						"success"=>false,
						"msg"=>"Passaporte ".$passaporte." já cadastrado neste evento."
					));
					exit();
				}

			}else{
				$cpf = $dados->cpf;
				$cep = $dados->cep;
				$vars = array('fgk_evento'=>$fgk_evento,'fgk_instituicao'=>$fgk_instituicao, 'fgk_tipo'=>$fgk_tipo, 'cpf'=>$cpf, 'autoriza_envio_emails'=>$autoriza_envio_emails, 'certificado_participacao'=>0, 'conta_ativada'=>0, 'email'=>$email, 'email_alternativo'=>$email_alternativo, 'nome'=>$nome, 'cep'=>$cep, 'cidade'=>$cidade, 'bairro'=>$bairro, 'endereco'=>$endereco, 'numero'=>$numero, 'complemento'=>$complemento, 'estado'=>$estado, 'telefone'=>$telefone, 'telefone_celular'=>$telefone_celular,'datahora_registro'=>$now, 'mobilidade_ano_passado'=>0, 'mobilidade_ano_atual'=>0, 'bool_monitoria'=>0, 'bool_coordenador'=>0, 'bool_revisor'=>0, 'fgk_area_coordenacao'=>0, 'bool_spam'=>0, 'bool_temp'=>0, 'bool_estrangeiro'=>$estrangeiro);
				
				$cadastroCpf = $db->existe('es_inscritos', array('cpf'=>$cpf, 'fgk_evento'=>$fgk_evento));
				if($cadastroCpf){
					echo json_encode(array(
						"success"=>false,
						"msg"=>"CPF ".$cpf." já cadastrado neste evento."
					));
					exit();
				}
			}
			
			$db->iniciar_transacao();
			$db->inserir('es_inscritos', $vars);
			$fgk_novoInscrito = $db->lastInsertId();

			//Cria serviço
			$ServicoDados = $db->listar('es_servicos', 'id_servico', $fgk_servico);
			$valor_servico = $ServicoDados->valor_servico;

			$tipoPagamentoDados = $db->listar('es_pagamentos_tipos', 'bool_inscRapida', 1); //qual servico é o da inscrição rápida
			$fgk_tipo_pagamento = $tipoPagamentoDados->id_tipo_pagamento;

			$ServicoValues = array('fgk_inscrito'=>$fgk_novoInscrito, 'fgk_servico'=>$fgk_servico, 'valor_servico'=>$valor_servico, 'bool_pago'=>1);
			$db->inserir('es_inscritos_servicos', $ServicoValues);
			$id_inscrito_servico = $db->lastInsertId();

			if(intval($valor_servico) >= 1){
				$Dadospagamento = array('id_inscrito_servico'=>$id_inscrito_servico, 'fgk_servico'=>$fgk_servico, 'fgk_tipo_pagamento'=>intval($fgk_tipo_pagamento), 'datahora_pagamento'=>$now, 'valor_pago'=>$valor_servico);
				$db->inserir('es_inscritos_pagamentos', $Dadospagamento);
			}
			//cria Serviço
			$db->commit();

		echo json_encode(array(
			"success"=>true,
			"msg"=>"Novo inscrito cadastrado com sucesso!",
			"id_novoInscrito"=>$fgk_novoInscrito
		));
	}else{
		echo json_encode(array(
			"success"=>false,
			"msg"=>"Erro ao cadastrar novo inscrito!"
		));
	}

?>