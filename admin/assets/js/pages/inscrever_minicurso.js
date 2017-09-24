$(document).ready(function() {

    function submeterInscricao(){
        $("#form_trabalho").submit(function() {
            $("#processando").modal("show");
            var id_minicurso = $('#id_minicurso').val();
            var id_inscrito = $('#id_inscrito').val();
            var tipo_inscrito = $('#tipo_inscrito').val();
            var titulo = $('#titulo').val();
            var data_curso = $('#data').val();
            var local = $('#local').val();
            var hora_ini = $('#hora_ini').val();
            var hora_fim = $('#hora_fim').val();

            $.post('enviar_minicurso.php', {
                id_minicurso: id_minicurso, data_curso: data_curso, tipo_inscrito: tipo_inscrito, id_inscrito: id_inscrito, titulo: titulo, local: local, hora_ini: hora_ini, hora_fim: hora_fim }, 
                function(resposta) {
                    if (resposta == "sucesso") {
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Inscrição efetuada com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar.',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="minicursos.php";
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
        });
    }
     $("#submeter").click(function() {
        var titulo = $('#titulo').val();
        var r = confirm("Confirma a inscrição no minicurso "+titulo+" no valor de R$15,00?");
        if(r==true)
            submeterInscricao();
        else {
            return;
        }
        
    });

      function cancelarInscricao(){
        $("#form_trabalho").submit(function() {
            $("#processando").modal("show");
            var id_minicurso = $('#id_minicurso').val();
            var id_inscrito = $('#id_inscrito').val();
            var id_minicurso_inscrito = $('#id_minicurso_inscrito').val();
            var chave = $('#chave').val();
            var id_boleto = $('#id_boleto').val();
            var id_inscrito_servico = $('#id_inscrito_servico').val();
            var titulo = $('#titulo').val();

            $.post('cancelar_boleto.php', {
                id_inscrito_servico:id_inscrito_servico, id_minicurso: id_minicurso, id_inscrito: id_inscrito, titulo: titulo, chave: chave, id_boleto: id_boleto, id_minicurso_inscrito: id_minicurso_inscrito }, 
                function(resposta) {
                    if (resposta == "sucesso") {
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Inscrição cancelada com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar.',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="minicursos.php";
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
        });
    }

    $("#cancelar").click(function() {
        var titulo = $('#titulo').val();
        var r = confirm("Deseja cancelar a inscrição no minicurso "+titulo+" ?");
        if(r==true)
            cancelarInscricao();
        else {
            return;
        }
        
    });
	

});