
$(document).ready(function() {
    $("#enviar").click(function() {
        $("#processando").modal("show");

        var data = $('#form_duvidas').serialize();

        $.ajax({
            url: "envio_duvidas.php",
            type: "post",
            data: data,
            success: function( data ){

                if (data == "sucesso") {
                    $("#processando").modal("hide");
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Obrigado',
                        message: 'Sua mensagem foi enviada com sucesso. Aguarde nosso retorno',
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

    })

});
