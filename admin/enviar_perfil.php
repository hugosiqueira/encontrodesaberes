<?php
include ("../../config.php");
//include ("../includes/functions.php");

foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}

if(!$nome){
  echo "Por favor, preencha com seu nome completo";
  exit();
} else if(!$cpf){
  echo "Por favor, preencha o seu CPF";
  exit();
} else if(!$telefone_celular){
  echo "Por favor, preencha o seu telefone celular";
  exit();
} 

  try {

    
    $dados = array(
    'nome' => $nome,
	'cpf'=>$cpf,
    'telefone' => $telefone,
    'email_alternativo' => $emaila,
    'cep' => $cep,
    'estado' => $uf,
    'cidade' => $cidade,
    'bairro' => $bairro,
    'endereco' => $endereco,
    'numero' => $numero,
    'complemento' => $complemento,
	'data_nascimento' => converteDataIngles($data_nascimento),
	'fgk_instituicao' => $fgk_instituicao, 
	'curso' => $curso,
	'matricula' => $matricula,
	'departamento' => $departamento
    );
    
    if($db->atualizar('es_inscritos', $dados, 'email', $email)) 
      echo "sucesso";
    else 
      echo "Houve um erro ao atualizar seus dados";
    
    

  } catch(PDOException $e) {
    echo $e->getMessage();

  }




