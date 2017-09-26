<?php
require_once("C:/xampp/htdocs/encontrodesaberes/../config.php");
function sec_session_start() {
    $session_name = 'sec_session_id';   // Estabeleça um nome personalizado para a sessão
    $secure = false;// Isso impede que o JavaScript possa acessar a identificação da sessão.
    $httponly = true;
    // Assim você força a sessão a usar apenas cookies.
   if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Obtém params de cookies atualizados.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);
    // Estabelece o nome fornecido acima como o nome da sessão.
    session_name($session_name);
    session_start();            // Inicia a sessão PHP
    session_regenerate_id();    // Recupera a sessão e deleta a anterior.
}

function login($login, $password, $db) {
	$_SESSION['erro'] = 0; // sem erros
	$queryLogin = "
		SELECT id_usuario, login, password, salt, ultimo_acesso, nome_usuario, bool_ativo, fgk_grupo
        FROM desk_usuarios
			LEFT JOIN desk_usuarios_grupos ON desk_usuarios_grupos.fgk_usuario = desk_usuarios.id_usuario
		WHERE login = ?
	";
	$qryLogin = $db->sql_query($queryLogin, array($login));
	foreach ($qryLogin as $registro) {
		$user_id 		= $registro->id_usuario;
		$db_password 	= $registro->password;
		$salt 			= $registro->salt;
		$ultimo_acesso 	= $registro->ultimo_acesso;
		$nome 			= $registro->nome_usuario;
		$usuario_ativo 	= $registro->bool_ativo;
		$fgk_grupo 		= $registro->fgk_grupo;
	}
	if ($qryLogin->rowCount() > 0){// USUÁRIO ENCONTRADO
		if (checkbrute($user_id, $db)) {// VERIFICA AGORA SE O USUÁRIO ESTÁ BLOQUEADO POR TENTATIVAS DE LOGIN
			$_SESSION['erro'] = 6;
			return false;
		}
		else{// USUÁRIO NÃO BLOQUEADO
			$password = hash('sha512', $password . $salt);
			// $_SESSION['teste_pass'] = $password;
			// $_SESSION['teste_dbpass'] = $db_password;
			if ($db_password == $password){// CONFERINDO A PASSWORD INFORMADA COM A DO BANCO DE DADOS
				$user_id = preg_replace("/[^0-9]+/", "", $user_id);
				$_SESSION['user_id'] = $user_id;
				$filtro_evento = array();
				if($fgk_grupo == 1){
					$queryEvento = "
						SELECT es_evento.id, es_evento.titulo, es_evento.sigla FROM es_evento ORDER BY edicao DESC, titulo ASC
						LIMIT 1
					";
					$filtro_evento = $user_id;
				}
				else{
					$queryEvento = "
						SELECT desk_usuarios_evento.*, es_evento.*, desk_usuarios_grupos.fgk_grupo
						FROM desk_usuarios_grupos
						 LEFT JOIN desk_usuarios_evento ON desk_usuarios_evento.fgk_usuario = desk_usuarios_grupos.fgk_usuario
						 LEFT JOIN es_evento ON es_evento.id = desk_usuarios_evento.fgk_evento
						WHERE desk_usuarios_grupos.fgk_usuario = ?
						ORDER BY edicao DESC, titulo ASC
						LIMIT 1
					";
					$filtro_evento = $user_id;
				}
				
				$qryEvento = $db->sql_query($queryEvento, array($filtro_evento));
				foreach ($qryEvento as $registro) {
					$titulo_evento 	= $registro->titulo;
					$id_evento 		= $registro->id;
					$sigla_evento 	= $registro->sigla;
				}
				if(($qryEvento->rowCount()>0) || ($fgk_grupo =="1")){//VERIFICA SE USUÁRIO ESTÁ EM ALGUM EVENTO OU SE É ADM
					$_SESSION['primeiro_grupo'] = preg_replace("/[^0-9]+/", "", $fgk_grupo);
					if($usuario_ativo == 1){// VERIFICA SE O USUÁRIO ESTÁ LIBERADO NO SISTEMA
						$user_browser = $_SERVER['HTTP_USER_AGENT'];
						$_SESSION['login']			= preg_replace("/[^a-zA-Z0-9_\-]+/", "", $login);
						$_SESSION['nome'] 			= $nome;
						$_SESSION['ultimo_acesso'] 	= preg_replace("/[^0-9]+/", "", $ultimo_acesso);
						//variáveis que permitem as trocas entre eventos
						$_SESSION['primeiro_user'] 				= $user_id;
						$_SESSION['id_evento_atual'] 			= preg_replace("/[^0-9]+/", "", $id_evento);
						$_SESSION['titulo_evento_atual']		= preg_replace("/[^a-zA-Z0-9_\-]+/", "", $titulo_evento);
						$_SESSION['formatacao_evento_atual'] 	= $sigla_evento." - ".$titulo_evento;
						$_SESSION['sigla_evento_atual']			= $sigla_evento;
						$_SESSION['login_string'] 				= hash('sha512',$password . $user_browser);
						$_SESSION['erro'] = 0;

						$now = time() ;
						$atualizarUltimoAcesso = array(
							'ultimo_acesso'=>$now
						);
						$db->atualizar('desk_usuarios', $atualizarUltimoAcesso, 'id_usuario', $user_id);
						return true;
					}
					else{// O USUÁRIO ESTÁ BLOQUEADO PELO SISTEMA
						$_SESSION['erro'] = 5;
						return false;
					}
				}
				else{ // O USUÁRIO NÃO ESTÁ VINCULADO A NENHUM EVENTO E NEM É ADM
					$_SESSION['erro'] = 3;
					return false;
				}
			}
			else{// SENHA INCORRETA, TENTATIVA DE LOGIN REGISTRADA NO BANCO DE DADOS
				$now = time();
				$dados = array('id_usuario'=>$user_id, 'time'=>$now);
				$db->inserir('es_tentativas_login', $dados);
				$_SESSION['erro'] = 2;
				return false;
			}
		}
	}
	else{// USUÁRIO NÃO ENCONTRADO
		$_SESSION['erro'] = 1;
		return false;
	}
}

function checkbrute($user_id, $db) {
    $now = time();
    $intervalo = $now - (60 * 10); // ÚLTIMAS TENTATIVAS NO INTERVALO DE 10 MINUTOS
	$queryTentativas = "
		SELECT time
		 FROM es_tentativas_login
		 WHERE id_usuario = ?
		AND time > ?
	";
	$qryTentativas = $db->sql_query($queryTentativas, array('id_usuario'=>$user_id, 'time'=>$intervalo));
	if ($qryTentativas->rowCount() >= 5)// SE HOUVEREM MAIS DE 5 REGISTROS A TENTATIVA DE LOGIN É BLOQUEADA
		return true;
	else
		return false;
}

function login_check($db){
    if (isset($_SESSION['user_id'], $_SESSION['login'], $_SESSION['login_string'])){
        $user_id 		= $_SESSION['user_id'];
        $login_string 	= $_SESSION['login_string'];
        $login 			= $_SESSION['login'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

		$queryLogin = "SELECT password, bool_ativo FROM desk_usuarios WHERE id_usuario = ?";
		$qryLogin = $db->sql_query($queryLogin, array('id_usuario'=>$user_id));
		if ($qryLogin->rowCount()> 0) {
			foreach ($qryLogin as $registro) {
				$db_password 	= $registro->password;
				$bool_ativo 	= $registro->bool_ativo;
			}
			$login_check = hash('sha512', $db_password . $user_browser);
			// $_SESSION['teste_lscheck'] = $login_check;
			if ($login_check == $login_string){
				if($bool_ativo){
					$_SESSION['erro'] = 0;
					return true;
				}
				else{// O USUÁRIO ESTÁ BLOQUEADO
					$_SESSION['erro'] = 5;
					return false;
				}
            }
			else{// Não foi logado
				$_SESSION['erro'] = -1;
				return false;
			}
        } else {
            $_SESSION['erro'] = -1;
            return false;
        }
    }
	else{ // AS SESSIONS NÃO FORAM CRIADAS, USUÁRIO AINDA NÃO FEZ LOGIN
		$_SESSION['erro'] = -1;
        return false;
    }
}
