$.validator.addMethod('cpf',function(value,element,param) {
 $return = true;

       // this is mostly not needed
       var invalidos = [
       '111.111.111-11',
       '222.222.222-22',
       '333.333.333-33',
       '444.444.444-44',
       '555.555.555-55',
       '666.666.666-66',
       '777.777.777-77',
       '888.888.888-88',
       '999.999.999-99',
       '000.000.000-00'
       ];
       for(i=0;i<invalidos.length;i++) {
        if( invalidos[i] == value) {
            $return = false;
        }
    }

    value = value.replace("-","");
    value = value.replace(/\./g,"");

        //validando primeiro digito
        add = 0;
        for ( i=0; i < 9; i++ ) {
            add += parseInt(value.charAt(i), 10) * (10-i);
        }
        rev = 11 - ( add % 11 );
        if( rev == 10 || rev == 11) {
            rev = 0;
        }
        if( rev != parseInt(value.charAt(9), 10) ) {
            $return = false;
        }

        //validando segundo digito
        add = 0;
        for ( i=0; i < 10; i++ ) {
            add += parseInt(value.charAt(i), 10) * (11-i);
        }
        rev = 11 - ( add % 11 );
        if( rev == 10 || rev == 11) {
            rev = 0;
        }
        if( rev != parseInt(value.charAt(10), 10) ) {
            $return = false;
        }

        return $return;
    });
$(document).ready(function() {


    $("#enviar").click(function() {
		
        var $validator = $("#form_perfil").validate({
			
            rules: {
                nome: {
                    required: true,
                    minlength: 6
                },
                cpf: {
                    cpf:true
                },
                telefone_celular: {
                    required:true
                },
                email: {
                    required: true,
                    email: true
                },
                endereco: {
                    required: true
                },
                numero: {
                    required: true
                },
                bairro: {
                    required: true
                },
                cidade: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: "Por favor preencha seu nome completo.",
                    minlength: "Por favor preencha seu nome completo."
                },
                cpf: "Por favor preencha seu cpf corretamente.",
                telefone_celular: "Por favor preencha com seu telefone celular.",
                email: "Por favor preencha com um e-mail válido.",
                endereco: "Por favor preencha o seu endereço.",
                numero: "Por favor preencha o número de sua moradia.",
                bairro: "Por favor preencha o seu bairro.",
                cidade: "Por favor preencha a sua cidade."
            }
        });
		
        if($("#form_perfil").valid()){
            $("#processando").modal("show");

            //desabilita o botão de cadastro
            $("#enviar").prop("disabled", true);
			
			var dados = $("#form_perfil").serialize();
			
				$.ajax({
					url: "enviar_perfil.php",
					type: "post",
					data: dados ,
					success: function (response) {

						if(response == "sucesso"){

							// Esconde modal carregando
							$("#processando").modal("hide");

							//habilita novamente o botão de cadastro
							$("#enviar").prop("disabled", false);

							// Exibe mensagem de sucesso
							BootstrapDialog.show({
								type: BootstrapDialog.TYPE_SUCCESS,
								title: 'Sucesso',
								message: 'Dados pessoais atualizados com sucesso.',
								buttons: [{
									id: 'btn-ok',       
									label: 'Fechar',
									cssClass: 'btn-success', 
									autospin: false,
									action: function(dialogRef){    
										dialogRef.close();
									}
								}]
							});

						} else {

							// Esconde modal carregando
							$("#processando").modal("hide");

							//habilita novamente o botão de cadastro
							$("#enviar").prop("disabled", false);

							// Exibe o erro na div
							BootstrapDialog.show({
								type: BootstrapDialog.TYPE_DANGER,
								title: 'Erro',
								message: response,
								buttons: [{
									id: 'btn-ok',         
									label: 'Fechar',
									cssClass: 'btn-danger', 
									autospin: false,
									action: function(dialogRef){    
										dialogRef.close();
									}
								}]
							});
						}            
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(textStatus, errorThrown);
					}
			
				});


        }  else {
            alert("entrou");
        }
    });
	
	$("#btn-alterar-senha").click(function() {
        var $validator = $("#form_senha").validate({
            rules: {
                senha_atual: {
                    required: true
                },
                senha: {
                    required: true,
                    minlength: 6
                },
                csenha: {
                    required: true,
                    minlength: 6,
                    equalTo: "#senha"
                }
            },
            messages: {
                senha_atual: {
                    required: "Por favor preencha sua senha atual"
                },
                senha: {
                    required: "Por favor preencha sua senha.",
                    minlength: "Sua senha deve ter no mínimo 6 caracteres."
                }, 
                csenha: {
                    required: "Por favor preencha sua senha.",
                    minlength: "Sua senha deve ter no mínimo 6 caracteres.",
                    equalTo: "As senhas devem ser idênticas."
                }

            }
        });

        if($("#form_senha").valid()){

            $('#alterar_senha').modal('hide');

            $("#processando").modal("show");

            //desabilita o botão de cadastro
            $("#btn-alterar-senha").prop("disabled", true);

            // Salva todos os campos na variável dados
            var dados = $("#form_senha").serialize();
                
            $.ajax({
                url: "envio_alterar_senha.php",
                type: "post",
                data: dados ,
                success: function (response) {

                    if(response == "sucesso"){

                        // Esconde modal carregando
                        $("#processando").modal("hide");

                        //desabilita o botão de cadastro
                        $("#btn-alterar-senha").prop("disabled", false);

                        //reseta o form de senha


                        // Exibe mensagem de sucesso
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_SUCCESS,
                            title: 'Sucesso',
                            message: 'Senha alterada com sucesso.',
                            buttons: [{
                                id: 'btn-ok',       
                                label: 'Fechar',
                                cssClass: 'btn-success', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                }
                            }]
                        });

                    } else {

                        // Esconde modal carregando
                        $("#processando").modal("hide");

                        //desabilita o botão de cadastro
                        $("#btn-alterar-senha").prop("disabled", false);

                        //habilita novamente o botão de cadastro
                        $("#enviar").prop("disabled", false);

                        // Exibe o erro na div
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: response,
                            buttons: [{
                                id: 'btn-ok',         
                                label: 'Fechar',
                                cssClass: 'btn-danger', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                }
                            }]
                        });
                    }            
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });

        }  else {
            return false;
        }
    });
});