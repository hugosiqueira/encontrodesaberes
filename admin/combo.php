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

?> 

<link rel="stylesheet" href="assets/plugins/jqwidgets/styles/jqx.base.css" type="text/css"/>
<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxsplitter.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="assets/plugins/jqwidgets/jqxcombobox.js"></script>


    <div id='content'>
        <script type="text/javascript">
            $(document).ready(function () {
                var data = new Array();
                var nome = [
                <?php 
                    if($id_tipo_inscrito == 5)
                        $stmt = $db->sql_query('SELECT *, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                        INNER JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id 
                        INNER JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id ORDER BY nome ASC');
                    else
                        $stmt = $db->sql_query('SELECT *, es_avaliacao_revisor.id as id_revisor FROM es_avaliacao_revisor
                        INNER JOIN es_inscritos ON es_avaliacao_revisor.fgk_inscrito = es_inscritos.id  WHERE fgk_area = ? 
                        INNER JOIN es_area_especifica ON es_avaliacao_revisor.fgk_area_especifica = es_area_especifica.id 
                        ORDER BY nome ASC', array('fgk_area'=>$_SESSION['area_coordenacao']));

                    foreach ($stmt as $registro) {
                        $conta = $db->sql_query('SELECT COUNT(id) as total FROM es_avaliacao WHERE fgk_revisor1 = '.$registro->id_revisor.' OR fgk_revisor2 = '.$registro->id_revisor );
                        foreach ($conta as $key) {
                            $total = $key->total;
                        }
                        $data = array();


                        for ($i = 0; $i < $total ; $i++) {
                            if($i = 0)
                                echo '"$registro->nome"';
                            else
                                echo '", $registro->nome"';
                        }
                        echo "];";
                    }
                ?>
                 var k = 0;
                for (var i = 0; i < <?=$total?>; i++) {
                    var row = {};
                    row["nome"] = nome[k];
                    data[i] = row;
                    k++;
                }

                var source =
                {
                    localdata: data,
                    datatype: "array"
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                // Create a jqxComboBox
                $("#jqxcombobox").jqxComboBox({ selectedIndex: 0,  source: dataAdapter, displayMember: "nome", valueMember: "nome", itemHeight: 70, height: 25, width: 270,
                    renderer: function (index, label, value) {
                        var datarecord = data[index];
                        //var imgurl = '../../images/' + label.toLowerCase() + '.png';
                        var img = '<img height="50" width="45" src="https://placeholdit.imgix.net/~text?txtsize=16&txt=10&w=40&h=40&txttrack=0"/>';
                        var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;" rowspan="2">' + img + '</td><td>' + datarecord.nome + '</td></tr><tr><td>' + datarecord.nome + '</td></tr></table>';
                        return table;
                    }
                });
            });
        </script>
        <div id='jqxcombobox'>
        </div>
    </div>
</body>
</html>
<?php } ?>