<?php 
// Dados da conexão com o banco de dados
define('SERVER', 'localhost');
define('DBNAME', 'esaberes_encontrosaberes');
define('USER', 'root');
define('PASSWORD', '91337368');

// Recebe os parâmetros enviados via GET
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';

// Configura uma conexão com o banco de dados
$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
$conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME, USER, PASSWORD, $opcoes);

// Verifica se foi solicitado uma consulta para o autocomplete
if($acao == 'autocomplete'):
	$where = (!empty($parametro)) ? 'WHERE titulo LIKE ?' : '';
	$sql = "SELECT es_area_especifica.id as id_area_especifica, es_projeto.titulo, es_area_especifica.descricao_area_especifica FROM es_projeto LEFT JOIN es_area_especifica ON fgk_area_especifica = es_area_especifica.id " . $where;

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, '%'.$parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;

// Verifica se foi solicitado uma consulta para preencher os campos do formulário
if($acao == 'consulta'):
	$sql = "SELECT es_area_especifica.id as id_area_especifica, es_projeto.titulo, es_area_especifica.descricao_area_especifica FROM es_projeto LEFT JOIN es_area_especifica ON fgk_area_especifica = es_area_especifica.id ";
	$sql .= "WHERE titulo LIKE ? LIMIT 1";

	$stm = $conexao->prepare($sql);
	$stm->bindValue(1, $parametro.'%');
	$stm->execute();
	$dados = $stm->fetchAll(PDO::FETCH_OBJ);

	$json = json_encode($dados);
	echo $json;
endif;