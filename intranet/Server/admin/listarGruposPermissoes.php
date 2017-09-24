<?php	
	header('Content-Type: application/json; charset=utf-8');
	require_once("../../includes/db_connect.php");
	$id_modulo = $_POST['id_modulo'];
	$id_grupo = $_POST['id_grupo'];
	
	
	$qryGrupo = "
		SELECT distinct(id_permissao), desk_permissoes.*
		FROM desk_permissoes
		 INNER JOIN desk_grupos_permissoes ON fgk_permissao = id_permissao
		 INNER JOIN desk_grupos_modulos ON desk_grupos_modulos.fgk_grupo = desk_grupos_permissoes.fgk_grupo
		 WHERE desk_grupos_modulos.fgk_grupo = '$id_grupo' AND desk_grupos_modulos.fgk_modulo = '$id_modulo' ORDER BY permissao";
	// echo $qryGrupo;
	$qry = mysqli_query($mysqli,$qryGrupo) or die(mysqli_error($mysqli));	
	$grupoPermissoes = array();
	while($registro = mysqli_fetch_assoc($qry)) {
		$grupoPermissoes[] = $registro['id_permissao'];
	}
	
	
	$queryString = "
		SELECT * FROM desk_permissoes WHERE desk_permissoes.fgk_modulo = '$id_modulo' ORDER BY permissao ASC";
	$query = mysqli_query($mysqli,$queryString) or die(mysqli_error($mysqli));	
	
	$resposta = array();
	while($registro = mysqli_fetch_assoc($query)) {
		$id = $registro['id_permissao'];		
		if(in_array($id, $grupoPermissoes)){
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