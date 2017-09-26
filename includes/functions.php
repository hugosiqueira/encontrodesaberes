<?php

//********************************************************
//
// Funções Globais Úteis
//
//////////////////////////////////////////////////////////

function envia_email( $sendgrid_apikey, $destinatario, $assunto, $mensagem, $categoria, $remetente="encontrodesaberes@ufop.br" ){

	$corpo_email = "
	<!doctype html>
	<html>
	<head>
	<meta name='viewport' content='width=device-width'>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<title>Encontro de Saberes</title>
	<style>
	/* -------------------------------------
	    GLOBAL
	------------------------------------- */
	* {
	  font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	  font-size: 100%;
	  line-height: 1.6em;
	  margin: 0;
	  padding: 0;
	}

	img {
	  max-width: 600px;
	  width: auto;
	}

	body {
	  -webkit-font-smoothing: antialiased;
	  height: 100%;
	  -webkit-text-size-adjust: none;
	  width: 100% !important;
	}


	/* -------------------------------------
	    ELEMENTS
	------------------------------------- */
	a {
	  color: #348eda;
	}

	.btn-primary {
	  Margin-bottom: 10px;
	  width: auto !important;
	}

	.btn-primary td {
	  background-color: #348eda; 
	  border-radius: 25px;
	  font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; 
	  font-size: 14px; 
	  text-align: center;
	  vertical-align: top; 
	}

	.btn-primary td a {
	  background-color: #348eda;
	  border: solid 1px #348eda;
	  border-radius: 25px;
	  border-width: 10px 20px;
	  display: inline-block;
	  color: #ffffff;
	  cursor: pointer;
	  font-weight: bold;
	  line-height: 2;
	  text-decoration: none;
	}

	.last {
	  margin-bottom: 0;
	}

	.first {
	  margin-top: 0;
	}

	.padding {
	  padding: 10px 0;
	}


	/* -------------------------------------
	    BODY
	------------------------------------- */
	table.body-wrap {
	  padding: 20px;
	  width: 100%;
	}

	table.body-wrap .container {
	  border: 1px solid #f0f0f0;
	}


	/* -------------------------------------
	    FOOTER
	------------------------------------- */
	table.footer-wrap {
	  clear: both !important;
	  width: 100%;  
	}

	.footer-wrap .container p {
	  color: #666666;
	  font-size: 12px;
	  
	}

	table.footer-wrap a {
	  color: #999999;
	}


	/* -------------------------------------
	    TYPOGRAPHY
	------------------------------------- */
	h1, 
	h2, 
	h3 {
	  color: #111111;
	  font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
	  font-weight: 200;
	  line-height: 1.2em;
	  margin: 40px 0 10px;
	}

	h1 {
	  font-size: 36px;
	}
	h2 {
	  font-size: 28px;
	}
	h3 {
	  font-size: 22px;
	}

	p, 
	ul, 
	ol {
	  font-size: 14px;
	  font-weight: normal;
	  margin-bottom: 10px;
	}

	.small {
		font-size: 10px;
	}

	ul li, 
	ol li {
	  margin-left: 5px;
	  list-style-position: inside;
	}

	/* ---------------------------------------------------
	    RESPONSIVENESS
	------------------------------------------------------ */

	.container {
	  clear: both !important;
	  display: block !important;
	  Margin: 0 auto !important;
	  max-width: 600px !important;
	}

	.body-wrap .container {
	  padding: 20px;
	}

	.content {
	  display: block;
	  margin: 0 auto;
	  max-width: 600px;
	}

	.content table {
	  width: 100%;
	}

	</style>
	</head>

	<body bgcolor='#f6f6f6'>

	<!-- body -->
	<table class='body-wrap' bgcolor='#f6f6f6'>
	  <tr>
	    <td></td>
	    <td class='container' bgcolor='#FFFFFF'>

	      <!-- content -->
	      <div class='content'>
	      <table>
	        <tr>
	          <td>
	           $mensagem
	          </td>
	        </tr>
	      </table>
	      </div>
	      <!-- /content -->
	      
	    </td>
	    <td></td>
	  </tr>
	</table>
	<!-- /body -->

	<!-- footer -->
	<table class='footer-wrap'>
	  <tr>
	    <td></td>
	    <td class='container'>
	      
	      <!-- content -->
	      <div class='content'>
	        <table>
	          <tr>
	            <td align='center'>
	              <p class='small'>Não gostaria de receber notificações sobre esse evento? <a href='#'><unsubscribe>Desinscrever</unsubscribe></a>.</p>
	            </td>
	          </tr>
	        </table>
	      </div>
	      <!-- /content -->
	      
	    </td>
	    <td></td>
	  </tr>
	</table>
	<!-- /footer -->

	</body>
	</html>";

	require 'sendgrid-php/vendor/autoload.php';
            
    $sendgrid = new SendGrid($sendgrid_apikey);
           
    $email = new SendGrid\Email();
           
    $email->addTo($destinatario)->setCategory($categoria)->setFrom($remetente)->setSubject($assunto)->setHtml($corpo_email)->setFromname("Encontro de Saberes");
           
    $sendgrid->send($email);

    return true;


}

function verifica_conta_ativada($db,  $id_usuario){
	$verifica_ativo = $db->sql_query( 'SELECT conta_ativada FROM es_usuarios WHERE id = ?', array('id' => $id_usuario));
	foreach ($verifica_ativo as $registro) {
		$conta_ativada = $registro->conta_ativada;
	}
	if($conta_ativada == 1){
		return true;
	} else {
		return false;
	}

}

function verifica_inscricao($db,  $id_usuario){
	$verificar = $db->existe( 'es_inscritos', array('fgk_usuario' => $id_usuario));
	if($verificar){
		return true;
	} else {
		return false;
	}

}

function verifica_pagamento_inscricao($db, $id_usuario){
	$verificar_inscrito = $db->existe('es_inscritos', array('fgk_usuario' => $id_usuario));
	if($verificar_inscrito){
		$listar_inscrito = $db->sql_query("SELECT * FROM es_inscritos WHERE fgk_usuario = ?",  array('fgk_usuario' => $id_usuario));
		foreach ($listar_inscrito as $registro) {
			$id_inscrito = $registro->id;
		}
		$verificar_pagamento = $db->sql_query( "SELECT COUNT(*) as qtd FROM es_inscritos_servicos WHERE fgk_inscrito = ? AND bool_pago = ? AND (fgk_servico < 4  OR fgk_servico = 9)", array('fgk_inscrito' => $id_inscrito, 'bool_pago' => 1));
		/*$verificar_pagamento = $db->existe( 'es_inscritos_servicos', array('fgk_inscrito' => $id_inscrito, 'bool_pago' => 1));*/

		foreach ($verificar_pagamento as $value) {
			$qtd = $value->qtd;
		}
		if($qtd > 0){
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function verifica_dados_pessoais($db,  $id_usuario){
	$sql_dados = "SELECT * FROM es_usuarios WHERE id = ?";
	$param_dados = array( 'id' => $id_usuario );
	$verifica_dados = $db->sql_query( $sql_dados, $param_dados);
	foreach ($verifica_dados as $registro) {
		$cpf = $registro->cpf;
		$telefone_celular = $registro->telefone_celular;
		$data_nascimento = $registro->data_nascimento;
		$cep = $registro->cep;
		$cidade = $registro->cidade;
		$endereco = $registro->endereco;
		$bairro = $registro->bairro;
		$numero = $registro->numero;
		$uf = $registro->uf;
	}
	if( empty($cpf)|| empty($telefone_celular) || empty($data_nascimento) || empty($cep) || empty($cidade) || empty($endereco) || empty($bairro) || empty($numero) || empty($uf) ){
		return false;
	} else {
		return true;
	}
}

function getDados($db,  $id_inscrito){
	$select = "SELECT * FROM es_inscritos WHERE id = ?";
	$dados_usuario = $db->sql_query( $select, array('id'=>$id_inscrito));
	foreach ($dados_usuario as $registro) {
		$id_inscrito = $registro->id;
		$nome = $registro->nome;
		$cpf = $registro->cpf;
		$cep = $registro->cep;
		$cidade = $registro->cidade;
		$bairro = $registro->bairro;
		$endereco = $registro->endereco;
		$numero = $registro->numero;
		$complemento = $registro->complemento;
		$estado = $registro->estado;
		$telefone = $registro->telefone;
		$telefone_celular = $registro->telefone_celular;
		$email = $registro->email;
		$email_alternativo = $registro->email_alternativo;
		$data_nascimento = $registro->data_nascimento;
		$fgk_instituicao = $registro->fgk_instituicao;
		$matricula = $registro->matricula;
		$departamento = $registro->departamento;
		$curso = $registro->curso;
		
	}
	return array ("id_inscrito"=>$id_inscrito, "nome"=>$nome, "cpf"=>$cpf, "cep"=>$cep, "cidade"=>$cidade, 
					"estado"=>$estado,"bairro"=>$bairro,"endereco"=>$endereco,"numero"=>$numero,"complemento"=>$complemento,
					"telefone"=>$telefone, "telefone_celular"=>$telefone_celular, "email"=>$email, "email_alternativo"=>$email_alternativo,
					"data_nascimento"=>$data_nascimento, "fgk_instituicao"=>$fgk_instituicao, "matricula"=>$matricula, "departamento"=>$departamento, "curso"=>$curso );
}

function criaBoleto($db, $id_usuario, $id_inscrito_servico, $id_tipo_pagamento){

	$db_evento = $_SESSION['db_evento'];

	//Buscanco os dados necessários para a cobrança
	$tipo_pagamento = $db->listar($db_evento, 'es_pagamentos_tipos', 'id_tipo_pagamento', $id_tipo_pagamento);
	$client_id = $tipo_pagamento->client;
	$client_secret = $tipo_pagamento->client_secret;
	$notification_url = $tipo_pagamento->notification_url;
	//cliente_id == token  = 'Client_Id_309a81843dc2f2b86c2c5f74166986fadecd03f3';
	//client_secret == token_url = 'Client_Secret_bc8ad565496920db8fe5d2956d79f2c990d3d037';

	$cliente = array(); //Cria o array com dados necessarios do cliente
	$rsCliente = $db->listar_condicional(DB_BASE, 'es_usuarios', array('nome, cpf, telefone_celular, email'), array('id'=>$id_usuario));
	foreach($rsCliente as $registro) {
		$cliente['nome'] = $registro->nome;
		$cliente['cpf'] = $registro->cpf;
		$cliente['telefone'] = $registro->telefone_celular;
		$cliente['email'] = $registro->email;
	}

	$servico = array();
	$rsServico = $db->listar($db_evento, 'es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
	$servico['valor'] = intval($rsServico->valor_servico);
	$id_servico = $rsServico->fgk_servico;

	$rsNomeServ = $db->listar($db_evento, 'es_servicos', 'id_servico', $id_servico);
	$servico['nome'] = $rsNomeServ->descricao_servico;

	$cliente['cpf'] = preg_replace("/[^0-9]+/", "", $cliente['cpf']);
	$cliente['telefone'] = preg_replace("/[^0-9]+/", "", $cliente['telefone']);

	$buscaDataLimite = $db->listar(DB_BASE,'es_eventos', 'id', $_SESSION['id_evento_atual']);
	$db_limite_boleto = $buscaDataLimite->data_max_vencimento_boleto;

	$Hoje = new DateTime();
	$data_limite = date_create_from_format('Y-m-d', $db_limite_boleto);
	$diffDays = intval($Hoje->diff($data_limite)->format('%a'), 10);

	if($diffDays > 14)
		$data_vencimento = date('Y-m-d', strtotime('+14 days'));
	else
		$data_vencimento = $data_limite;

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
		$rsInscritoId = $db->listar($db_evento, 'es_inscritos_servicos', 'id_inscrito_servico', $id_inscrito_servico);
		$id_inscrito = $rsInscritoId->fgk_inscrito;

		$boleto_insc_dados = array('fgk_inscrito'=>$id_inscrito, 'data_emissao'=>$Hoje->format('Y-m-d H:i:s'), 'valor'=>$servico['valor'], 'data_vencimento'=>$data_vencimento, 'link'=>$boleto['data']['link'], 'id_cobranca'=>$boleto['data']['charge_id']);
		$db->inserir($db_evento, 'es_inscritos_boletos', $boleto_insc_dados);

		$last_id_boleto = $db->lastInsertId();

		$db->atualizar($db_evento, 'es_inscritos_servicos', array('fgk_boleto'=>$last_id_boleto), 'id_inscrito_servico', $id_inscrito_servico);

		$db->commit();

		return true;
	} catch (GerencianetException $e) {
		print_r($e->code);
		print_r($e->error);
		print_r($e->errorDescription);
	} catch (Exception $e) {
		print_r($e->getMessage());
	}
}

function verificaRevisor($db,  $id_usuario){
	$verifica = $db->existe( "es_revisores", array('fgk_usuario' => $id_usuario));
	if($verifica)
		return true;
	return false;
}

function verificarCertificados($db,  $cpf){
	$verifica = $db->existe( "es_certificados", array('cpf' => $cpf));
	if($verifica)
		return true;
	return false;
}

function criaForm($db,  $tipo_trabalho){
	$sql_verifica_campos = "SELECT * FROM  es_trabalhos_tipos_criterios_revisao
							WHERE fgk_tipo_trabalho = ?";
	$where_campos = array("fgk_tipo_trabalho" => $tipo_trabalho);
	$verifica_campos = $db->sql_query( $sql_verifica_campos, $where_campos);
	foreach ($verifica_campos as $registro) {
		$id_campo = $registro->id;
		$tipo_campo = $registro->tipo_campo;
		$tamanho_campo = $registro->tamanho_campo;
		$label_campo = $registro->label_campo;
		$nome_campo = $registro->nome_campo;
		$tooltip = $registro->tooltip;
		$bool_obrigatorio = $registro->bool_obrigatorio;
		$peso = $registro->peso;
		switch($tipo_campo){
			case 0:
				echo 
					'<div class="form-group  col-md-6">
                        <label for="'.$nome_campo.'" class="col-md-10 col-form-label">'.$label_campo.' </label>
                        <div class="col-md-2">
                        <input type="number"  class="form-control valor" min="0" max="10" name="'.$nome_campo.'" id="'.$nome_campo.'"  onblur="verNota();" />

                        <input type="hidden" name="tipo_campo" id="tipo_campo" value="'.$tipo_campo.'" />
                        <p class="help-block"></p>
                        </div>
                    </div>';
			break;
			case 1:
				echo 
				'<div class="form-group col-md-6">
                    <label for="'.$nome_campo.'">'.$label_campo.' <a href="#" data-toggle="tooltip" data-placement="top" title="'.$tooltip.'"><img src="assets/images/icons/question.png"></a></label>
                    <input type="hidden" name="tipo_campo" id="tipo_campo" value="'.$tipo_campo.'" />
                    <input type="text" class="form-control" name="'.$nome_campo.'" id="'.$nome_campo.'" onChange="verNota();" >
                    <p class="help-block"></p>
                </div>';
			break;
			case 2:
				echo 
					'<div class="form-group col-md-6">
                        <label for="'.$id_campo.'">'.$label_campo.' <a href="#" data-toggle="tooltip" data-placement="top" title="'.$tooltip.'"><img src="assets/images/icons/question.png"></a></label>
                        <input type="hidden" name="tipo_campo" id="tipo_campo" value="'.$tipo_campo.'" />
                        <select required class="form-control" id="'.$id_campo.'" name="'.$id_campo.'" onChange="verNota();">
                        	<option value=""></option>';
                        $sql_opcoes = "SELECT * FROM es_trabalhos_tipos_criterios_revisao_opcoes
                        LEFT JOIN es_trabalhos_tipos_criterios_revisao ON (es_trabalhos_tipos_criterios_revisao.id = es_trabalhos_tipos_criterios_revisao_opcoes.fgk_criterio_revisao)
                        WHERE fgk_criterio_revisao = ?";
                        $where_opcoes = array("fgk_criterio_revisao" =>$id_campo);
                        $verifica_opcoes = $db->sql_query( $sql_opcoes, $where_opcoes);
                        foreach ($verifica_opcoes as $opcoes) {
                        	$id_opcao = $opcoes->id;
							$nota = $opcoes->nota;
							$peso = $opcoes->peso;
							$nota_final = $nota*$peso/100;
                        	$descricao_campo = $opcoes->descricao_campo;
                        	echo '<option value="'.$nota_final.'">'.$descricao_campo.'</option>';
                        }

            	echo 
            		'</select>
            	</div>';
			break;
		}
	}
}

function converteDataIngles($data){
	$data = str_replace('/', '-', $data);
  	$data = date('Y-m-d', strtotime($data));
  	return $data;
}
function converteDataPort($data){
	$data = str_replace('-', '/', $data);
  	$data = date('d/m/Y', strtotime($data));
  	return $data;
}

function dadosTrabalho($db,  $id_trabalho){
	$sql_verifica_trabalho = "SELECT es_trabalho.id as id_trabalho, es_trabalho.fgk_area, fgk_area_especifica,
	fgk_projeto, fgk_orgao_fomento, fgk_instituicao, fgk_inscrito_responsavel, fgk_categoria, 
	apresentacao_obrigatoria, palavras_chave, palavras_chave_revisado, resumo_revisado, resumo_enviado,
	protocolo_cep, protocolo_ceua, apoio_financeiro, titulo_enviado, titulo_revisado, fgk_status,
	datahora_registro, datahora_submissao, datahora_ultima_atualizacao, codigo_area, descricao_area, 
	descricao_area_especifica, es_orgao_fomento.nome as orgao_fomento, es_orgao_fomento.sigla as sigla_orgao_fomento,
	es_instituicao.nome as instituicao, es_instituicao.sigla as sigla_instituicao, descricao_status,
	descricao_categoria, sigla_categoria
	
	FROM es_trabalho 
	LEFT JOIN es_ufop_areas ON (es_ufop_areas.id_area = es_trabalho.fgk_area) 
	LEFT JOIN es_area_especifica ON (es_area_especifica.id = es_trabalho.fgk_area_especifica) 
	LEFT JOIN es_orgao_fomento ON (es_orgao_fomento.id = es_trabalho.fgk_orgao_fomento) 
	LEFT JOIN es_instituicao ON (es_instituicao.id = es_trabalho.fgk_instituicao) 
	LEFT JOIN es_trabalho_status ON (es_trabalho_status.id_status = es_trabalho.fgk_status) 
	LEFT JOIN es_categorias ON (es_categorias.id_categoria = es_trabalho.fgk_categoria) 
	WHERE es_trabalho.id = ?";
	$where_verifica_trabalho = array("es_trabalhos.id" => $id_trabalho);
	$verifica_trabalho = $db->sql_query( $sql_verifica_trabalho, $where_verifica_trabalho);
	foreach ($verifica_trabalho as $registro) {
		$id_area 					= $registro->fgk_area;
		$id_area_especifica 		= $registro->fgk_area_especifica;
		$id_projeto					= $registro->fgk_projeto;
		$id_orgao_fomento			= $registro->fgk_orgao_fomento;
		$id_instituicao				= $registro->fgk_instituicao;
		$id_inscrito_responsavel	= $registro->fgk_inscrito_responsavel;
		$id_categoria				= $registro->fgk_categoria;
		$apresentacao_obrigatoria	= $registro->apresentacao_obrigatoria;
		$palavras_chave_enviado 	= $registro->palavras_chave;
		$palavras_chave_revisado 	= $registro->palavras_chave_revisado;
		$resumo_revisado 			= $registro->resumo_revisado;
		$resumo_enviado 			= $registro->resumo_enviado;
		$protocolo_cep 				= $registro->protocolo_cep;
		$protocolo_ceua				= $registro->protocolo_ceua;
		$apoio_financeiro			= $registro->apoio_financeiro;
		$titulo_revisado 			= $registro->titulo_revisado;
		$titulo_enviado 			= $registro->titulo_enviado;
		$id_status 					= $registro->fgk_status;
		$datahora_registro			= $registro->datahora_registro;
		$datahora_submissao			= $registro->datahora_submissao;
		$datahora_ultima_atualizacao= $registro->datahora_ultima_atualizacao;
		$descricao_status 			= $registro->descricao_status;
		$id_instituicao				= $registro->fgk_instituicao;
		$instituicao 				= $registro->instituicao;
		$sigla_instituicao 			= $registro->sigla_instituicao;
		$descricao_categoria 		= $registro->descricao_categoria;
		$sigla_categoria 			= $registro->sigla_categoria;
		$orgao_fomento 				= $registro->orgao_fomento;
		$sigla_orgao_fomento 		= $registro->sigla_orgao_fomento;
		$codigo_area 				= $registro->codigo_area;
		$descricao_area 			= $registro->descricao_area;;
		$descricao_area_especifica 	= $registro->descricao_area_especifica;
	}
	
	return array ("id_area"=>$id_area,"id_area_especifica"=>$id_area_especifica, "id_projeto"=>$id_projeto,
	"id_orgao_fomento"=>$id_orgao_fomento,"id_instituicao"=>$id_instituicao,
	"id_inscrito_responsavel"=>$id_inscrito_responsavel,"id_categoria"=>$id_categoria, "apresentacao_obrigatoria"=>$apresentacao_obrigatoria,
	"palavras_chave_enviado"=>$palavras_chave_enviado, "palavras_chave_revisado"=>$palavras_chave_revisado,
	"resumo_revisado"=>$resumo_revisado ,"resumo_enviado"=>$resumo_enviado, "protocolo_cep"=>$protocolo_cep , "protocolo_ceua"=>$protocolo_ceua,
	"apoio_financeiro"=>$apoio_financeiro, "titulo_revisado"=>$titulo_revisado, "titulo_enviado"=>$titulo_enviado ,
	"id_status"=>$id_status,"datahora_registro"=>$datahora_registro,  "datahora_submissao"=>$datahora_submissao ,
	"datahora_ultima_atualizacao"=>$datahora_ultima_atualizacao,"descricao_status"=>$descricao_status, "id_instituicao"=>$id_instituicao, 	
	"instituicao"=>$instituicao,"sigla_instituicao"=>$sigla_instituicao,"descricao_categoria"=>$descricao_categoria,
	"sigla_categoria"=>$sigla_categoria, "orgao_fomento"=>$orgao_fomento,
	"sigla_orgao_fomento"=>$sigla_orgao_fomento, "codigo_area"=>$codigo_area,
	"descricao_area"=>$descricao_area, "descricao_area_especifica"=>$descricao_area_especifica);
}

function verificaDesconto($db,  $cpf){
	$select = $db->existe( "es_servicos_descontos", array("cpf"=>$cpf));
	if($select){
		return true;
	} else {
		return false;
	}
}

function getNomeDesconto($db,  $cpf){
	$select = $db->listar( "es_servicos_descontos","cpf",$cpf);
	$nome_desconto = $select->descricao_beneficio;
	return $nome_desconto;
}

function verificaInscritoServico($db,  $id_inscrito, $id_servico){
	$select = $db->existe( "es_inscritos_servicos", array("fgk_inscrito"=>$id_inscrito, "fgk_servico"=>$id_servico));
	if($select){
		return true;
	} else {
		return false;
	}
}


function getValueDesconto($db,  $cpf){
	$select = $db->listar( "es_servicos_descontos","cpf",$cpf);
	$valor_desconto = $select->desconto;
	return $valor_desconto;
}
function getValueIdInscrito($db,  $id_usuario){
	$select = $db->listar( "es_inscritos","fgk_usuario",$id_usuario);
	@$id_inscrito = $select->id;
	return $id_inscrito;
}

function getValueServico($db,  $id_usuario){
	$select = $db->listar( "es_inscritos","fgk_usuario",$id_usuario);
	@$fgk_tipo = $select->fgk_tipo;
	$select2 = $db->listar( "es_inscritos_tipos","id_tipo_inscrito",$fgk_tipo);
	@$fgk_servico_inscricao = $select2->fgk_servico_inscricao;
	return $fgk_servico_inscricao;
}

function verificaTrabInscrito($db, $id_inscrito, $categoria, $id_evento){
	$sql = "SELECT COUNT(*) as qtd FROM es_trabalho 
 
			WHERE es_trabalho.fgk_inscrito_responsavel = ? AND es_trabalho.fgk_categoria = ? AND es_trabalho.fgk_evento = ? AND es_trabalho.fgk_status = ?";
	$select = $db->sql_query($sql, array("es_trabalho.fgk_inscrito_responsavel"=>$id_inscrito, "es_trabalho.fgk_categoria"=>$categoria, "es_trabalho.fgk_evento" => $id_evento, "es_trabalho.fgk_status"=>TRABALHO_SUBMETIDO));
	foreach($select as $registro){
		$qtd = $registro->qtd;
	}
	return $qtd;
}

function verificaTrabNome($db, $titulo_enviado, $cpf, $id_evento, $categoria){
	$sql = "SELECT COUNT(*) as qtd FROM es_trabalho
			LEFT JOIN es_trabalho_autor ON es_trabalho.id = es_trabalho_autor.fgk_trabalho 
			WHERE es_trabalho_autor.cpf = ? AND es_trabalho.titulo_enviado = ? AND es_trabalho.fgk_evento = ? AND es_trabalho.fgk_categoria = ? AND es_trabalho.fgk_status = ?";
	$select = $db->sql_query($sql, array("es_trabalho_autor.cpf"=>$cpf, "es_trabalho.titulo_enviado"=>$titulo_enviado, "es_trabalho.fgk_evento" => $id_evento, "es_trabalho.fgk_categoria"=>$categoria, "es_trabalho.fgk_status"=>TRABALHO_SUBMETIDO));
	foreach($select as $registro){
		$qtd = $registro->qtd;
	}
	return $qtd;
}

function verificaCpfAutorTrabalho($db, $id_trabalho, $cpf_autor){
	$select = $db->existe( "es_trabalho_autor", array("fgk_trabalho"=>$id_trabalho, "cpf"=>$cpf_autor));
	if($select){
		return true;
	} else {
		return false;
	}
}

function verificaEmailAutorTrabalho($db, $id_trabalho, $email_autor){
	$select = $db->existe( "es_trabalho_autor", array("fgk_trabalho"=>$id_trabalho, "email"=>$email_autor));
	if($select){
		return true;
	} else {
		return false;
	}
}

function buscarProjetos($db, $fgk_categoria, $fgk_evento){
	$sql_projeto = "SELECT * FROM es_projeto WHERE fgk_categoria = ? AND fgk_evento = ?";
	$dados = array("fgk_categoria"=>2, "fgk_evento"=>$fgk_evento);
	$verifica_projeto = $db->sql_query($sql_projeto, $dados);
	foreach ($verifica_projeto as $projeto) {
		$titulo = $projeto->titulo;
		$fgk_area_especifica = $projeto->fgk_area_especifica;
	}
	return array("titulo"=>$titulo, "fgk_area_especifica"=>$fgk_area_especifica);
}


