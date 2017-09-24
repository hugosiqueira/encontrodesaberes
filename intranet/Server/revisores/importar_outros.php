<?php
	require_once("../../includes/functions.php");
	require_once("../../includes/PHPExcel-1.8/Classes/PHPExcel.php");
	sec_session_start();

	$id_evento_atual = $_SESSION['id_evento_atual'];

	// mask($cpf,'###.###.###-##');

	$path = "planilhas/outros.xls";
	$fileObj = \PHPExcel_IOFactory::load( $path );
	$sheetObj = $fileObj->setActiveSheetIndex(0);
	$startFrom = 2;
	$limit = 714;
	$i=0;
	$db->iniciar_transacao();
	foreach( $sheetObj->getRowIterator(2, $limit) as $row ){
		$dados = array();
		foreach( $row->getCellIterator() as $cell ){
			$value = $cell->getCalculatedValue();
			$dados[] = $value;
		}
		// NOME CPF EMAIL DEPARTAMENTO AREA AREAESPECIFICA
		if(strlen($dados[1])<14){
			$p1 = substr($dados[1], 0, 3);
			$p2 = substr($dados[1], 3, 3);
			$p3 = substr($dados[1], 6, 3);
			$p4	= substr($dados[1], 9, 2);
			$dados[1] = "$p1.$p2.$p3-$p4";
		}
		$area_especifica = $db->listar('es_area_especifica', 'descricao_area_especifica', trim($dados[5]));
		// echo '<b>'.$i.'</b> '.$dados[1].' '.$area_especifica->fgk_area.' '.$area_especifica->id;
		$busca = "
			SELECT es_avaliacao_revisor.id
			FROM es_avaliacao_revisor
			 INNER JOIN es_inscritos ON es_inscritos.id = es_avaliacao_revisor.fgk_inscrito
			WHERE es_inscritos.fgk_evento = 8 AND es_inscritos.cpf = ?
		";
		$busca = $db->sql_query($busca, array($dados[1]));
		if($busca->rowCount() > 0){
			foreach($busca as $revisor);
			echo json_encode(array(
				"msg" => "Já existe um revisor cadastrado com este CPF no evento."
			));
			$db->atualizar('es_avaliacao_revisor', array('fgk_area'=>$area_especifica->fgk_area,'fgk_area_especifica'=>$area_especifica->id), 'id', $revisor->id);
			// echo $revisor->id;
		}
		else{
			$sqlInscrito = "SELECT es_inscritos.* FROM es_inscritos WHERE es_inscritos.fgk_evento = 8 AND es_inscritos.cpf = ? ";
			$qryInscrito = $db->sql_query($sqlInscrito, array($dados[1]));
			if($qryInscrito->rowCount() > 0){
				foreach( $qryInscrito as $inscrito );
				$db->atualizar('es_inscritos', array('bool_revisor'=>1), 'id', $inscrito->id);
				$novo_revisor = array(
					'fgk_inscrito'			=> $inscrito->id,
					'fgk_area'				=> $area_especifica->fgk_area,
					'fgk_area_especifica'	=> $area_especifica->id,
					'bool_avaliador_prograd'=> 0,
					'bool_avaliador_proex'	=> 0,
					'bool_avaliador_caint'	=> 0
				);
				$db->inserir('es_avaliacao_revisor', $novo_revisor);
			}
			else{
				$novo_inscrito_temporario = array(
					'fgk_evento'		=> 8,
					'fgk_instituicao'	=> 1,
					'fgk_tipo'			=> 2,
					'cpf'				=> $dados[1],
					'email'				=> $dados[2],
					'nome'				=> $dados[0],
					'fgk_area_coordenacao'	=> 0,
					'bool_revisor'		=> 1,
					'bool_temp'			=> 1
				);
				$db->inserir('es_inscritos', $novo_inscrito_temporario);
				$id_inscrito_temporario = $db->lastInsertId();
				$novo_revisor = array(
					'fgk_inscrito'			=> $id_inscrito_temporario,
					'fgk_area'				=> $area_especifica->fgk_area,
					'fgk_area_especifica'	=> $area_especifica->id,
					'bool_avaliador_prograd'=> 0,
					'bool_avaliador_proex'	=> 0,
					'bool_avaliador_caint'	=> 0
				);
				$db->inserir('es_avaliacao_revisor', $novo_revisor);
			}
		}
		echo '<br>';
	}
	echo $i;
	$db->commit();


?>