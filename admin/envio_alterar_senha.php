<?php

include ("../../config.php");

foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

try{

    $sql_salt_atual = "SELECT salt, password FROM es_inscritos WHERE id = ?";
    $dados_salt = array( 'id' => $id_inscrito );
    $verifica_salt = $db->sql_query($sql_salt_atual, $dados_salt);
    foreach ($verifica_salt as $registro) {
        $salt_atual = $registro->salt;
        $senha_salt = $registro->password;
    }

    $senha_atual = crypt($senha_atual, $salt_atual);
    if ($senha_atual != $senha_salt){
        echo "A senha atual informada está incorreta.";
        exit();
    }

    $salt = base64_encode(time());
    $senha = crypt($senha, $salt);
	
	$dados = array(
        'password' => $senha,
        'salt' => $salt
    );

    $atualizar = $db->atualizar('es_inscritos', $dados, 'id', $id_inscrito);

    if($atualizar)
    	echo "sucesso";
    else
    	echo "Houve um erro ao atualizar sua senha";

} catch(PDOException $e) {
    echo $e->getMessage();
}
