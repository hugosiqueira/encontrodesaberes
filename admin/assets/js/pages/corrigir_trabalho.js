$(document).ready(function() {

     $("#submeter").click(function() {
        var r = confirm("Deseja realmente submeter a sua correção do resumo? Esta ação é irreversível!");
        if(r==true)
            submeterTrabalho();
        else {
            return;
        }
        
    });

    function submeterTrabalho(){
        
            if($("#titulo").val()===""){
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Atenção',
                    message: 'Por favor, informe o título do trabalho.',
                    buttons: [{
                        id: 'btn-ok',   
                        icon: 'glyphicon glyphicon-check',       
                        label: 'OK',
                        cssClass: 'btn-primary', 
                        autospin: false,
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                    }]
                });
                return;
            }
            if($("#palavras_chave").val()===""){
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Atenção',
                    message: 'Por favor, informe as palavras-chave do trabalho.',
                    buttons: [{
                        id: 'btn-ok',   
                        icon: 'glyphicon glyphicon-check',       
                        label: 'OK',
                        cssClass: 'btn-primary', 
                        autospin: false,
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                    }]
                });
                return;
            }
             if($("#resumo").val()===""){
                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Atenção',
                    message: 'Por favor, informe o resumo do trabalho.',
                    buttons: [{
                        id: 'btn-ok',   
                        icon: 'glyphicon glyphicon-check',       
                        label: 'OK',
                        cssClass: 'btn-primary', 
                        autospin: false,
                        action: function(dialogRef){    
                            dialogRef.close();
                        }
                    }]
                });
                return;
            }
            $("#processando").modal("show");
            var id_trabalho = $('#id_trabalho').val();
            var palavras_chave = $('#palavras_chave').val();
            var palavras_chave = palavras_chave.replace("<", " < ");
             var resumo_enviado = $('#resumo').val();

                var resumo_enviado = resumo_enviado.replace(/&/g, "&amp;")
                var resumo_enviado = resumo_enviado.replace(/</g, "&lt;")
                var resumo_enviado = resumo_enviado.replace(/>/g, "&gt;")
                var resumo_enviado = resumo_enviado.replace(/"/g, "&quot;")
                var resumo_enviado = resumo_enviado.replace(/'/g, "&#039;");
            $.post('enviar_correcao.php', {
                id_trabalho: id_trabalho, palavras_chave: palavras_chave, resumo: resumo_enviado, fgk_status: 13 }, 
                function(resposta) {
                    if (resposta == "sucesso") {
                        
                        $("#processando").modal("hide");
                         BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Correção enviada com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar.',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="correcoes.php";
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
                            message: 'Houve um erro ao enviar seu trabalho, por favor entre em contato com a organização.',
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
        
    }
	

});