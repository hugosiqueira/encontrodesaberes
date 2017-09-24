$(document).ready(function() {
    $("#enviar").click(function() {
        $("#processando").modal("show");
        $("#monitoria").submit(function() {
            var titulo = $("#titulo").val();
            var resumo = $("#resumo").val();
            var id_seminario = $("#id_seminario").val();
            var aluno_cpf = $("#aluno_cpf").val();
            var orientador_cpf = $("#orientador_cpf").val();
            var nome_aluno = $("#nome_aluno").val();
            var nome_orientador = $("#nome_orientador").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_monitoria.php', {titulo: titulo, resumo: resumo, id_seminario: id_seminario, fgk_status: 1, orientador_cpf: orientador_cpf, aluno_cpf: aluno_cpf, nome_aluno: nome_aluno, nome_orientador: nome_orientador}, 
                function(resposta) {
                    if (resposta == "sucesso") {                           
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Resumo salvo com sucesso.</p><p> ATENÇÃO: Esta opção é apenas para salvar o seu resumo. Quando finalizar, não esqueça de enviar o seu trabalho clicando no botão verde "Submeter Resumo"</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar.',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="index.php";
                                }
                            }]
                        });
                    } 
                    else {                            
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: 'Houve um erro ao submeter seu resumo, por favor preencha corretamente os campos',
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
    });

    $("#enviar2").click(function() {
        $("#monitoria").validate({
            rules: {
            titulo: {
                required: true
            },
            resumo: {
                required: true
            }
        },
        messages:{
            titulo: "Por favor informe o título do trabalho." ,
            resumo: "Por favor informe o resumo do trabalho"
        }
        });
        if($("#monitoria").valid())
        {
            $("#processando").modal("show");
            $("#monitoria").submit(function() {
                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var titulo = $("#titulo").val();
                var resumo = $("#resumo").val();
                var id_seminario = $("#id_seminario").val();
                var aluno_cpf = $("#aluno_cpf").val();
                var orientador_cpf = $("#orientador_cpf").val();
                var nome_aluno = $("#nome_aluno").val();
                var nome_orientador = $("#nome_orientador").val();
                var email_aluno = $("#email_aluno").val();
                var email_orientador = $("#email_orientador").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_monitoria.php', {titulo: titulo, resumo: resumo, id_seminario: id_seminario, fgk_status: 2, orientador_cpf: orientador_cpf, aluno_cpf: aluno_cpf, nome_aluno: nome_aluno, nome_orientador: nome_orientador, email_aluno: email_aluno, email_orientador: email_orientador}, 
                 function(resposta) {
                        // Quando terminada a requisição
                        // Exibe a div status
                        // Se a resposta é um erro
                        if (resposta == "sucesso") {
                            // Exibe o erro na div
                            
                            $("#processando").modal("hide");
                            BootstrapDialog.show({
                                type: BootstrapDialog.TYPE_DANGER,
                                closable: false,
                                title: 'Obrigado',
                                message: '<p>Resumo salvo com sucesso.</p>',
                                buttons: [{
                                    id: 'btn-ok',   
                                    icon: 'glyphicon glyphicon-check',       
                                    label: 'Fechar.',
                                    cssClass: 'btn-primary', 
                                    autospin: false,
                                    action: function(dialogRef){    
                                        dialogRef.close();
                                        location.href="index.php";
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
                                message: 'Houve um erro ao submeter seu resumo, por favor preencha corretamente os campos',
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
