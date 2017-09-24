$(document).ready(function() {
    $("#enviar").click(function() {    
        if($("#justificativa").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe uma justificativa para o não envio de seu trabalho.',
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
        $("#form_avaliacao").submit(function() {

            var id_trabalho = $("#id_trabalho").val();
            var justificativa = $("#justificativa").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_justificativa.php', {id_trabalho: id_trabalho, justificativa: justificativa }, 
                function(resposta) {
                    if (resposta === "sucesso") {                           
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Justificativa submetida com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="meus_resumos.php";
                                }
                            }]
                        });
                    } else {                            
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: 'Houve um erro ao salvar sua justificativa, somente o orientador pode justificar.',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
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
});
