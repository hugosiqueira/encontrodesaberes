<?php

	/**
	 * função que devolve em formato JSON os dados do inscrito
	 */
	function retorna( $cpf )
	{

	include("../config.php");

	$sql = "SELECT * FROM es_ufop_alunos 
	INNER JOIN es_ufop_cursos ON es_ufop_alunos.fgk_curso = es_ufop_cursos.codigo 
	INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_cursos.fgk_departamento
	WHERE es_ufop_alunos.cpf = ? ";

	$existe_aluno = $db->existe("es_ufop_alunos", array("es_ufop_alunos.cpf" => $cpf));
	$existe_professor = $db->existe("es_ufop_professores", array("es_ufop_professores.cpf" => $cpf, 'fgk_tipo'=> 1));
	$existe_tecnico = $db->existe("es_ufop_professores", array("es_ufop_professores.cpf" => $cpf, 'fgk_tipo'=> 2));
	$existe_inscricao = $db->existe("es_inscritos", array("cpf"=>$cpf));
	
	if($existe_aluno){

		$query = $db->sql_query( $sql, array("es_ufop_alunos.cpf" => $cpf));

		$arr = Array();

		foreach ($query as $aluno) {
				$arr['nome'] = $aluno->nome;
				$arr['email'] = $aluno->email;
				$arr['bool_monitoria'] = $aluno->bool_monitoria;
				$arr['mobilidade_ano_passado'] = $aluno->mobilidade_ano_passado;
				$arr['mobilidade_ano_atual'] = $aluno->mobilidade_ano_atual;
				$arr['bool_ufop'] = 1;
				$arr['bool_aluno'] = 1;
				$arr['instituicao'] = 1;
				$arr['matricula'] = $aluno->matricula;
				$arr['tipo_inscricao'] = 1;
				$arr['id_departamento'] = $aluno->id_departamento;
				$arr['departamento'] = $aluno->nome_departamento;
				$arr['id_curso'] = $aluno->id_curso;
				$arr['curso'] = $aluno->descricao_curso." - ".$aluno->modalidade;
		}

		$inscrito = $db->sql_query("SELECT valor_servico
			FROM es_inscritos_tipos
			INNER JOIN es_servicos ON fgk_servico_inscricao = id_servico
			WHERE id_tipo_inscrito= ? ", array("id_tipo_inscrito" => 1));

		foreach ( $inscrito as $valor ){
			$arr['valor_inscricao'] = 'R$' . number_format($valor->valor_servico/100, 2, ',', '.');
			//$arr['valor_minicurso'] = $valor->valor_minicurso;
		}
	}

	// caso o professor também seja aluno irá prevalecer os dados de professor
	if($existe_professor){

		$sql = "SELECT * FROM es_ufop_professores
				INNER JOIN es_ufop_departamentos ON es_ufop_departamentos.id_departamento = es_ufop_professores.fgk_departamento
				WHERE `cpf` = ? ";

		$query = $db->sql_query( $sql, array("es_ufop_professores.cpf" => $cpf));
		$arr = Array();

		foreach ($query as $professor) {
			$arr['nome'] = $professor->nome;
			$arr['email'] = $professor->email;
			$arr['bool_ufop'] = 1;
			$arr['bool_aluno'] = 0;
			$arr['instituicao'] = 1;
			$arr['id_departamento'] = $professor->id_departamento;
			$arr['departamento'] = $professor->nome_departamento;
			$arr['tipo_inscricao'] = 2;
			$arr['bool_monitoria'] = $professor->bool_monitoria;
		}

		$inscrito = $db->sql_query("SELECT valor_servico
			FROM es_inscritos_tipos
			INNER JOIN es_servicos ON fgk_servico_inscricao = id_servico
			WHERE id_tipo_inscrito= ? ", array("id_tipo_inscrito" => 2));

		foreach ( $inscrito as $valor ){
			$arr['valor_inscricao'] = 'R$' . number_format($valor->valor_servico/100, 2, ',', '.');
			$arr['valor_minicurso'] = $valor->valor_minicurso;
		}

	}

	if($existe_tecnico){
		$sql = "SELECT *
		FROM `es_ufop_professores`
		WHERE `cpf` = ? ";
		$query = $db->sql_query( $sql, array("es_ufop_professores.cpf" => $cpf));
		$arr = Array();

		foreach ($query as $professor) {
			$arr['nome'] = $professor->nome;
			$arr['email'] = $professor->email;
			$arr['bool_ufop'] = 1;
			$arr['bool_aluno'] = 0;
			$arr['instituicao'] = 1;
			$arr['id_departamento'] = '';
			$arr['departamento'] = '';
			$arr['tipo_inscricao'] = 6;
			$arr['id_curso'] = '';
			$arr['curso'] = '';
			$arr['bool_monitoria'] = $professor->bool_monitoria;
		}

		$inscrito = $db->sql_query("SELECT valor_servico
			FROM es_inscritos_tipos
			INNER JOIN es_servicos ON fgk_servico_inscricao = id_servico
			WHERE id_tipo_inscrito= ? ", array("id_tipo_inscrito" => 6));

		foreach ( $inscrito as $valor ){
			$arr['valor_inscricao'] = 'R$' . number_format($valor->valor_servico/100, 2, ',', '.');
			//$arr['valor_minicurso'] = $valor->valor_minicurso;
		}
	}
	
	if($existe_inscricao){
		$sql = "SELECT *
		FROM `es_inscritos`
		WHERE `cpf` = ? ";
		$query = $db->sql_query( $sql, array("cpf" => $cpf));
		if(!$existe_professor && !$existe_aluno && !$existe_tecnico && !$existe_inscricao){
			$arr = Array();
		}
		foreach ($query as $inscricao) {
			$arr['nome'] = $inscricao->nome;
			$arr['email'] = $inscricao->email;
			$arr['email_alternativo'] = $inscricao->email_alternativo;
			$arr['cep'] = $inscricao->cep;
			$arr['cidade'] = $inscricao->cidade;
			$arr['bairro'] = $inscricao->bairro;
			$arr['endereco'] = $inscricao->endereco;
			$arr['numero'] = $inscricao->numero;
			$arr['complemento'] = $inscricao->complemento;
			$arr['estado'] = $inscricao->estado;
			$arr['telefone'] = $inscricao->telefone;
			$arr['telefone_celular'] = $inscricao->telefone_celular;
			$arr['bool_monitoria'] = $inscricao->bool_monitoria;
		}
	}
	
	if(!$existe_professor && !$existe_aluno && !$existe_tecnico && !$existe_inscricao){
		$arr['nome'] = ' ';
		$arr['email'] = ' ';
		$arr['curso'] = ' ';
		$arr['instituicao'] = ' ';
		$arr['matricula'] = ' ';	
		$arr['departamento'] = ' ';
		$arr['bool_monitoria'] = 0;
	}
	$arr['bool_temp'] = 0;
	$temp = $db->sql_query("SELECT * FROM es_inscritos WHERE cpf = ?", array('cpf'=>$cpf));
	foreach ($temp as $registro) {
		$arr['bool_temp'] = $registro->bool_temp;
	}
	
	return json_encode( $arr );

}

/* só se for enviado o parâmetro, que devolve os dados */
if( isset($_GET['cpf']) )
{
	echo retorna( $_GET['cpf'] );
}
