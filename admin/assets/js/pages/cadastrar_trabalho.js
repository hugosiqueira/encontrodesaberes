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
			categoria:{
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
            qtdautor: "Por favor, informe a quantidade de autores de seu trabalho.",
			categoria: "Por favor informe qual evento você irá participar.",
            titulo: "Por favor, informe o título de seu trabalho.",
            palavras_chave: "Por favor, informe as palavras chave de seu trabalho.",
            resumo: "Por favor, informe o resumo de seu trabalho."
        }
    });

    $("#enviar").click(function() {
        if($("#area").val() == ""){
            alert("Preencha a área de seu trabalho.");
            return;
        }
        if($("#area_especifica").val() == ""){
            alert("Preencha a área específica de seu trabalho.");
            return;
        }
		if($("#categoria").val() == ""){
            alert("Preencha o evento que você irá participar.");
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

       
        var qtdautor = $("#qtdautor").val();
        for (i=1; i<=qtdautor; i++){
            if($("#cpf_autor"+i).val() == ""){
                alert("O campo de cpf do autor "+i+" é obrigatório");
                $("#cpf_autor"+i).focus();
                return;
            }
            if($("#nome_autor"+i).val() == ""){
                alert("O campo de nome do autor "+i+" é obrigatório");
                $("#cpf_autor"+i).focus();
                return;
            }
            if($("#email_autor"+i).val() == ""){
                alert("O campo de e-mail do autor "+i+" é obrigatório");
                $("#cpf_autor"+i).focus();
                return;
            }
        }
        if($("#form_trabalho").valid())
        {

            $("#processando").modal("show");
				
                var qtdautor = $("#qtdautor").val();
                var cpf_autor = "cpf_autor";
                var nome_autor = "nome_autor";
                var instituicao_autor = "instituicao_autor";
                var tipo_autor = "tipo_autor";
                var apresentador = "apresentador";
                var email_autor = "email_autor";
                
                //console.log(dados); 
				if(qtdautor > 0){
					for (i=1; i<=qtdautor; i++){
						window[cpf_autor+i] = $("#cpf_autor"+i).val();
						if($("#cpf_autor"+i).val() == ""){
							alert("O campo de cpf é obrigatório");
							$("#cpf_autor"+i).focus();
						}
						window[nome_autor+i] = $("#nome_autor"+i).val();
						window[email_autor+i] = $("#email_autor"+i).val();
						window[tipo_autor+i] = $("#tipo_autor"+i).val();
						window[instituicao_autor+i] = $("#instituicao_autor"+i).val();
						window[apresentador+i] = $("#apresentador"+i).val();
					}
				}
                var area = $("#area").val();
                var area_especifica = $("#area_especifica").val();
                var cpf = $('#cpf').val();
				var categoria= $('#categoria').val();
                var instituicao = $('#instituicao').val();
                var email = $("#email").val();
                var nome = $("#nome").val();
                var tipo_autor_responsavel = $("#tipo_autor_responsavel").val();
                var apresentador_responsavel = $("#apresentador_responsavel").val();
                var orgao_fomento = $("#orgao_fomento").val();
                var titulo = $("#titulo").val();
                var palavras_chave = $("#palavras_chave").val();
				var apoio_financeiro = $('#apoio_financeiro').val();
				var protocolo_ceua = $('#protocolo_ceua').val();
				var protocolo_cep =  $('#protocolo_cep').val();
				var resumo = $('#resumo').val();
				var autorizacao_repositorio = $("#autorizacao_repositorio").attr("checked") ? 1 : 0;
                var programa_ic = $("#programa_ic").val();
				/*var resumo_enviado = resumo_enviado.replace(/&/g, "&amp;")
                var resumo_enviado = resumo_enviado.replace(/</g, "&lt;")
                var resumo_enviado = resumo_enviado.replace(/>/g, "&gt;")
                var resumo_enviado = resumo_enviado.replace(/"/g, "&quot;")
                var resumo_enviado = resumo_enviado.replace(/'/g, "&#039;");*/
				
				var entityMap = {
				  '&': '&amp;',
				  '<': '&lt;',
				  '>': '&gt;',
				  '"': '&quot;',
				  "'": '&#39;',
				  '/': '&#x2F;',
				  '`': '&#x60;',
				  '=': '&#x3D;'
				};

				function escapeHtml (string) {
				  return String(string).replace(/[&<>"'`=\/]/g, function (s) {
					return entityMap[s];
				  });
}				var resumo_enviado = resumo;
				
                var id_inscrito = $('#id_inscrito').val();
				
                var dados = "programa_ic="+programa_ic+"&autorizacao_repositorio="+autorizacao_repositorio+"&categoria="+categoria+"&protocolo_cep="+protocolo_cep+"&protocolo_ceua="+protocolo_ceua+"&apoio_financeiro="+apoio_financeiro+"&cpf="+cpf+"&nome="+nome+"&email="+email+"&instituicao="+instituicao+"&tipo_autor_responsavel="+tipo_autor_responsavel+"&apresentador_responsavel="+apresentador_responsavel+"&qtdautor="+qtdautor+"&area="+area+"&area_especifica="+area_especifica+"&palavras_chave="+palavras_chave+"&resumo_enviado="+resumo_enviado+"&orgao_fomento="+orgao_fomento+"&titulo="+titulo+"&id_inscrito="+id_inscrito+"&fgk_status=1";
				
				//var dados = 'categoria:'+categoria+', protocolo_cep:'+protocolo_cep+', protocolo_ceua:'+protocolo_ceua+', apoio_financeiro:'+apoio_financeiro+', tipo_autor_responsavel:'+tipo_autor_responsavel+', apresentador_responsavel:'+apresentador_responsavel+', qtdautor:'+ qtdautor+', area:'+area+', area_especifica:' +area_especifica+', palavras_chave:'+ palavras_chave+', resumo_enviado:'+ resumo_enviado+', orgao_fomento:'+ orgao_fomento+', titulo:'+titulo+', id_inscrito:'+ id_inscrito+', fgk_status: 1';
				if(qtdautor > 0){
					for (i=1; i <=$("#qtdautor").val(); i++){
						dados += '&cpf_autor'+i+'='+$("#cpf_autor"+i).val()+'&nome_autor'+i+'='+$("#nome_autor"+i).val()+'&email_autor'+i+'='+$("#email_autor"+i).val()+'&tipo_autor'+i+'='+$("#tipo_autor"+i).val()+'&instituicao_autor'+i+'='+$("#instituicao_autor"+i).val()+'&apresentador'+i+'='+$("#apresentador"+i).val();
						//dados += ',cpf_autor'+i+':'+$("#cpf_autor"+i).val()+',nome_autor'+i+':'+$("#nome_autor"+i).val()+',email_autor'+i+':'+$("#email_autor"+i).val()+',tipo_autor'+i+':'+$("#tipo_autor"+i).val()+',instituicao_autor'+i+':'+$("#instituicao_autor"+i).val()+',apresentador'+i+':'+$("#apresentador"+i).val();
					}
				}  
                $.ajax({
                    url: "envio_cadastrar_trabalho.php",
                    type: "post",
                    data: dados,
                    success: function( data )
                    {

                        if (data == "sucesso") { 
                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Obrigado',
                                message: 'Trabalho salvo com sucesso. ATENÇÃO: Esta opção é apenas para salvar o seu trabalho. Quando finalizar, não esqueça de enviar o seu trabalho clicando no botão verde "Submeter Resumo"',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        var qtdautor = $("#qtdautor").prop( "disabled", true );
                                        
                                        //console.log(dados);   
                                        for (i=1; i<=qtdautor; i++){
                                            window[cpf_autor+i] = $("#cpf_autor"+i).prop( "disabled", true );
                                            window[nome_autor+i] = $("#nome_autor"+i).prop( "disabled", true );
                                            window[email_autor+i] = $("#email_autor"+i).prop( "disabled", true );
                                            window[tipo_autor+i] = $("#tipo_autor"+i).prop( "disabled", true );
                                            window[instituicao_autor+i] = $("#instituicao_autor"+i).prop( "disabled", true );
                                            window[apresentador+i] = $("#apresentador"+i).prop( "disabled", true );
                                        }
                                        var area = $("#area").prop( "disabled", true );
                                        var area_especifica = $("#area_especifica").prop( "disabled", true );
                                        var cpf = $('#cpf').prop( "disabled", true );
                                        var instituicao = $('#instituicao').prop( "disabled", true );
                                        var email = $("#email").prop( "disabled", true );
                                        var nome = $("#nome").prop( "disabled", true );
                                        var tipo_autor_responsavel = $("#tipo_autor_responsavel").prop( "disabled", true );
                                        var apresentador_responsavel = $("#apresentador_responsavel").prop( "disabled", true );
                                        var orgao_fomento = $("#orgao_fomento").prop( "disabled", true );
                                        var titulo = $("#titulo").prop( "disabled", true );
                                        var palavras_chave = $("#palavras_chave").prop( "disabled", true );
                                        var resumo_enviado = $('#resumo').prop( "disabled", true );
                                        var id_inscrito = $('#id_inscrito').prop( "disabled", true );
										location.href="meus_resumos.php";

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
        var qtdautor = $("#qtdautor").val();
        for (i=1; i<=qtdautor; i++){
            if($("#cpf_autor"+i).val() == ""){
                alert("O campo de cpf do autor "+i+" é obrigatório");
                $("#cpf_autor"+i).focus();
                return;
            }
            if($("#nome_autor"+i).val() == ""){
                alert("O campo de nome do autor "+i+" é obrigatório");
                $("#nome_autor"+i).focus();
                return;
            }
            if($("#email_autor"+i).val() == ""){
                alert("O campo de e-mail do autor "+i+" é obrigatório");
                $("#email_autor"+i).focus();
                return;
            }
        }
    $("#form_trabalho").validate();
    if($("#form_trabalho").valid()){
        BootstrapDialog.show({
            type: BootstrapDialog.TYPE_DANGER,
            title: 'ATENÇÃO',
            message: 'Ao submeter o trabalho, este será enviado para avaliação, não será possível editar novamente após a submissão. Deseja realmente submeter?',
            buttons: [{
                id: 'btn-ok',   
                icon: 'glyphicon glyphicon-check',       
                label: 'Sim',
                cssClass: 'btn-success', 
                autospin: false,
                action: function(dialogRef){    
                    dialogRef.close();
                    $("#processando").modal("show");

                        var qtdautor = $("#qtdautor").val();
                        var cpf_autor = "cpf_autor";
                        var nome_autor = "nome_autor";
                        var instituicao_autor = "instituicao_autor";
                        var tipo_autor = "tipo_autor";
                        var apresentador = "apresentador";
                        var email_autor = "email_autor";

                        //console.log(dados);   
                        for (i=1; i<=qtdautor; i++){
                            window[cpf_autor+i] = $("#cpf_autor"+i).val();
                            window[nome_autor+i] = $("#nome_autor"+i).val();
                            window[email_autor+i] = $("#email_autor"+i).val();
                            window[tipo_autor+i] = $("#tipo_autor"+i).val();
                            window[instituicao_autor+i] = $("#instituicao_autor"+i).val();
                            window[apresentador+i] = $("#apresentador"+i).val();
                        }
                        var area = $("#area").val();
                        var area_especifica = $("#area_especifica").val();
                        var cpf = $('#cpf').val();
                        var instituicao = $('#instituicao').val();
                        var email = $("#email").val();
                        var nome = $("#nome").val();
                        var tipo_autor_responsavel = $("#tipo_autor_responsavel").val();
                        var apresentador_responsavel = $("#apresentador_responsavel").val();
                        var orgao_fomento = $("#orgao_fomento").val();
                        var titulo = $("#titulo").val();
                        var palavras_chave = $("#palavras_chave").val();
                        var categoria = $("#categoria").val();
						var apoio_financeiro = $('#apoio_financeiro').val();
						var protocolo_ceua = $('#protocolo_ceua').val();
						var protocolo_cep =  $('#protocolo_cep').val();
						var resumo_enviado = $('#resumo').val();
						var autorizacao_repositorio = $("#autorizacao_repositorio").attr("checked") ? 1 : 0;
                        var id_inscrito = $('#id_inscrito').val();
                        var programa_ic =$("#programa_ic").val();

                        var dados = "programa_ic="+programa_ic+"&autorizacao_repositorio="+autorizacao_repositorio+"&categoria="+categoria+"&protocolo_cep="+protocolo_cep+"&protocolo_ceua="+protocolo_ceua+"&apoio_financeiro="+apoio_financeiro+"&cpf="+cpf+"&nome="+nome+"&email="+email+"&instituicao="+instituicao+"&tipo_autor_responsavel="+tipo_autor_responsavel+"&apresentador_responsavel="+apresentador_responsavel+"&qtdautor="+qtdautor+"&area="+area+"&area_especifica="+area_especifica+"&palavras_chave="+palavras_chave+"&resumo_enviado="+resumo_enviado+"&orgao_fomento="+orgao_fomento+"&titulo="+titulo+"&id_inscrito="+id_inscrito+"&fgk_status=2";
				
						//var dados = 'categoria:'+categoria+', protocolo_cep:'+protocolo_cep+', protocolo_ceua:'+protocolo_ceua+', apoio_financeiro:'+apoio_financeiro+', tipo_autor_responsavel:'+tipo_autor_responsavel+', apresentador_responsavel:'+apresentador_responsavel+', qtdautor:'+ qtdautor+', area:'+area+', area_especifica:' +area_especifica+', palavras_chave:'+ palavras_chave+', resumo_enviado:'+ resumo_enviado+', orgao_fomento:'+ orgao_fomento+', titulo:'+titulo+', id_inscrito:'+ id_inscrito+', fgk_status: 1';
						if(qtdautor > 0){
							for (i=1; i <=$("#qtdautor").val(); i++){
								dados += '&cpf_autor'+i+'='+$("#cpf_autor"+i).val()+'&nome_autor'+i+'='+$("#nome_autor"+i).val()+'&email_autor'+i+'='+$("#email_autor"+i).val()+'&tipo_autor'+i+'='+$("#tipo_autor"+i).val()+'&instituicao_autor'+i+'='+$("#instituicao_autor"+i).val()+'&apresentador'+i+'='+$("#apresentador"+i).val();
								//dados += ',cpf_autor'+i+':'+$("#cpf_autor"+i).val()+',nome_autor'+i+':'+$("#nome_autor"+i).val()+',email_autor'+i+':'+$("#email_autor"+i).val()+',tipo_autor'+i+':'+$("#tipo_autor"+i).val()+',instituicao_autor'+i+':'+$("#instituicao_autor"+i).val()+',apresentador'+i+':'+$("#apresentador"+i).val();
							}
						}  
                        $.ajax({
                            url: "envio_cadastrar_trabalho.php",
                            type: "post",
                            data: dados,
                            success: function( data )
                            {
                                $("#processando").modal("hide");
                                if (data == "sucesso") {

                                    BootstrapDialog.show({
                                        type: BootstrapDialog.TYPE_DANGER,
                                        title: 'Obrigado',
                                        message: 'Trabalho submetido com sucesso',
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
                                    //$('#form_trabalho')[0].reset();
                                } 
                                else {
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
                }
            },{
                id: 'btn-ok',   
                icon: 'glyphicon glyphicon-check',       
                label: 'Não',
                cssClass: 'btn-danger', 
                autospin: false,
                action: function(dialogRef){    
                    dialogRef.close();
                }
            }]
        });


        }  else {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Erro',
                message: "Verifique os campos de seu trabalho",
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


});