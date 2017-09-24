
$(document).ready(function() {
    var $validator = $("#form_trabalho").validate({
       rules: {
            area:{
                required: true
            },
            area_especifica: {
                required: true
            },
            orgao_fomento: {
                required: true
            },
            qtdautor:{
                required: true
            },
            titulo: {
                required: true
            },
            palavras_chave: {
                required: true
            },
            resumo: {
                required: true
            }

        },
        messages:{
            area: "Por favor, informe a área relacionada ao seu trabalho." ,
            area_especifica: "Por favor, informe a área específica relacionada ao seu trabalho.",
            orgao_fomento: "Por favor, informe o órgão fomento de seu trabalho.",
            qtd_autor: "Por favor, informe a quantidade de autores de seu trabalho.",
            titulo: "Por favor, informe o título de seu trabalho.",
            palavras_chave: "Por favor, informe as palavras chave de seu trabalho.",
            resumo: "Por favor, informe o resumo de seu trabalho."

        }
    });
    

    $("#enviar").click(function( ) {
		
        if($("#area").val() == ""){
            alert("Preencha a área de seu trabalho.");
            return;
        }
        if($("#area_especifica").val() == ""){
            alert("Preencha a área específica de seu trabalho.");
            return;
        }
        if($("#orgao_fomento").val() == ""){
            alert("Preencha o órgao fomento de seu trabalho.");
            return;
        }
        if($("#titulo").val() == ""){
            alert("Preencha o título de seu trabalho.");
            return;
        }
        if($("#palavras_chave").val() == ""){
            alert("Preencha as palavras chave de seu trabalho.");
            return;
        }
        if($("#resumo").val() == ""){
            alert("Preencha o resumo de seu trabalho.");
            return;
        }
		
		
        $("#form_trabalho").validate();
        if($("#form_trabalho").valid())
        {
            $("#processando").modal("show");

                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var area_especifica = $("#area_especifica").val();
                var palavras_chave = $("#palavras_chave").val();
                var resumo_enviado = $('#resumo').val();
				var categoria = $('#categoria').val();
				var apoio_financeiro = $('#apoio_financeiro').val();
				var protocolo_ceua = $('#protocolo_ceua').val();
				var protocolo_cep =  $('#protocolo_cep').val();
				var resumo_enviado = resumo_enviado.replace(/&/g, "&amp;")
                var resumo_enviado = resumo_enviado.replace(/</g, "&lt;")
                var resumo_enviado = resumo_enviado.replace(/>/g, "&gt;")
                var resumo_enviado = resumo_enviado.replace(/"/g, "&quot;")
                var resumo_enviado = resumo_enviado.replace(/'/g, "&#039;");
                var id_trabalho = $('#id_trabalho').val();
                var titulo = $('#titulo').val();
                var orgao_fomento = $('#orgao_fomento').val();
                var area = $("#area").val();


                // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
                $.post('enviar_resumo.php', {
                    area: area, area_especifica: area_especifica, palavras_chave: palavras_chave, resumo_enviado: resumo_enviado, 
                    id_trabalho: id_trabalho, fgk_status:1, titulo: titulo, orgao_fomento: orgao_fomento, categoria: categoria, protocolo_cep: protocolo_cep,
					protocolo_ceua:protocolo_ceua, apoio_financeiro:apoio_financeiro }, 
                    function(resposta) {
                        if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");
                             BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                closable: false,
                                title: 'Obrigado',
                                message: '<p>Resumo salvo com sucesso.</p><p> ATENÇÃO: Esta opção é apenas para salvar o seu trabalho. Quando finalizar, não esqueça de enviar o seu trabalho clicando no botão verde "Submeter Proposta"</p>',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="meus_resumos.php";
                                    }
                                }]
                            });


                        } 
                        // Se resposta for false, ou seja, não ocorreu nenhum erro
                        else {
                            // Exibe mensagem de sucesso
                            
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
                });


        }  else {
            return false;
        }
    });
	$("#enviar2").click(function() {
        if($("#area").val() == ""){
            alert("Preencha a área de seu trabalho.");
            return;
        }
        if($("#area_especifica").val() == ""){
            alert("Preencha a área específica de seu trabalho.");
            return;
        }
        if($("#orgao_fomento").val() == ""){
            alert("Preencha o órgao fomento de seu trabalho.");
            return;
        }
        if($("#titulo").val() == ""){
            alert("Preencha o título de seu trabalho.");
            return;
        }
        if($("#palavras_chave").val() == ""){
            alert("Preencha as palavras chave de seu trabalho.");
            return;
        }
        if($("#resumo").val() == ""){
            alert("Preencha o resumo de seu trabalho.");
            return;
        }
        $("#form_trabalho").validate();
        if($("#form_trabalho").valid())
        {
            $("#processando").modal("show");

                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var area_especifica = $("#area_especifica").val();
                var palavras_chave = $("#palavras_chave").val();
                var resumo_enviado = $('#resumo').val();
				var categoria = $('#categoria').val();
				var apoio_financeiro = $('#apoio_financeiro').val();
				var protocolo_ceua = $('#protocolo_ceua').val();
				var protocolo_cep =  $('#protocolo_cep').val();
				var resumo_enviado = resumo_enviado.replace(/&/g, "&amp;")
                var resumo_enviado = resumo_enviado.replace(/</g, "&lt;")
                var resumo_enviado = resumo_enviado.replace(/>/g, "&gt;")
                var resumo_enviado = resumo_enviado.replace(/"/g, "&quot;")
                var resumo_enviado = resumo_enviado.replace(/'/g, "&#039;");
                var id_trabalho = $('#id_trabalho').val();
                var titulo = $('#titulo').val();
                var orgao_fomento = $('#orgao_fomento').val();
                var area = $("#area").val();


                // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
                $.post('enviar_resumo.php', { area: area, area_especifica: area_especifica, palavras_chave: palavras_chave, resumo_enviado: resumo_enviado, 
                    id_trabalho: id_trabalho, fgk_status: 2, titulo: titulo, orgao_fomento: orgao_fomento, categoria: categoria, protocolo_cep: protocolo_cep,
					protocolo_ceua:protocolo_ceua, apoio_financeiro:apoio_financeiro }, 
                    function(resposta) {
                        // Quando terminada a requisição
                        // Exibe a div status
                        // Se a resposta é um erro
                        if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");
                            
                            var area_especifica = $("#area_especifica").prop( "disabled", true );
                            var palavras_chave = $("#palavras_chave").prop( "disabled", true );
                            var resumo_enviado = $('#resumo').prop( "disabled", true );
                            var id_trabalho = $('#id_trabalho').prop( "disabled", true );
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Obrigado',
                                closable: false,
                                message: 'Proposta de trabalho submetida com sucesso.',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-ok',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="meus_resumos.php";
                                    }
                                }]
                            });

                        } 
                        // Se resposta for false, ou seja, não ocorreu nenhum erro
                        else {
                            // Exibe mensagem de sucesso
                            
                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Erro',
                                closable: false,
                                message: resposta,
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="meus_resumos.php";
                                    }
                                }]
                            });
						return false;
                        }
						
                });
            

        }  else {
            return false;
        }
    });
    //var t = $('#autores').DataTable();

    $('#add-autor').on( 'click', function () {
        
            var dados = $( "add-novo-autor" ).serialize();
            var cpf_autor = $('#cpf_autor').val();
            var nome_autor = $('#nome_autor').val();
            var email_autor = $('#email_autor').val();
            var instituicao_autor = $('#instituicao_autor').val();
            var tipo_autor = $('#tipo_autor').val();
            var apresentador_autor = $('#apresentador_autor').val();
            var id_trabalho_autor = $('#id_trabalho_autor').val();
			var ordem_autor = $('#ordem_autor').val();
			if(!cpf_autor){
				alert("Digite o CPF do autor.");
				return;
			}
			if(!email_autor){
				alert("Digite o e-mail do autor.");
				return;
			}

                $.ajax({
                    url: "cadastrar_autor.php",
                    type: "post",
                    data: "ordem_autor="+ordem_autor+"&cpf_autor="+cpf_autor+"&nome_autor="+nome_autor+"&email_autor="+email_autor+"&instituicao_autor="+instituicao_autor+"&tipo_autor="+tipo_autor+"&apresentador_autor="+apresentador_autor+"&id_trabalho_autor="+id_trabalho_autor,
                    success: function( data )
                    {
                        if(data == "sucesso"){
                            $('#myModal').modal('hide');
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Sucesso',
                                message: 'Autor cadastrado com sucesso',
                                closable: false,
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        window.location.href = window.location.href;
                                    }
                                }]
                            });
                        } else {
                            $('#myModal').modal('hide');
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Ocorreu o seguinte erro ao tentar cadastrar',
                                message: data,
                                closable: false,
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

            
            
            $('.myModal').modal('hide');
            
            return false;
        
    });
    $('#cpf_autor').change(function(){
        var value = this.value;
		function validarCPF(value){
		
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

			return retorno;
		}
        if(!validarCPF(value) && $('#cpf_autor').val() > 0){  
        $('#myModal').modal('hide');     
            BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Atenção',
                    closable: false,
                    message: 'CPF inválido!',
                    buttons: [{
                            icon: 'glyphicon glyphicon-check',       
                            label: 'Fechar.',
                            cssClass: 'btn-primary', 
                            autospin: false,
                            action: function(dialogRef){  

                                dialogRef.close();
                                $("#cpf_autor").val('');
                                $('#myModal').modal('show');
                            }
                        }]
            });
            $('.cpf').val(" "); 

        }
        $.ajax({
            url: "verifica_aluno.php",
            type: "get",
            data: "cpf="+this.value+"&id_trabalho="+id_trabalho,
            success: function( data )
            {
                if (data == "aluno") {
                    $('#myModal').modal('hide');
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Atenção',
                        closable: false,
                        message: 'Esse cpf é de um aluno da UFOP que não pode ser autor de trabalhos externos!',
                        buttons: [{
                            icon: 'glyphicon glyphicon-check',       
                            label: 'Fechar.',
                            cssClass: 'btn-primary', 
                            autospin: false,
                            action: function(dialogRef){  

                                dialogRef.close();
                                $("#cpf_autor").val('');
                                $('#myModal').modal('show');
                            }
                        }]
                    });
                } else if(data == "existe"){
                    $('#myModal').modal('hide');
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Atenção',
                        closable: false,
                        message: 'Esse cpf já está cadastrado como autor desse trabalho!',
                        buttons: [{
                            icon: 'glyphicon glyphicon-check',       
                            label: 'Fechar.',
                            cssClass: 'btn-primary', 
                            autospin: false,
                            action: function(dialogRef){  

                                dialogRef.close();
                                $("#cpf_autor").val('');
                                $('#myModal').modal('show');
                            }
                        }]
                    });

                } 
            }
        });
             
    });
    $('#cpf_autor').mask('000.000.000-00');
	

});