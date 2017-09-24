<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
if ( $_SESSION['logado'] === true ) {
    include "header.php";
    include "menu.php";
    $id_minicurso = filter_input(INPUT_GET, 'id');
    $sql_minicurso = "SELECT * FROM es_minicursos WHERE es_minicursos.id= ?";
    $dados_minicurso = $db->sql_query($sql_minicurso, array('es_minicursos.id'=>$id_minicurso));
    foreach ($dados_minicurso as $minicurso) {
        $apresentador = $minicurso->apresentador;
        $classificacao = $minicurso->classificacao;
        $data = $minicurso->data;
        $hora_ini = $minicurso->hora_ini;
        $hora_fim = $minicurso->hora_fim;
        $local = $minicurso->local;
        $max_alunos = $minicurso->max_alunos;
        $resumo = $minicurso->resumo;
        $titulo = $minicurso->titulo;
             
    }

    $verificar_inscricao = $db->sql_query("SELECT COUNT(*) as inscrito FROM es_minicursos_inscritos LEFT JOIN es_inscritos_servicos ON fgk_inscrito_servico = id_inscrito_servico WHERE fgk_minicurso = ? AND fgk_inscrito =?", array('fgk_minicurso'=>$id_minicurso, 'fgk_inscrito'=>$_SESSION['id_inscrito']));
    foreach ($verificar_inscricao as $key) {
       $inscrito = $key->inscrito;
    }
    if($inscrito == 0){
        $botao_inscricao  = '<button type="submit" id="submeter" class="btn btn-success tamanho">Quero inscrever-me</button>';
    } else {
        $verificar_inscricao = $db->sql_query("SELECT *, es_minicursos_inscritos.id as id_minicurso_inscrito
                                                                                                FROM es_minicursos_inscritos
                                                                                                inner join es_inscritos_servicos on es_minicursos_inscritos.fgk_inscrito_servico = es_inscritos_servicos.id_inscrito_servico
                                                                                                left join es_inscritos_boletos on es_inscritos_boletos.id_boleto = es_inscritos_servicos.fgk_boleto
                                                                                                WHERE es_minicursos_inscritos.fgk_minicurso = ? and es_inscritos_servicos.fgk_inscrito = ?" , 
                                                                                                array('es_minicursos_inscritos.fgk_minicurso' => $id_minicurso, 'es_inscritos_servicos.fgk_inscrito'=>$_SESSION['id_inscrito']) );
        foreach ($verificar_inscricao as $registro) {
            $chave = $registro->chave;
            $id_boleto = $registro->id_boleto;
            $id_minicurso_inscrito = $registro->id_minicurso_inscrito;
            $id_inscrito_servico = $registro->fgk_inscrito_servico;
        }
        $botao_inscricao  = '<input type="hidden" id="id_inscrito_servico" value="'.$id_inscrito_servico.'"><input type="hidden" id="id_minicurso_inscrito" value="'.$id_minicurso_inscrito.'"><input type="hidden" id="chave" value="'.$chave.'"><input type="hidden" id="id_boleto" value="'.$id_boleto.'"><button class="btn btn-warning tamanho" id="cancelar">Cancelar Inscrição</button>';
    }
    
?>  
<style>
.tamanho {
    width:180px;
}        
    
</style>
            <div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Inscrição em Minicurso</a></li>
                        </ol>
                    </div>
                </div>
                <div id="processando" class="modal fade modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Encontro de Saberes</h4>
                            </div>
                            <div class="modal-body">
                                Aguarde, carregando...
                            </div>
                        </div>

                    </div>
                </div>                    
                <div id="main-wrapper">
                    <div class="row">
                        <div class="panel panel-white">
                            <div class="panel-body"> 
                                <div class="col-md-6">                                   
                                    
                                    <div class="form-group">
                                        
                                        <label for="area"><strong>Título:</strong> <?=$titulo;?></label>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Apresentador(a):</strong> <?=$apresentador;?></label>
                                        <p></p>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Data:</strong> <?=date('d/m/Y', strtotime($data));?></label>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Local: </strong><?=$local;?></label>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Horário: </strong><?=$hora_ini.' - '.$hora_fim;?></label>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Vagas: </strong><?=$max_alunos;?></label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Resumo</strong></label>
                                        <p class="text-justify"><?=$resumo;?></p>
                                    </div>
                                    <form id="form_trabalho" name="form_trabalho" action="javascript:void(0);">
                                        <input type="hidden" id="id_minicurso" value="<?=$id_minicurso;?>">
                                        <input type="hidden" id="id_inscrito" value="<?=$id_inscrito;?>">
                                        <input type="hidden" id="titulo" value="<?=$titulo;?>">
                                        <input type="hidden" id="data" value="<?=date('d/m/Y', strtotime($data));?>">
                                        <input type="hidden" id="local" value="<?=$local;?>">
                                        <input type="hidden" id="hora_ini" value="<?=$hora_ini;?>">
                                        <input type="hidden" id="hora_fim" value="<?=$hora_fim;?>">
                                        <input type="hidden" id="tipo_inscrito" value="<?=$_SESSION['id_tipo_inscrito'];?>">
                                        
                                        <div class="text-center">
                                            <?=$botao_inscricao;?>
                                            <a href="minicursos.php" class="btn btn-danger tamanho">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div>
               
<?php
    include "footer.php";
 }
?>

    <script src="assets/js/pages/inscrever_minicurso.js"></script>
</body>
</html>