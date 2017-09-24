<?php
include ("../../config.php");
foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

if(!$instituicao_autor){
	echo "Preencha a instituição do autor";
	exit();
} else if (!$id_trabalho_autor){
	echo "Faltando o campo que identifica o trabalho. Favor comunicar ao suporte.";
	exit();
} else if (!$tipo_autor){
	echo "Preencha o tipo do autor.";
	exit();
} else if (!$cpf_autor){
	echo "Faltando o cpf do autor.";
	exit();
} else if (!$nome_autor){
	echo "Faltando o nome do autor.";
	exit();
} else if (!$email_autor){
	echo "Faltando o email do autor.";
	exit();
} 

else if (!$ordem_autor){
	echo "Faltando a ordem do autor.";
	exit();
} 

$existeCpfAutorCadastrado = verificaCpfAutorTrabalho($db, $id_trabalho_autor, $cpf_autor);

if($existeCpfAutorCadastrado){
	echo "O CPF informado já está cadastrado como autor deste trabalho.";
	exit();
}

$existeEmailAutorCadastrado = verificaEmailAutorTrabalho($db, $id_trabalho_autor, $email_autor);
if($existeEmailAutorCadastrado){
	echo "O e-mail informado já está cadastrado como autor deste trabalho.";
	exit();
}
 $dados_autor = array(
        'fgk_instituicao' => $instituicao_autor,
        'fgk_trabalho' => $id_trabalho_autor,
        'fgk_tipo_autor' => $tipo_autor,
        'cpf' => $cpf_autor,
        'nome' => $nome_autor,
        'email' => $email_autor,
        'bool_apresentador' => $apresentador_autor,
        'ordenacao' => $ordem_autor
        );

    $inserir_autor = $db->inserir('es_trabalho_autor', $dados_autor);
    if($inserir_autor)
    	echo "sucesso";
    else
    	echo "Erro ao tentar inserir o autor";
