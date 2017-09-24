<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once '../../includes/functions.php';
	require_once('../../includes/db_connect.php');
	sec_session_start();

	foreach ($_REQUEST as $key => $value){  // Limpa os requests vazios e não definidos
		if(($value == "undefined") || $value == "" || ($value == -1))
			unset($_REQUEST[$key]);
	}

	$fgk_evento = $_SESSION['id_evento_atual'];

		$filtros = array();
		$queryString = "
			SELECT TRIM(es_inscritos.nome_cracha) AS nome, es_inscritos.id, es_instituicao.nome AS nome_inst, 
			SUM(CASE WHEN es_inscritos_servicos.bool_pago = 1 THEN 1 ELSE 0 END) serv_pg,
			SUM(CASE WHEN es_inscritos_servicos.fgk_inscrito = es_inscritos.id THEN 1 ELSE 0 END) servs
			FROM es_inscritos
			 INNER JOIN es_inscritos_tipos ON es_inscritos_tipos.id_tipo_inscrito = es_inscritos.fgk_tipo
			 INNER JOIN es_instituicao ON es_instituicao.id = es_inscritos.fgk_instituicao
			 LEFT JOIN es_presencas ON es_inscritos.id = es_presencas.fgk_inscrito
			 LEFT JOIN es_inscritos_servicos ON es_inscritos.id = es_inscritos_servicos.fgk_inscrito 
			WHERE 1 AND es_inscritos.fgk_evento = ?
		";
		$filtros[] = $fgk_evento;

		if(isset($_REQUEST['mobilidade_ano_passado'])){
			$queryString.= " AND es_inscritos.mobilidade_ano_passado = ?";
			$filtros[] = $_REQUEST['mobilidade_ano_passado'];
		}

		if(isset($_REQUEST['bool_monitoria'])){
			$queryString.= " AND es_inscritos.bool_monitoria = ?";
			$filtros[] = $_REQUEST['bool_monitoria'];
		}

		if(isset($_REQUEST['bool_temp'])){
			$queryString.= " AND es_inscritos.bool_temp = ?";
			$filtros[] = $_REQUEST['bool_temp'];
		}

		if(isset($_REQUEST['conta_ativada'])){
			$queryString.= " AND es_inscritos.conta_ativada = ?";
			$filtros[] = $_REQUEST['conta_ativada'];
		}

		if(isset($_REQUEST['bool_coordenador'])){
			$queryString.= " AND es_inscritos.bool_coordenador = ?";
			$filtros[] = $_REQUEST['bool_coordenador'];
		}

		if(isset($_REQUEST['bool_revisor'])){
			$queryString.= " AND es_inscritos.bool_revisor = ?";
			$filtros[] = $_REQUEST['bool_revisor'];
		}

		/////////

		if(isset($_REQUEST['cpf'])){
			$queryString.= " AND es_inscritos.cpf = ?";
			$filtros[] = $_REQUEST['cpf'];
		}

		if(isset($_REQUEST['fgk_curso'])){
			$queryString.= " AND es_inscritos.fgk_curso = ?";
			$filtros[] = $_REQUEST['fgk_curso'];
		}

		if(isset($_REQUEST['departamento'])){
			$queryString.= " AND nome_departamento = ?";
			$filtros[] = $_REQUEST['departamento'];
		}

		if(isset($_REQUEST['fgk_departamento'])){
			$queryString.= " AND es_inscritos.fgk_departamento = ?";
			$filtros[] = $_REQUEST['fgk_departamento'];
		}

		if(isset($_REQUEST['bool_cracha'])&&($_REQUEST['bool_cracha']!='-1') ){
			$queryString.= " AND es_inscritos.bool_cracha = ?";
			$filtros[] = $_REQUEST['bool_cracha'];
		}

		if(isset($_REQUEST['bool_isento'])&&($_REQUEST['bool_isento']!='-1')){
			$queryString.= " AND es_inscritos.bool_isento = ?";
			$filtros[] = $_REQUEST['bool_isento'];
		}

		if(isset($_REQUEST['fgk_instituicao'])){
			$queryString.= " AND es_inscritos.fgk_instituicao = ?";
			$filtros[] = $_REQUEST['fgk_instituicao'];
		}

		if(isset($_REQUEST['fgk_tipo'])&&($_REQUEST['fgk_tipo']!='')){
			$queryString.= " AND es_inscritos.fgk_tipo = ?";
			$filtros[] = $_REQUEST['fgk_tipo'];
		}

		if(isset($_REQUEST['bool_cracha'])&&($_REQUEST['bool_cracha']!='-1')){
			$queryString.= " AND es_inscritos.bool_cracha = ?";
			$filtros[] = $_REQUEST['bool_cracha'];
		}

		if(isset($_REQUEST['buscaRapida']) && ($_REQUEST['buscaRapida'] != "undefined")){
			$buscaRapida = $_REQUEST['buscaRapida'];
			$queryString.= " AND (
				es_inscritos.nome 		LIKE ? OR
				es_inscritos.matricula 		LIKE ? OR
				es_inscritos.curso 			LIKE ? OR
				es_inscritos.departamento 				LIKE ? OR
				es_inscritos.cpf 				LIKE ?
			)";
			array_push($filtros,'%'.$buscaRapida.'%','%'.$buscaRapida.'%','%'.$buscaRapida.'%','%'.$buscaRapida.'%','%'.$buscaRapida.'%');
		}

		$queryString.=" GROUP BY es_inscritos.id ";

		//status-> pendente = 0 homologada = 1 credenciado = 2
			if(isset($_REQUEST['status']) && ($_REQUEST['status'] != '')){
				$quite = intval($_REQUEST['status']);
				if($quite == 0)
					$queryString.=" HAVING (servs != serv_pg) AND (servs != 0) ";
				if($quite == 1)
					$queryString.=" HAVING (servs = serv_pg) AND (servs != 0) ";
				if($quite == 2)
					$queryString.=" HAVING (credencial = 1) ";
			}

		$result = $db->sql_query2($queryString.=" ORDER BY es_inscritos.nome ASC", $filtros);

		$total = $result->rowCount();

		/////////////////////////////////////////////
		/////////////// ETIQUETAS ///////////////

		$linhas = "<table border='0' class='page-break'>";
		$etiqueta = '';
		$contEtiquetas = 1;
		$contLinhas = 0;

		foreach($result as $inscrito){

			$id = $inscrito->id;
			$nomes = explode(' ', ucwords(mb_strtolower($inscrito->nome, 'UTF-8')));
			$primeiro_nome = array_shift($nomes);
			$ultimo_nome = array_pop($nomes);
			$nome_credencial = $primeiro_nome." ".$ultimo_nome;
			$barcode = str_pad($id.$fgk_evento,10,'0', STR_PAD_BOTH);
			$nome_inst = $inscrito->nome_inst;

			if(($nome_inst == "Outra")||($nome_inst == "Outras Instituições"))
				$nome_inst = '';

		    $etiqueta="<td><center><b><font size='5'>".$nome_credencial."</font></b></br><font face='BarCode' size='40'>*".$barcode."*</font></br>".$nome_inst."</center></td>";

		    if($contLinhas == 7){
	    		$linhas.="</table><table border='0' class='page-break'>".$etiqueta;
		    	$contEtiquetas++;
		    	$contLinhas = 0;
	    	}else if($contEtiquetas == 1){
		    	$linhas.="<tr>".$etiqueta;
		    	$contEtiquetas++;
	    	}else if($contEtiquetas == 2){
	    		$linhas.=$etiqueta."</tr>";
	    		$contEtiquetas = 1;
	    		$contLinhas++;
	    	}
		}

		$pagina = "<html>
				<title>".$total." Etiquetas.</title>
				<head>
					<style>
						@media print{
							.page-break	{ 
								display: block; 
								page-break-after: always !important; 
							}
						}

						@font-face { 
							font-family: 'BarCode';
							src: url('../../resources/css/font/barcode.ttf');
							font-style: normal;
							font-weight: 400;
						}

						header{
							padding: 80px;
						}

						table{
							align: 'left';
							width: 900px; 
							font-family: Tahoma; 
							font-size: small; 
							table-layout: fixed;
							margin-top: 2cm;
						}

						table td{
							width: 450px;
						    height: 150px;
						    word-break: break-all;
						}
					</style>
				</head>
				<body>
					".$linhas."
				</body>
			</html>";

		echo($pagina);
?>