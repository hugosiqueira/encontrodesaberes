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
    $id_trabalho = filter_input(INPUT_GET, 'id');
    $bool_caint = filter_input(INPUT_GET, 'bool_caint');
    $atualizar = filter_input(INPUT_GET, 'atualizar');
   
    
?>          
<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.base.css" type="text/css">
<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.classic.css" type="text/css">
<div class="page-inner">
    <div class="page-title">
        <h3>Encontro de Saberes</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="index.php">Submeter trabalhos</a></li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <?php
            if((BOOL_COORDENADOR || TIPO_USUARIO == ADMINISTRADOR) && $atualizar == 1 ) { ?>
                <div class="col-md-12">
                    <div class="panel panel-white">  
                            <div class="panel-body input-group">
                                <h3>Alterar Avaliadores</h3>
                                <div class="col-md-5">     
                                    <div class="form-group" id="fgk_revisor1" >

                                        
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" id="fgk_revisor2">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger" id="alocar_avaliadores" style="margin-top: 20px;">Trocar Avaliadores</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
            <?php } ?>
            <?php
            
            if($bool_caint == 0){
                $sql_projeto = "SELECT  es_area_especifica.descricao_area_especifica, 
                                        es_ufop_areas.descricao_area,
                                        es_trabalho.resumo_enviado, 
                                        es_trabalho.titulo_enviado,
                                        responsavel.nome as nome_responsavel,
                                        inscrito1.nome AS nome_revisor1, 
                                        revisor1.id as id_revisor1,
                                        revisor2.id as id_revisor2,
                                        tipo1.descricao_tipo AS tipo_revisor1,
                                        inscrito2.nome AS nome_revisor2, 
                                        tipo2.descricao_tipo AS tipo_revisor2,
                                        es_trabalho.datahora_submissao
                                FROM es_trabalho
                                LEFT JOIN es_avaliacao ON es_trabalho.id = es_avaliacao.fgk_trabalho
                                LEFT JOIN es_inscritos AS responsavel on responsavel.id  = es_trabalho.fgk_inscrito_responsavel
                                LEFT JOIN es_area_especifica ON  es_area_especifica.id = es_trabalho.fgk_area_especifica
                                LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho.fgk_area
                                LEFT JOIN es_avaliacao_revisor AS revisor1 ON revisor1.id = es_avaliacao.fgk_revisor1
                                LEFT JOIN es_inscritos AS inscrito1 ON inscrito1.id = revisor1.fgk_inscrito
                                LEFT JOIN es_inscritos_tipos AS tipo1 ON tipo1.id_tipo_inscrito = inscrito1.fgk_tipo
                                LEFT JOIN es_avaliacao_revisor AS revisor2 ON revisor2.id = es_avaliacao.fgk_revisor2
                                LEFT JOIN es_inscritos AS inscrito2 ON inscrito2.id = revisor2.fgk_inscrito
                                LEFT JOIN es_inscritos_tipos AS tipo2 ON tipo2.id_tipo_inscrito = inscrito2.fgk_tipo
                                WHERE es_trabalho.id =?";
                $dados_projeto = $db->sql_query($sql_projeto, array('es_trabalho.id'=>$id_trabalho));
            
                foreach ($dados_projeto as $projeto) {
                    $descricao_area_especifica = $projeto->descricao_area_especifica;
                    $descricao_area = $projeto->descricao_area;
                    $titulo_enviado = $projeto->titulo_enviado;
                    $resumo_enviado = $projeto->resumo_enviado; 
                    $nome_revisor1 = $projeto->nome_revisor1;
                    $nome_revisor2 = $projeto->nome_revisor2;
                    $id_revisor1 = $projeto->id_revisor1;
                    $id_revisor2 = $projeto->id_revisor2;
                    $nome_responsavel = $projeto->nome_responsavel;
                    $datahora_submissao = strtotime($projeto->datahora_submissao);
                    $datahora_submissao =  date('d/m/Y H:i:s', $datahora_submissao);
                    if(empty($projeto->datahora_submissao))
                            $datahora_submissao = "";

                }

                $sql_autor = "SELECT * from es_trabalho_autor LEFT JOIN es_tipo_autor ON es_tipo_autor.id_tipo_autor = es_trabalho_autor.fgk_tipo_autor WHERE fgk_trabalho = ? ORDER BY ordenacao";
                $dados_autor = $db->sql_query($sql_autor, array('fgk_trabalho'=>$id_trabalho));
                foreach ($dados_autor as $autor) {
                    if($autor->fgk_tipo_autor == 1){
                        $nome_autor = $autor->nome;
                    } else if ($autor->fgk_tipo_autor == 2){
                        $nome_orientador = $autor->nome;
                    }
                }
                
            ?>
          
            <div class="col-md-12">
                <input type="hidden" id="bool_caint" value="0"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="titulo"><strong>Título:</strong></label>
                                <p class="text-justify"><?=$titulo_enviado;?></p>
                            </div>
                             <div class="form-group">
                                <label for="titulo"><strong>Responsável:</strong></label>
                                <p class="text-justify"><?=$nome_responsavel;?></p>
                            </div>
                            <div class="form-group">
                                <label for="titulo"><strong>Autores:</strong></label>
                                <p class="text-justify"><?=$nome_autor.', '.$nome_orientador;?></p>
                            </div>

                            <div class="form-group">
                                <label for="titulo"><strong>Revisores:</strong></label>
                                <p class="text-justify"><?=$nome_revisor1.', '.$nome_revisor2;?></p>
                            </div>

                            <div class="form-group">
                                <label for="area"><strong>Área:</strong></label>
                                <p class="text-justify"><?=$descricao_area;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>Área Específica:</strong></label>
                                <p class="text-justify"><?=$descricao_area_especifica;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>Data de Submissão:</strong></label>
                                <p class="text-justify">Submetido por <?=$nome_responsavel;?> no dia <?=$datahora_submissao;?></p>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="resumo"><strong>Resumo:</strong></label>
                                <p class="text-justify"><?=$resumo_enviado;?></p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <?php 
    } else if ($bool_caint == 1) {
                $sql_projeto = "SELECT  *
                            FROM es_trabalho_caint
                            LEFT JOIN es_ufop_areas ON es_ufop_areas.id_area = es_trabalho_caint.fgk_area
                            WHERE es_trabalho_caint.id = ?";
                $dados_projeto = $db->sql_query($sql_projeto, array('es_trabalho.id'=>$id_trabalho));
                foreach ($dados_projeto as $projeto) {
                        $descricao_area = $projeto->descricao_area;
                        $curso_aluno = $projeto->curso_aluno;
                        $nome_aluno = $projeto->nome_aluno;
                        $curso_destino = $projeto->curso_destino; 
                        $universidade_destino = $projeto->universidade_destino;
                        $pais_destino = $projeto->pais_destino;
                        $periodo_cursava = $projeto->periodo_cursava;
                        $tempo_afastamento = $projeto->tempo_afastamento;
                        $tipo_mobilidade = $projeto->tipo_mobilidade;
                        $cidade_destino = $projeto->cidade_destino;
                        $curso_area_destaque = $projeto->curso_area_destaque;
                        $questoes_linguisticas = $projeto->questoes_linguisticas;
                        $tipo_moradia = $projeto->tipo_moradia;
                        $sistema_avaliacao = $projeto->sistema_avaliacao;
                        $dinamica_metodologia_aulas = $projeto->dinamica_metodologia_aulas;
                        $custo_vida = $projeto->custo_vida;
                        $infra_universidade = $projeto->infra_universidade;
                        $servico_acolhimento = $projeto->servico_acolhimento;
                        $estagio = $projeto->estagio;
                        $atividades_universidade = $projeto->atividades_universidade;
                        $processo_adaptacao = $projeto->processo_adaptacao;
                        $relato_pessoal = $projeto->relato_pessoal;
                        $conselhos_calouro = $projeto->conselhos_calouro;
                        $datahora_submissao = strtotime($projeto->datahora_submissao);
                        $datahora_submissao =  date('d/m/Y H:i:s', $datahora_submissao);
                        if(empty($projeto->datahora_submissao))
                            $datahora_submissao = "";
                }
    ?>

    <div class="col-md-12">
        <input type="hidden" id="bool_caint" value="1"/>
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo"><strong>Nome Aluno:</strong></label>
                                <p class="text-justify"><?=$nome_aluno;?></p>
                            </div>
                           
                            <div class="form-group">
                                <label for="titulo"><strong>Curso Aluno:</strong></label>
                                <p class="text-justify"><?=$curso_aluno;?></p>
                            </div>
                            <div class="form-group">
                                <label for="titulo"><strong>Período que cursava:</strong></label>
                                <p class="text-justify"><?=$periodo_cursava;?></p>
                            </div>
                            <div class="form-group">
                                <label for="titulo"><strong>Tempo de afastamento em meses:</strong></label>
                                <p class="text-justify"><?=$tempo_afastamento;?></p>
                            </div>
                            <div class="form-group">
                                <label for="titulo"><strong>Mobilidade: </strong></label>
                                <p class="text-justify"><?php if($tipo_mobilidade == 1) echo "Ciência sem Fronteiras"; else if($tipo_mobilidade == 2) echo "CAINT";?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="area"><strong>Universidade de Destino:</strong></label>
                                <p class="text-justify"><?=$universidade_destino;?></p>
                            </div> 

                            <div class="form-group">
                                <label for="area"><strong>País de Destino:</strong></label>
                                <p class="text-justify"><?=$pais_destino;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>Cidade de Destino:</strong></label>
                                <p class="text-justify"><?=$cidade_destino;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="resumo"><strong>Curso de Destino:</strong></label>
                                <p class="text-justify"><?=$curso_destino;?></p>
                            </div> 
                             <div class="form-group">
                                <label for="titulo"><strong>Data de Submissão:</strong></label>
                                <p class="text-justify">Submetido por <?=$nome_aluno;?> no dia <?=$datahora_submissao;?></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="area"><strong>01. Quais são áreas/cursos de destaque da Universidade em que você esteve? </strong></label>
                                <p class="text-justify"><?=$curso_area_destaque;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>02. Fale sobre a questão linguística na Universidade de destino: se haviam cursos de idiomas, como funcionavam, se haviam disciplinas ofertadas em outros idiomas, a dificuldades enfrentadas.:</strong></label>
                                <p class="text-justify"><?=$questoes_linguisticas;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>03. Descreva o tipo de moradia que você utilizou durante sua mobilidade (gratuita ou não, compartilhada, demais ofertas de imóveis e possibilidades, valores, estrutura...).</strong></label>
                                <p class="text-justify"><?=$tipo_moradia;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>04. Descreva como é o sistema de avaliação e notas da Universidade onde esteve (Formas de avaliação, grau de dificuldade, formas de preparação para as avaliações, curiosidades...)</strong></label>
                                <p class="text-justify"><?=$sistema_avaliacao;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>05. Descreva como é a dinâmica/metodologia das aulas na Universidade de destino. Fale sobre o formato das aulas, atividades práticas e teóricas, trabalhos em grupo, monitorias. Aproveite e faça um comparativo com o nosso modelo aqui na UFOP.</strong></label>
                                <p class="text-justify"><?=$dinamica_metodologia_aulas;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>06. Descreva o custo de vida para um estudante na cidade/país onde você morou. Fale sobre alguns preços, comparativos, principais despesas, vantagens, desvantagens...</strong></label>
                                <p class="text-justify"><?=$custo_vida;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>07. Fale sobre a infra estrutura da Universidade em que esteve: laboratórios, bibliotecas, centros esportivos, parte administrativa, salas de aula e estudo...</strong></label>
                                <p class="text-justify"><?=$infra_universidade;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>08. Como funciona o serviço de acolhimento e suporte a alunos estrangeiros na Universidade de destino?</strong></label>
                                <p class="text-justify"><?=$servico_acolhimento;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>09. Com relação ao estágio? Como ele é considerado e avaliado na Universidade onde estudou? E em relação à oferta? Como localizar um estágio? A Universidade dá algum suporte? Como foi a experiência ao realizar o estágio.</strong></label>
                                <p class="text-justify"><?=$estagio;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>10. Quais atividades são oferecidas pela Universidade de destino: Fale sobre grupos de estudos, atividades de pesquisa, esporte, atividades culturais, lazer...</strong></label>
                                <p class="text-justify"><?=$atividades_universidade;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>11. Como foi o seu processo de adaptação à cidade e ao país de destino? Dificuldades com clima, idioma, receptividade, inserção cultural.</strong></label>
                                <p class="text-justify"><?=$processo_adaptacao;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>12. Relato pessoal. Fale sobre a sua experiência pessoal de maneira geral, sobre demais atividades acadêmicas, esportivas, culturais que desenvolveu, experiências profissionais, amadurecimento, rede de contatos (tente priorizar as atividades relacionadas à sua formação pessoal, acadêmica e profissional, evitando expor elementos exclusivamente de entreterimento).</strong></label>
                                <p class="text-justify"><?=$relato_pessoal;?></p>
                            </div> 
                            <div class="form-group">
                                <label for="area"><strong>13. Quais conselhos você poderia dar para um calouro que quer se preparar para fazer mobilidade na mesma Universidade/país que você esteve?</strong></label>
                                <p class="text-justify"><?=$conselhos_calouro;?></p>
                            </div> 

                            
                        </div>
                        
                    </div>
                </div>
            </div>

        </div><!-- Row -->
    </div><!-- Main Wrapper -->


    <?php    }   ?>
               

<?php
    include "footer.php";
 }
 
?>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="assets/plugins/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        var source =
        {
            datatype: "json",
            datafields: [
                { name: 'nome' },
                { name: 'departamento' },
                { name: 'id_revisor' },
                { name: 'descricao_area_especifica' },
                { name: 'total'}
            ],
            url: 'data.php?id_tipo_inscrito='+<?=$id_tipo_inscrito;?>,
            async: false
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#fgk_revisor1").jqxComboBox(
        {
            source: dataAdapter,
            theme: 'classic',
            width: 400,
            height: 50,
            itemHeight: 70,
            selectedIndex: 0, 
            displayMember: 'nome',
            valueMember: 'id_revisor',
            renderer: function (index, label, value) {
                    var datarecord = dataAdapter.records[index];
                    var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                    var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                    var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td>' + datarecord.departamento + ' - '+ datarecord.descricao_area_especifica +'</td></tr></table>';
                    return table;
                }
        });
        $("#fgk_revisor1").jqxComboBox('selectItem', <?=$id_revisor1;?>);
        $("#fgk_revisor2").jqxComboBox(
        {
            source: dataAdapter,
            theme: 'classic',
            width: 400,
            height: 50,
            itemHeight: 70,
            selectedIndex: 0, 
            displayMember: 'nome',
            valueMember: 'id_revisor',
            renderer: function (index, label, value) {
                    var datarecord = dataAdapter.records[index];
                    var imgurl = 'https://placeholdit.imgix.net/~text?txtsize=16&bg=ffffff&txtclr=8C2129&txt='+datarecord.total+'&w=40&h=40&txttrack=0';
                    var img = '<img height="50" width="45" src="' + imgurl + '"/>';
                    var table = '<table><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td style="font-size:10">' + datarecord.departamento + ' - '+ datarecord.descricao_area_especifica +'</td></tr></table>';
                    return table;
                }
        });
        $("#fgk_revisor2").jqxComboBox('selectItem', <?=$id_revisor2;?>);
    });
</script>
<script type="text/javascript">
   

        $('#alocar_avaliadores').on( 'click', function () {
            $.post('alocar_revisor.php', {
                    fgk_revisor1:$('#fgk_revisor1').val(), fgk_revisor2:$('#fgk_revisor2').val(), bool_caint: <?=$bool_caint;?>,fgk_trabalho:<?=$id_trabalho;?>, atualizar: <?=$_GET['atualizar'];?>}, 
                    function(resposta) {
                        if (resposta == "sucesso") {
                            
                            $("#processando").modal("hide");

                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                closable: false,
                                title: 'Obrigado',
                                message: '<p class="text-justify">Revisor alocado com sucesso.</p>',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="http://www.encontrodesaberes.ufop.br/admin/designar_avaliadores.php";
                                    }
                                }]
                            });
                        } 

                        else {

                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Erro',
                                message: 'Houve um erro ao atualizar o revisor, por favor preencha corretamente os campos',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                    }
                                }]
                            });

                        }
                    }
                );
        });

</script>
</body>
</html>