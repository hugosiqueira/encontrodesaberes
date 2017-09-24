<?php
    include "../config.php";
    
    $requestData= $_REQUEST;
    
    $columns = array(
        0 => 'cod_poster',
        1 => 'apresentador',
        2 => 'titulo',
        3 => 'horario',
        4 => 'nome',
        5 => 'instituicao',
        6 => 'fgk_trabalho'
    );
    
    $sql = "SELECT COUNT(*) as contar
FROM `es_trabalho_apresentacao` 
LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
LEFT JOIN es_instituicao ON es_trabalho.fgk_instituicao = es_instituicao.id
            WHERE es_trabalho.fgk_evento = ".EVENTO_ATUAL;
    $query = $db->sql_query($sql);
    foreach ($query as $query) {
        $totalData = $query->contar;
    }
    $totalFiltered = $totalData;

    if(!empty($requestData['search']['value'])){
        $sql = "SELECT cod_poster,
		CONCAT(DATE_FORMAT(dia, '%d/%m/%Y'), '  ', DATE_FORMAT(hora_ini,'%H:%i'), ' - ', DATE_FORMAT(hora_fim,'%H:%i')) as horario,  es_sessao.sessao,  
		IF( titulo_revisado IS NULL , titulo_enviado, titulo_revisado ) AS titulo, es_trabalho_apresentacao.fgk_trabalho,es_instituicao.sigla as instituicao
            FROM `es_trabalho_apresentacao` 
LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
LEFT JOIN es_instituicao ON es_trabalho.fgk_instituicao = es_instituicao.id
            WHERE es_trabalho.fgk_evento = ".EVENTO_ATUAL." ";
        $sql .= " and ( titulo_enviado  LIKE '%".$requestData['search']['value']."%' ";
        $sql .= " OR titulo_revisado LIKE '%".$requestData['search']['value']."%' )";
        $query = $db->sql_query($sql);
        if(!$query){
            echo "Erro ao executar a pesquisa.";
            exit();
        }
        $sql_cont = "SELECT COUNT(*) as contar
            FROM `es_trabalho_apresentacao` 
LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
LEFT JOIN es_instituicao ON es_trabalho.fgk_instituicao = es_instituicao.id
            WHERE es_trabalho.fgk_evento = ".EVENTO_ATUAL;
        $sql_cont .= " AND ( titulo_enviado  LIKE '%".$requestData['search']['value']."%'"
                . " OR titulo_revisado LIKE '%".$requestData['search']['value']."%' )";
        $query_cont = $db->sql_query($sql_cont);
        foreach ($query_cont as $key) {
            $totalFiltered = $key->contar;
        }
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $db->sql_query($sql);
        if(!$query){
            echo "Erro ao listar os contratos";
            exit();
        }
    } else {
        $sql = "SELECT cod_poster,
		CONCAT(DATE_FORMAT(dia, '%d/%m/%Y'), '  ', DATE_FORMAT(hora_ini,'%H:%i'), ' - ', DATE_FORMAT(hora_fim,'%H:%i')) as horario,  es_sessao.sessao,  
		IF( titulo_revisado IS NULL , titulo_enviado, titulo_revisado ) AS titulo, es_trabalho_apresentacao.fgk_trabalho,es_instituicao.sigla as instituicao
            FROM `es_trabalho_apresentacao` 
LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
LEFT JOIN es_instituicao ON es_trabalho.fgk_instituicao = es_instituicao.id
            WHERE es_trabalho.fgk_evento = ".EVENTO_ATUAL;
        
        if( !empty($requestData['columns'][2]['search']['value']) ){  
            $sql.=" AND (titulo_revisado LIKE '%".$requestData['columns'][2]['search']['value']. "%' OR titulo_enviado LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
        }
        
        $sql_cont = "SELECT COUNT(*) as contar
            FROM `es_trabalho_apresentacao` 
LEFT JOIN es_sessao ON es_sessao.id = es_trabalho_apresentacao.fgk_sessao
LEFT JOIN es_trabalho ON es_trabalho.id = es_trabalho_apresentacao.fgk_trabalho
LEFT JOIN es_instituicao ON es_trabalho.fgk_instituicao = es_instituicao.id
            WHERE es_trabalho.fgk_evento = ".EVENTO_ATUAL;
       
        if( !empty($requestData['columns'][2]['search']['value']) ){  
            $sql.=" AND (titulo_revisado LIKE '%".$requestData['columns'][2]['search']['value']. "%' OR titulo_enviado LIKE '%".$requestData['columns'][2]['search']['value']."%' )";
        }
        $query_cont = $db->sql_query($sql_cont);
        foreach ($query_cont as $key) {
            $totalFiltered = $key->contar;
        }

        $sql .=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $query = $db->sql_query($sql);


        if(!$query){
            echo "Erro ao listar os trabalhos";
            exit();
        }

    }

    $data = array();
 
    foreach ($query as $result) {
        $id_trabalho = $result->fgk_trabalho;
            $apresentadores = "";
            $sql_autores = $db->sql_query("Select nome 
                                from es_trabalho_autor
                                where bool_apresentador = 1 and fgk_trabalho = ?
                                order by nome", array("fgk_trabalho"=>$id_trabalho));
            foreach ($sql_autores as $key) {
                $apresentadores = $apresentadores." ".$key->nome."<br>";
            }

        $nestedData = array();
        $nestedData[] = $result->cod_poster;
        //$nestedData[] = $result->apresentador;
        $nestedData[] = $apresentadores;
        $nestedData[] = $result->titulo;
        $nestedData[] = $result->horario;
        $nestedData[] = $result->sessao;
        $nestedData[] = $result->instituicao;
        $nestedData[] = $result->fgk_trabalho;
        
        $data[] = $nestedData;
        
    }

    
    $json_data = array(
			"draw"            => intval( $requestData['draw'] ),   
            "recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data   
			);
    
    echo json_encode($json_data);