$(document).ready(function() {
    function submeterTrabalho(){
        if($("#conclusao").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre a conclusão.',
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
        if($("#resultado").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre o resultado.',
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
        if($("#metodologia").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre aa metodologia.',
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
        if($("#titulo").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre o título.',
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
        if($("#redacao").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre a redação.',
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
        if($("#nota").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe a nota do trabalho.',
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
        if($("#nota").val() < 0 || $("#nota").val() > 10){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe a nota do trabalho corretamente. Mínimo: 0 Máximo: 10.',
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
        if(!$("#form_avaliacao input[type='radio']:checked").val()){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o resultado final sobre o trabalho.',
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
        if($("#justificativa").val()==="" && ($("#form_avaliacao input[type='radio']:checked").val()==="AR"||$("#form_avaliacao input[type='radio']:checked").val()==="R")){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe uma justificativa para o seu resultado.',
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


            var id_avaliacao_revisao = $("#id_avaliacao_revisao").val();
            var fgk_avaliacao = $("#fgk_avaliacao").val();
            var fgk_revisor = $("#fgk_revisor").val();
            var conclusao = $("#conclusao").val();
            var resultado = $("#resultado").val();
            var metodologia = $("#metodologia").val();
            var titulo = $("#titulo").val();
            var redacao = $("#redacao").val();
            var nota = $("#nota").val();
            var resultado_final = $("#form_avaliacao input[type='radio']:checked").val();
            var justificativa = $("#justificativa").val();
            var parecer = $("#parecer").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_avaliacao.php', {id_avaliacao_revisao: id_avaliacao_revisao,fgk_avaliacao: fgk_avaliacao, fgk_revisor: fgk_revisor, 
                bool_ativada:1, aval_conclusao: conclusao, aval_resultado: resultado, aval_metodologia: metodologia, aval_titulo: titulo, 
                aval_redacao: redacao, nota: nota, resultado: resultado_final, justificativa: justificativa, parecer: parecer, status: 2 }, 
                function(resposta) {
                    if (resposta === "sucesso") {                           
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Avaliação submetida com sucesso.</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="revisao_trabalhos.php";
                                }
                            }]
                        });
                    } else {                            
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: 'Houve um erro ao salvar sua avaliação, por favor preencha corretamente os campos',
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

    }
    $('[data-toggle="tooltip"]').tooltip(); 
	
    $("#enviar").click(function() {
        if($("#conclusao").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre a conclusão.',
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
        if($("#resultado").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre o resultado.',
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
        if($("#metodologia").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre aa metodologia.',
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
        if($("#titulo").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre o título.',
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
        if($("#redacao").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o conceito sobre a redação.',
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
        if($("#nota").val()===""){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe a nota do trabalho.',
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
        if($("#nota").val() < 0 || $("#nota").val() > 10){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe a nota do trabalho corretamente. Mínimo: 0 Máximo: 10.',
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
        if(!$("#form_avaliacao input[type='radio']:checked").val()){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe o resultado final sobre o trabalho.',
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
        if($("#justificativa").val()==="" && ($("#form_avaliacao input[type='radio']:checked").val()==="AR"||$("#form_avaliacao input[type='radio']:checked").val()==="R")){
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: 'Atenção',
                message: 'Por favor, informe uma justificativa para o seu resultado.',
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


            var id_avaliacao_revisao = $("#id_avaliacao_revisao").val();
            var fgk_avaliacao = $("#fgk_avaliacao").val();
            var fgk_revisor = $("#fgk_revisor").val();
            var conclusao = $("#conclusao").val();
            var resultado = $("#resultado").val();
            var metodologia = $("#metodologia").val();
            var titulo = $("#titulo").val();
            var redacao = $("#redacao").val();
            var nota = $("#nota").val();
            var resultado_final = $("#form_avaliacao input[type='radio']:checked").val();
            var justificativa = $("#justificativa").val();
            var parecer = $("#parecer").val();

            // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
            $.post('envio_avaliacao.php', {id_avaliacao_revisao: id_avaliacao_revisao,fgk_avaliacao: fgk_avaliacao, fgk_revisor: fgk_revisor, 
                bool_ativada:1, aval_conclusao: conclusao, aval_resultado: resultado, aval_metodologia: metodologia, aval_titulo: titulo, 
                aval_redacao: redacao, nota: nota, resultado: resultado_final, justificativa: justificativa, parecer: parecer, status: 1 }, 
                function(resposta) {
                    if (resposta === "sucesso") {                           
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            closable: false,
                            title: 'Obrigado',
                            message: '<p>Avaliação salva com sucesso.</p><p> ATENÇÃO: Esta opção é apenas para salvar a sua avaliação. Quando finalizar, não esqueça de enviar a sua avaliação clicando no botão verde "Submeter Avaliação"</p>',
                            buttons: [{
                                id: 'btn-ok',   
                                icon: 'glyphicon glyphicon-check',       
                                label: 'Fechar',
                                cssClass: 'btn-primary', 
                                autospin: false,
                                action: function(dialogRef){    
                                    dialogRef.close();
                                    location.href="revisao_trabalhos.php";
                                }
                            }]
                        });
                    } else {                            
                        $("#processando").modal("hide");
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Erro',
                            message: 'Houve um erro ao salvar sua avaliação, por favor preencha corretamente os campos',
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
    
    $("#enviar2").click(function() {
        var r = confirm("Após submeter a revisão você não poderá editá-la novamente. Deseja continuar?");
        if(r==true)
            submeterTrabalho();
        else {
            return;
        }
        
    });
});
