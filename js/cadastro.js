$.validator.addMethod("cpf", function(value, element) {
    value = $.trim(value);
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

    return this.optional(element) || retorno;

}, "Informe um CPF válido");

$(document).ready(function() {

    var $validator = $("#cadastro").validate({
        rules: {
            cpf: {
                cpf: true,
                required: true
            },
            nome: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            senha: {
                required: true
            },
            csenha: {
                required: true,
                equalTo: '#senha'
            },
            telefone_celular: {
                required: true
            },
            endereco: {
                required: true
            },
            nome_cracha: {
                required: true
            },
            estado: {
                required: true
            },
            cidade: {
                required: true
            },
            bairro: {
                required: true
            },
            numero: {
                required: true
            },
            cep: {
                required: true
            },
            tipo_inscricao: {
                required: true
            },
            messages: {
                cpf: { cpf: 'CPF inválido'}
            },
            instituicao: {
                required: true
            }
        }
    });

    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-tabs',
        onTabShow: function(tab, navigation, index) {
            tab.prevAll().addClass('done');
            tab.nextAll().removeClass('done');
            tab.removeClass('done');
            var $total = navigation.find('li').length;
            var $current = index +1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('.progress-bar').css({width:$percent+'%'});
            if($current==1){
                $('#voltar').hide();
            } else
            if ($current >= $total) {
                $('#valWizard').find('.wizard .next').addClass('hide');
                $('#valWizard').find('.wizard .finish').removeClass('hide');
                $('#avancar').hide();
                $('#voltar').show();
            } else {
                $('#valWizard').find('.wizard .next').removeClass('hide');
                $('#valWizard').find('.wizard .finish').addClass('hide');
                $('#avancar').show();
                $('#voltar').show();
            }
        },
        'onNext': function(tab, navigation, index) {
            var $valid = $("#cadastro").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },
        'onTabClick': function(tab, navigation, index) {
            var $valid = $("#cadastro").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },
    });

    $("input[name='cpf']").blur(function(){
        if( $( this ).val().length > 0 ){
            $("#aguarde").modal("show");
            var nome = $("input[name='nome']");
            var telefone = $("input[name='telefone']");

            $.getJSON('functions.php',
                { cpf: $( this ).val() },
                function( json )
                {
                    if( json.nome != ' '){
                        $( cpf ).prop("readonly", true);
                        $( nome ).val( json.nome );
                        var cracha = json.nome.split(/(\s).+\s/).join("");
                        $("#nome_cracha").val( cracha );
                        $( nome ).prop("readonly", true);
                    } else {
                        $( cpf ).prop("readonly", false);
                        $( nome ).prop("readonly", false);
                    }

                    if( json.email != ' '){
                        $( email ).val( json.email );
                        $( email ).prop("readonly", true);
                    } else {
                        $( email ).prop("readonly", false);
                    }
                    if(json.email.indexOf("ufop.br") > 0){
                        $(emaila).attr("required", true);
                    } else {
                        $(emaila).attr("required", false);
                    }
					
					if(json.cep!=''){
						$( cep ).val( json.cep );
						$( estado ).val( json.estado );
						$.getJSON('cidades.ajax.php?search=',{estado: json.estado, ajax: 'true'}, function(j){
							var options = '<option value=""></option>';
							for (var i = 0; i < j.length; i++) {
								options += '<option value="' + j[i].nome + '">' + j[i].nome + '</option>';
							}
							$('#cidade').html(options).show();
							$('select#cidade option').each(function(){
								if($(this).val() == json.cidade){
									$(this).prop("selected",true);
								}
							});
						}); 
						$( endereco ). val ( json.endereco );
						$( bairro ). val ( json.bairro );
						$( numero ). val ( json.numero );
						$( complemento ). val ( json.complemento );
						$( telefone ). val ( json.telefone );
						$( telefone_celular ). val ( json.telefone_celular );
					}

                    if( json.instituicao == 1 ){

                        $( instituicao ).val( json.instituicao );
                        $( id_departamento ).val( json.id_departamento );
                        $( id_curso ).val( json.id_curso );
                        $( departamento ).val( json.departamento );
                        $( curso ).val( json.curso );
                        $( matricula ).val( json.matricula );
                        $( tipo_inscricao ).val( json.tipo_inscricao );
                        $( valor_inscricao ).val( json.valor_inscricao );
                        $( instituicao ).attr("disabled", true); 
                        $( departamento ).prop("readonly", true);
                        $( curso ).prop("readonly", true);
                        $( matricula ).prop("readonly", true);
                        $( valor_inscricao ).prop("readonly", true);
                        $( tipo_inscricao ).attr("disabled", true); 
                        $( mobilidade_ano_passado ).val ( json.mobilidade_ano_passado );
                        $( mobilidade_ano_atual ).val ( json.mobilidade_ano_atual );
                        $( bool_temp ).val( json.bool_temp );
                        $( bool_monitoria ).val( json.bool_monitoria);

                    } else {
                       $( instituicao ).attr("disabled", false); 
                       //$("#instituicao option[value=" + 1 + "]").attr('disabled','disabled');
                       $( departamento ).prop("readonly", false);
                       $( curso ).prop("readonly", false);
                       $( matricula ).prop("readonly", false);

                       $( tipo_inscricao ).attr("disabled", true); 
                       $( departamento ).val( ' ' );
                       $( curso ).val( ' ' );
                       $( matricula ).val(' ');
                       $( valor_inscricao ).val( ' ' ); 
                       $( mobilidade_ano_passado ).val ( '0' );
                       $( mobilidade_ano_atual ).val ( '0' );
                       $( valor_inscricao ).prop("readonly", false);
                       $("#tipo_inscricao option[value=" + 1 + "]").attr('disabled','disabled');
                       $("#tipo_inscricao option[value=" + 2 + "]").attr('disabled','disabled');
                       $("#tipo_inscricao option[value=" + 6 + "]").attr('disabled','disabled');
                       $( tipo_inscricao ).attr("disabled", false); 

                   }
                });
            window.setTimeout(function () {
                $("#aguarde").modal("hide");
            }, 2000);
        }


    $.getJSON('verifica_cpf.php', { cpf: $( this ).val() }, 
        function(resposta) {
            // Quando terminada a requisição
            // Exibe a div status
            // Se a resposta é diferente de false é um erro
            if (resposta != false) {
                // Exibe o erro na div
                $('#cadastro')[0].reset();
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Atenção',
                    message: 'Esse cpf já está inscrito no Encontro de Saberes 2016 você deseja recuperar sua senha?<p>E-mail: '+resposta.email_mascara+' </p><p>Celular: '+resposta.celular_mascara+'</p>',
                    buttons: [{
                        label: 'Enviar por e-mail',
                        cssClass: 'btn-primary',
                        icon: 'glyphicon glyphicon-envelope',
                        action: function(){
                           window.location="recuperar_senha.php?tipo=email&cpf="+resposta.cpf;
                       }
                    },{
                        id: 'btn-ok',   
                        icon: 'glyphicon glyphicon-check',       
                        label: 'Não, obrigado.',
                        cssClass: 'btn-primary', 
                        autospin: false,
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                    }]
                });
                $( "input[name='cpf']" ).val(' ');
                $( nome ).val(' ');
                $( email ).val(' ');
                $( email ).prop("readonly", false);
                $( nome ).prop("readonly", false);

            } 

    });
    });

    $("input[name='nome']").blur(function(){
        var cracha = $( this ).val().split(/(\s).+\s/).join("");
        $("#nome_cracha").val( cracha );
    });

    $("input[name='cep']").change(function(){
        if( $( this ).val().length > 0 ){
            $("#aguarde").modal("show");

            $("#bairro").val('Carregando...');
            $("#cidade").html("<option value='0'>Carregando...</option>");
            $("#endereco").val('Carregando...');
            var cep_code = $(this).val().replace('-','');;

            if( cep_code.length <= 0 ) return;
            $.get("http://apps.widenet.com.br/busca-cep/api/cep.json", { code: cep_code },
                function(result){
                    if( result.status!=1 ){
                        alert(result.message || "Houve um erro desconhecido");
                        return;
                    }

                    $('#estado option').prop('selected', false).filter('[value='+result.state+']').prop('selected', true);
                    $("input#bairro").val( result.district );
                    $("input#endereco").val( result.address );
                    $.getJSON('cidades.ajax.php?search=',{estado: result.state, ajax: 'true'}, function(j){
                        var options = '<option value=""></option>';
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].nome + '">' + j[i].nome + '</option>';
                        }
                        $('#cidade').html(options).show();
                        $('select#cidade option').each(function(){
                            if($(this).val() == result.city.toUpperCase()){
                                $(this).prop("selected",true);
                            }
                    });

                });    

            });
            window.setTimeout(function () {
                $("#aguarde").modal("hide");
            }, 3000);
        }
    });

    $(function(){
        $('#estado').change(function(){
            if( $(this).val() ) {
                /*$('#cidade').hide();
                $('.carregando').show();*/
                $.getJSON('cidades.ajax.php?search=',{estado: $(this).val(), ajax: 'true'}, function(j){
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].nome + '">' + j[i].nome + '</option>';
                    }
                    $('#cidade').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#cidade').html('<option value="" placeholder="– Escolha um estado –"> </option>');
            }
        })
    });

    $(function(){
        $('#tipo_inscricao').change(function(){
            if( $(this).val() ) {
                $.getJSON('tipo_inscricao.php?search=',{tipo_inscricao: $(this).val(), ajax: 'true'}, function(j){
                    var options = 'R$'+j[0].valor_inscricao/100+',00';

                    $('#valor_inscricao').val(options);

                });
            } else {
                $('#valor_inscricao').val('Por favor escolha uma modalidade de inscrição');
            }
        })
    });

    $("#button_enviar").click(function() {
        $("#cadastro").validate();
        if($("#cadastro").valid())
        {
            function getDisableInput(form) {
               var input = $("#" + form + " input:disabled");
               var result = '';
               $.each(input, function (key, val) {
                  result += "&" + val.name + '=' + val.value;
               });
               return result;
            }

            var disableInput = getDisableInput('cadastro'); 
            disableInput += "&tipo_inscricao=" + $("#tipo_inscricao").val();
            disableInput += "&instituicao=" + $("#instituicao").val();

            var data = $('#cadastro').serialize() + disableInput;

        $.ajax({
            url: "envio_cadastro.php",
            type: "post",
            data: data,
            success: function( data ){

                if (data == "sucesso") {
                    $("#processando").modal("hide");
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Obrigado',
                        message: 'Sua inscrição foi efetuada com sucesso. Aguarde em seu e-mail mais informações.',
                        buttons: [{
                            id: 'btn-ok',   
                            icon: 'glyphicon glyphicon-check',       
                            label: 'Fechar.',
                            cssClass: 'btn-primary', 
                            autospin: false,
                            action: function(dialogRef){    
                                window.location.href="index.php";

                            }
                        }]
                    });
                } 
                else {                            
                    $("#processando").modal("hide");
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Erro',
                        message: data,
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
        });

            $("#processando").modal("show");
            /*$("#cadastro").submit(function(e) {
                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var ip = $("#ip").val();
                var nome = $("#nome").val();
                var email = $("#email").val();
                var emaila = $("#emaila").val();
                var cpf = $("#cpf").val();
                var telefone = $("#telefone").val();
                var telefone_celular = $("#telefone_celular").val();
                var cep = $("#cep").val();
                var endereco = $("#endereco").val();
                var bairro = $("#bairro").val();
                var cidade = $("#cidade").val();
                var estado = $("#estado").val();
                var numero = $("#numero").val();
                var complemento = $("#complemento").val();
                var instituicao = $("#instituicao").val();
                var id_departamento = $("#id_departamento").val();
                var id_curso = $("#id_curso").val();
                var departamento = $("#departamento").val();
                var curso = $("#curso").val();
                var matricula = $("#matricula").val();
                var autoriza_envio_emails = $("#autoriza_envio_emails").is(':checked') ? 1 : 0;
                var senha = $("#senha").val();
                var csenha = $("#csenha").val();
                var tipo_inscricao = $("#tipo_inscricao").val();
                var valor_inscricao = $("#valor_inscricao").val();
                var mobilidade_ano_passado = $("#mobilidade_ano_passado").val();
                var mobilidade_ano_atual = $("#mobilidade_ano_atual").val();
                var bool_temp = $("#bool_temp").val();
                var bool_monitoria = $("#bool_monitoria").val();
                var nome_cracha = $("#nome_cracha").val();

                // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
                $.post('envio_cadastro.php', {nome_cracha: nome_cracha, ip: ip, nome: nome, email: email, email_alternativo: emaila, cpf: cpf, telefone: telefone,telefone_celular: telefone_celular,
                    cep: cep, endereco: endereco, bairro: bairro, cidade: cidade, estado: estado, numero: numero, complemento: complemento, 
                    instituicao:instituicao, fgk_departamento: id_departamento, fgk_curso: id_curso,departamento: departamento, curso: curso, matricula: matricula, autoriza_envio_emails: autoriza_envio_emails,
                    senha: senha, csenha: csenha, tipo_inscricao: tipo_inscricao, valor_inscricao: valor_inscricao, mobilidade_ano_atual: mobilidade_ano_atual, mobilidade_ano_passado: mobilidade_ano_passado, bool_temp: bool_temp, bool_monitoria: bool_monitoria }, 
                    function(resposta) {
                        // Quando terminada a requisição
                        // Exibe a div status
                        // Se a resposta é um erro de telefone
                        if (resposta == "sucesso") {
                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_SUCCESS,
                                title: 'Obrigado',
                                message: 'Sua inscrição foi efetuada com sucesso. Aguarde por e-mail mais informações',
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
                        // Se resposta for false, ou seja, não ocorreu nenhum erro
                        else {
                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Erro',
                                message: resposta,
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
                        e.stopImmediatePropagation(); 
                });
            });*/

        }  else {
            return false;
        }
    });

});
