<?php

// Une $_SESSION e $POST para verificação
if ($_SESSION['logado']!= true){
	
if ( isset( $_POST ) && ! empty( $_POST ) ) {
	$dados_usuario = $_POST;
} else {
	$dados_usuario = $_SESSION;
}

// Verifica se os campos de usuário e senha existem
// E se não estão em branco
if ( 
	isset ( $dados_usuario['cpf'] ) && 
	isset ( $dados_usuario['senha'] )   &&
  ! empty ( $dados_usuario['cpf'] ) &&
  ! empty ( $dados_usuario['senha'] ) 
) {
	$existe_usuario = $db->existe('es_inscritos',array('cpf'=>$dados_usuario['cpf'], 'bool_temp'=>0, 'fgk_evento'=> EVENTO_ATUAL));
	if(!$existe_usuario){
		$_SESSION['logado']     = false;
		$_SESSION['login_erro'] = '<h4>Você ainda não está inscrito no '.NOME_EVENTO.', por favor faça seu cadastro.</h4>';
		header('location: ../login.php');
	}  else {
		$select = "SELECT * FROM es_inscritos WHERE cpf=? AND fgk_evento = ?";
		$dados_salt = $db->sql_query($select, array('cpf'=>$dados_usuario['cpf'], 'fgk_evento'=> EVENTO_ATUAL));
		foreach ($dados_salt as $registro) {
			$id_inscrito = $registro->id;
			$cpf = $registro->cpf;
			$salt = $registro->salt;
		}

		$senha = crypt($dados_usuario['senha'], $salt);
		$checa_usuario = $db->existe('es_inscritos', array('cpf'=>$dados_usuario['cpf'], 'password'=>$senha,'bool_temp'=>0 ));
		if(!$checa_usuario){
			$_SESSION['logado']     = false;
			$_SESSION['login_erro'] = '<h4>Senha incorreta.</h4>';
			header('location: ../login.php');

		} else{

			$_SESSION['logado']       = true;
			$_SESSION['id_inscrito'] = $id_inscrito;
			$last_login = $db->atualizar('es_inscritos',  array('last_login' => date('Y-m-d H:i:s') ), 'cpf', $cpf);	
			$select = "SELECT * FROM es_inscritos WHERE es_inscritos.id = ?";
			$dados_usuario = $db->sql_query( $select, array('es_inscritos.id'=>$_SESSION['id_inscrito']) );
			foreach ($dados_usuario as $registro){
				define("ID_USUARIO", $registro->id, true);
				define("NOME_USUARIO", $registro->nome, true);
				define("CPF_USUARIO", $registro->cpf, true);
				define("CELULAR_USUARIO", $registro->telefone_celular, true);
				define("EMAIL_USUARIO", $registro->email, true);
				define("TIPO_USUARIO", $registro->fgk_tipo, true);
				define("EMAIL_ALTERNATIVO_USUARIO", $registro->email_alternativo, true);
				define("BOOL_COORDENADOR", $registro->bool_coordenador, true);
				define("BOOL_REVISOR", $registro->bool_revisor, true);
				define("BOOL_TEMP", $registro->bool_temp, true);
				define("CONTA_ATIVADA", $registro->conta_ativada, true);
				define("MOBILIDADE_ANO_ATUAL", $registro->mobilidade_ano_atual, true);
				define("MOBILIDADE_ANO_PASSADO", $registro->mobilidade_ano_passado, true);
				define("AREA_COORDENACAO", $registro->fgk_area_coordenacao, true );
				define("BOOL_MONITORIA", $registro->bool_monitoria, true);
				define("INSTITUICAO_USUARIO", $registro->fgk_instituicao, true);
				if($registro->bool_revisor == 1){
					$verifica_revisor = $db->sql_query("SELECT id FROM es_avaliacao_revisor WHERE fgk_inscrito = ?", array("fgk_inscrito"=>$_SESSION['id_inscrito']));
					foreach ($verifica_revisor as $value) {
						define("ID_REVISOR", $value->id, true);
					}
				}
			}

		}	
	}
}
}
?>