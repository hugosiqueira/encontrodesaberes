
$(document).ready(function() {

    $("#enviar").click(function(event){
        $("#proposta_minicurso").validate({
            rules: {
                area: {
                    required: true
                },
                assunto: {
                    required: true
                },
                resumo: {
                    required: true,
                    minlength: 10
                }

            },
            messages: {
                area: "Por favor selecione uma área específica",
                assunto: "Por favor informe o assunto",
                resumo: {
                    required: "Por favor insira o resumo de sua proposta",
                    minlength: "Por favor insira no mínimo 10 palavras"
                }
            }
        });
        if($("#proposta_minicurso").valid())
        {
            $("#processando").modal("show");
            $("#proposta_minicurso").submit(function() {
                var area_especifica = $("#area").val();
                var assunto = $("#assunto").val();
                var resumo = $("#resumo").val();
                var fgk_inscrito = $("#fgk_inscrito").val();
                var id_proposta = $("#id_proposta").val();
                var nome_professor = $("#nome_professor").val();
                var telefone_professor = $("#telefone_professor").val();
                var email_professor = $("#email_professor").val();
                var departamento_professor = $("#departamento_professor").val();
                var cpf_professor = $("#cpf").val();
                $.post('enviar_proposta_minicurso.php', {
                    area_especifica: area_especifica, assunto: assunto, resumo: resumo, fgk_inscrito: fgk_inscrito, status:1, id_proposta: id_proposta, nome_professor: nome_professor, 
                    telefone_professor: telefone_professor, email_professor: email_professor, departamento_professor: departamento_professor, cpf_professor: cpf_professor}, 
                    function(resposta) {
                        if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");

                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                closable: false,
                                title: 'Obrigado',
                                message: '<p>Proposta de minicurso salva com sucesso.</p><p> ATENÇÃO: Esta opção é apenas para salvar o sua proposta de minicurso. Quando finalizar, não esqueça de enviar o seu trabalho clicando no botão verde "Submeter Proposta"</p>',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="proposta_minicurso.php";
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
                                message: 'Houve um erro ao submeter sua proposta, por favor preencha corretamente os campos',
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

        }  else {
            return false;
        }
});

$("#enviar2").click(function(event) {
    $("#proposta_minicurso").validate({
       rules: {
            area: {
                required: true
            },
            assunto: {
                required: true
            },
            resumo: {
                required: true,
                minlength: 10
            }

        },
        messages: {
            area: "Por favor selecione uma área específica",
            assunto: "Por favor informe o assunto",
            resumo: {
                required: "Por favor insira o resumo de sua proposta",
                minlength: "Por favor insira no mínimo 10 palavras"
            }
        }
    });
    if($("#proposta_minicurso").valid())
    {
        $("#processando").modal("show");
        $("#proposta_minicurso").submit(function() {
           var area_especifica = $("#area").val();
                var assunto = $("#assunto").val();
                var resumo = $("#resumo").val();
                var fgk_inscrito = $("#fgk_inscrito").val();
                var id_proposta = $("#id_proposta").val();
                var nome_professor = $("#nome_professor").val();
                var telefone_professor = $("#telefone_professor").val();
                var email_professor = $("#email_professor").val();
                var departamento_professor = $("#departamento_professor").val();
                var cpf_professor = $("#cpf").val();
                $.post('enviar_proposta_minicurso.php', {
                    area_especifica: area_especifica, assunto: assunto, resumo: resumo, fgk_inscrito: fgk_inscrito, status:1, id_proposta: id_proposta, nome_professor: nome_professor, 
                    telefone_professor: telefone_professor, email_professor: email_professor, departamento_professor: departamento_professor, cpf_professor: cpf_professor}, 
                function(resposta) {
                    if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");
                            $( "#area" ).prop( "disabled", true );
                            $( "#assunto" ).prop( "disabled", true );
                            $( "#resumo" ).prop( "disabled", true );
                            $( "#enviar" ).prop( "disabled", true );
                            $( "#enviar2" ).prop( "disabled", true );
  
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Obrigado',
                                closable: false,
                                message: 'Proposta de minicurso submetida com sucesso.',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="proposta_minicurso.php";
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
                                message: 'Houve um erro ao submeter seu trabalho, por favor preencha corretamente os campos',
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

            }  else {
                return false;
            }
});

});