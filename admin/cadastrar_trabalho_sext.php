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
            <style>
                select[readonly] {
                  background: #eee; 
                  pointer-events: none;
                  touch-action: none;
              }
            </style>
            <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
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
                    <form id="form_trabalho" name="form_trabalho" action="javascript:void(0)">
                        <input type="hidden" id='tipo_autor_responsavel' name='tipo_autor_responsavel' value = '1' />
                        <input type="hidden" id='apresentador_responsavel' name='apresentador_responsavel' value = '1' />
                        <input type="hidden" id='area' name='area' value = '7' />
                        <input type="hidden" id='orgao_fomento' name='orgao_fomento' value = '362' />
                        <div class="col-md-12">
                           <div class="panel panel-white">
                            <div class="panel-body">
                              <div class="panel-heading clearfix">
                                 <h4 class="panel-title">Termo de Aceite para Inclusão do Trabalho no Repositório do SISBIN</h4>
                             </div>
                             <div class="form-group">
                                 <div class="text-justify">Na qualidade de titular dos direitos de autor do trabalho, por mim submetido, autorizo o Sistema de Bibliotecas e Informação
                                     da Universidade Federal de Ouro Preto a disponibilizar a obra no Repositório Institucional da UFOP gratuitamente, sob uma <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/" target ="_blank">licença Creative Commons 4.0</a>,
                                     que permite copiar, distribuir e transmitir o trabalho em qualquer suporte ou formato desde que sejam citados a autoria e o licenciante. 
                                 Está licença não permite o uso para fins comerciais nem  adaptações da obra.</div>
                             </div>
                             <div >
                                 <div class="checkbox">
                                    <label>
                                       <input type="checkbox" name="autorizacao_repositorio" id="autorizacao_repositorio" checked="checked" > Autorizo que meu trabalho seja disponibilizado no Repositório da UFOP
                                   </label>
                               </div>
                           </div>

                       </div>
                   </div>
               </div>
               <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <textarea class="form-control" rows=2 id="titulo" name="titulo" placeholder="" required></textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
        </div>
               <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-body">


                        <div id="sucesso" class="modal fade modal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Encontro de Saberes</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Trabalho enviado com sucesso.</p>
                                        <button type="button" class="btn btn-success" id="btn_sim">Fechar</button>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cpf">CPF do Responsável*</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" value="<?=CPF_USUARIO;?>" readonly>
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Responsável*</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="<?=NOME_USUARIO;?>" readonly>
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group">
                           <label for="instituicao">Instituição*</label>
                           <select class="form-control" id="instituicao" name="instituicao" readonly="readonly" tabindex="-1">
                              <?php
                              $stmt = $db->sql_query("SELECT *
                                FROM es_instituicao 
                                ORDER BY nome");


                              foreach ($stmt as $instituicao) {
                                 if($instituicao->id == INSTITUICAO_USUARIO)
                                    $selected_instituicao = "selected";
                                else
                                    $selected_instituicao = "";
                                echo '<option value="'.$instituicao->id.'" '.$selected_instituicao.'>'.$instituicao->nome.'</option>';
                            }
                            ?>
                        </select>
                        <p class="help-block"></p>
                    </div>                               

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class='form-group'>
                        <label for='categoria'>Evento em que vai apresentar o trabalho*</label>
                        <select class='form-control' id='categoria' name='categoria' readonly="readonly" tabindex="-1" required>

                            <option value=2 selected="selected">SEXT - Seminário de Extensão</option>

                        </select>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label for="area_especifica">Área Específica*</label>
                        <select class="form-control" id="area_especifica" name="area_especifica" readonly="readonly" tabindex="-1" required>
                            <option>
                            </option>
                             <?php 
                            $stmt = $db->sql_query('SELECT * FROM es_area_especifica');
                            foreach ($stmt as $area) {
                                echo '<option value="'.$area->id.'"  >'.$area->descricao_area_especifica.' </option>';
                            }?>
                        </select>
                        <p class="help-block"></p>
                    </div>
                    <div class='form-group'>
                        <label for='tipo_autor_responsavel'>Apresentação*</label>
                        <select class='form-control' id='tipo_apresentacao' name='tipo_apresentacao' required>
                            <option></option>
                            <?php 
                            $stmt = $db->sql_query('SELECT * FROM es_tipo_apresentacao');
                            foreach ($stmt as $apresentacao) {
                                echo '<option value="'.$apresentacao->id_tipo_apresentacao.'"  >'.$apresentacao->descricao_tipo.' </option>';
                            }?>
                        </select>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <h3> Demais Autores </h3> 
                    <div class="form-group col-md-12">
                        <label for="qtdautor">Digite a quantidade de autores, que além de você colaboraram para este resumo (inclusive orientador, caso exista)</label>
                        <input type="number" min=0 class="form-control" id="qtdautor" name="qtdautor" required>
                        <p class="help-block"></p>
                    </div>

                    <div id="varia"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label for="palavras_chave">Palavras-Chave</label>
                        <input type="text" class="form-control" id="palavras_chave" name="palavras_chave" placeholder="">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label for="resumo">Resumo</label>
                        <textarea class="form-control" pattern=".{1300,2000}" rows="30" id="resumo" name="resumo" maxlength="2000" onkeyup="mostrarResultado(this.value,2000,'spcontando');contarCaracteres(this.value,2000,'sprestante')"><?php echo ( isset($resumo_enviado) ? $resumo_enviado : "" );?></textarea>
                        <span id="spcontando" style="font-family:Georgia;">Ainda não temos nada digitado. <strong>Mínimo:</strong> 1300 <strong>Máximo:</strong> 2000</span><br />
                        <span id="sprestante" style="font-family:Georgia;"></span>
                        <p class="help-block"></p>
                    </div> 

                    <button type="submit" id="enviar" class="btn btn-danger">Salvar Alterações</button>
                    <button type="submit" id="enviar2" class="btn btn-success" >Submeter Resumo</button>

                </div>
            </div>
        </form>
        </div>



        </div><!-- Row -->
        </div><!-- Main Wrapper -->


        <?php
        include "footer.php";
        }
        ?>

        <script src="../js/jquery-validation/jquery.validate.min.js"></script>

        <script type="text/javascript">
            $(function() {

                 $("#qtdautor").change(function() {
                $("#varia").empty();
                for (i = 1; i <= this.value; i++) {
                    var div_autor = "<h4> Autor "+i+" </h4><div class='form-group col-md-3'><label for='cpf_autor"+i+"'>CPF</label><input type='text' class='form-control cpf' id='cpf_autor"+i+"' name='cpf_autor"+i+"' data-mask='000.000.000-00' data-required></div>";
                    div_autor += "<div class='form-group col-md-5'><label for='nome_autor"+i+"'>Nome</label><input type='text' class='form-control' id='nome_autor"+i+"' name = 'nome_autor"+i+"'data-required></div>";
                    div_autor += "<div class='form-group col-md-4'><label for='email_autor"+i+"'>E-mail</label><input type='email' class='form-control' id='email_autor"+i+"' name = 'email_autor"+i+"' data-required></div>";
                    div_autor += "<div class='form-group col-md-5'><label for='instituicao_autor"+i+"'>Instituição</label><select class='form-control' id='instituicao_autor"+i+"' name='instituicao_autor"+i+"' data-required><option></option>";
                    div_autor += "<?php $stmt = $db->sql_query('SELECT * FROM es_instituicao ORDER BY nome'); foreach ($stmt as $instituicao) { echo '<option value=\"'.$instituicao->id.'\" >'.$instituicao->nome.'</option>'; } ?></select> </div>";
                    div_autor += "<div class='form-group col-md-4'><label for='tipo_autor"+i+"'>Tipo de Autor</label><select class='form-control' id='tipo_autor"+i+"' name='tipo_autor"+i+"' data-required><option></option>";
                    div_autor += "<?php $stmt = $db->sql_query('SELECT * FROM es_tipo_autor WHERE es_tipo_autor.descricao_tipo <> "Autor" ');foreach ($stmt as $autor) {echo '<option value=\"'.$autor->id_tipo_autor.'\"  >'.$autor->descricao_tipo.' </option>';}?></select></div>";
                    
                    $("#varia").append(div_autor).clone(true);
                    $('#cpf_autor'+i).mask('000.000.000-00');
                    $('#cpf_autor'+i).prop('required',true);
                    $(".btnExcluir").bind("click", excluir);
                    $('#cpf_autor'+i).change(function(){
                        var cpf_responsavel = $("#cpf").val();
                        var cpf = this.value;
                        if(!validaCPF(this.value)){
                            if( cpf.length > 0 ){      
                                BootstrapDialog.show({
                                    type: BootstrapDialog.TYPE_DANGER,
                                    title: 'Atenção',
                                    message: 'CPF inválido!'
                                });
                                $('.cpf').val(" "); 
                            }
                        }
                        if(cpf_responsavel == cpf){
                           BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Atenção',
                            message: 'CPF já está como responsável!'
                        });
                           $('.cpf').val(" "); 
                       }


                                /*$.ajax({
                                    url: "verifica_aluno.php",
                                    type: "post",
                                    data: "cpf="+this.value,
                                    success: function( data )
                                    {
                                        if (data == "aluno") {
                                            $('.cpf').val('');
                                            BootstrapDialog.show({
                                                type: BootstrapDialog.TYPE_DANGER,
                                                title: 'Atenção',
                                                message: 'Esse cpf é de um aluno da UFOP que não pode ser autor de trabalhos externos!'
                                            });
                                        } 
                                    }
                                });*/


                            })
                }
            });

            // Atribui evento e função para limpeza dos campos
            $('#titulo').on('input', limpaCampos);

            // Dispara o Autocomplete a partir do segundo caracter
            $( "#titulo" ).autocomplete({
                minLength: 2,
                source: function( request, response ) {
                    $.ajax({
                        url: "consulta_projeto.php",
                        dataType: "json",
                        data: {
                            acao: 'autocomplete',
                            parametro: $('#titulo').val()
                        },
                        success: function(data) {
                         response(data);
                     }
                 });
                },
                focus: function( event, ui ) {
                    $("#titulo").val( ui.item.titulo );
                    carregarDados();
                    return false;
                },
                select: function( event, ui ) {
                    $("#busca").val( ui.item.titulo );
                    return false;
                }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
              return $( "<li>" )
              .append( "<a><b>Título: </b>" + item.titulo + "</a><br><b>Área Temática: </b>" + item.descricao_area_especifica + "<br>" )
              .appendTo( ul );
          };

            // Função para carregar os dados da consulta nos respectivos campos
            function carregarDados(){
                var busca = $('#titulo').val();

                if(busca != "" && busca.length >= 2){
                    $.ajax({
                        url: "consulta_projeto.php",
                        dataType: "json",   
                        data: {
                            acao: 'consulta',
                            parametro: $('#titulo').val()
                        },
                        success: function( data ) {
                         $('#area_especifica').val(data[0].id_area_especifica);
                         $('#titulo').val(data[0].titulo);
                         
                     }
                 });
                }
            }

            // Função para limpar os campos caso a busca esteja vazia
            function limpaCampos(){
             var busca = $('#titulo').val();

             if(busca == ""){
                 $('#area_especifica').val('');
                 $('#titulo').val('');  
             }
         }
         function excluir() {
                 $(this).parent().parent().remove();
             }
             function validaCPF(value){
                value = jQuery.trim(value);

                value = value.replace('.','');
                value = value.replace('.','');
                cpf = value.replace('-','');
                while(cpf.length < 11) cpf = "0"+ cpf;
                var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
                var a = [];
                var b = new Number;
                var c = 11;
                for (i=0; i<11; i++){
                    a[i] = cpf.charAt(i);
                    if (i < 9) b += (a[i] * --c);
                }
                if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
                    b = 0;
                c = 11;
                for (y=0; y<10; y++) b += (a[y] * c--);
                    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

                var retorno = true;
                if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

                return retorno;

            };

           

        });

        function mostrarResultado(box,num_max,campospan){
            var contagem_carac = box.length;
            if (contagem_carac != 0){
                document.getElementById(campospan).innerHTML = contagem_carac + " caracteres digitados";
                if (contagem_carac == 1){
                    document.getElementById(campospan).innerHTML = contagem_carac + " caracter digitado";
                }
                if (contagem_carac >= num_max){
                    document.getElementById(campospan).innerHTML = "Limite de caracteres excedido!";
                }
            }else{
                document.getElementById(campospan).innerHTML = "Ainda não temos nada digitado..";
            }
        }
        function contarCaracteres(box,valor,campospan){
            var conta = valor - box.length;
            document.getElementById(campospan).innerHTML = "Você ainda pode digitar " + conta + " caracteres";
            if(box.length >= valor){
                document.getElementById(campospan).innerHTML = "Opss.. você não pode mais digitar..";
                document.getElementById("campo").value = document.getElementById("campo").value.substr(0,valor);
            }   
        }
            
        </script>
        <script src="assets/js/pages/cadastrar_trabalho.js"></script>

        </body>
        </html>