<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	$id_grupo = $_POST['id_grupo'];
	
	//aqui pega todos os módulos do grupo enviado
	$qryGrupo = "
		SELECT * FROM desk_grupos_modulos INNER JOIN desk_modulos ON fgk_modulo = id_modulo WHERE fgk_grupo = '$id_grupo' AND desk_modulos.bool_ativo = 1 ORDER BY nome_modulo ASC";
	$qry = mysqli_query($mysqli,$qryGrupo) or die(mysqli_error($mysqli));	
	//echo $qryGrupo;

	$grupoModulos = array();
	while($registro = mysqli_fetch_assoc($qry)) {
		$grupoModulos[] = $registro['id_modulo'];
	}
	
	//aqui pega todos os módulos do sistema
	$queryString = "
		SELECT * FROM desk_modulos WHERE desk_modulos.bool_ativo = 1 ORDER BY nome_modulo ASC";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));	
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id = $registro['id_modulo'];		
		//aqui verifica quais módulos do sistema estão no grupo
		if(in_array($id, $grupoModulos)){
			$registro['bool_liberado'] = true;
		}
		else{
			$registro['bool_liberado'] = false;			
		}
		$registro['id_grupo'] = $id_grupo;
	    $resposta[] = $registro;
	}
	echo json_encode(array(
		"success" => mysqli_errno($mysqli) == 0,
		"resultado" => $resposta
	));
?>