$(document).ready(function() {

     $("#enviar").click(function() {
        $("#mobilidade").validate({
            rules: {
            periodo_cursava: {
                required: true
            },
            tempo_afastamento: {
                required: true
            },
            tipo_mobilidade: {
                required: true
            },
            universidade_destino: {
                required: true
            },
            cidade_destino: {
                required: true
            },
            pais_destino: {
                required: true
            },
            curso_destino: {
                required: true
            },
            curso_area_destaque: {
                required: true
            },
            questoes_linguisticas: {
                required: true
            },
            tipo_moradia: {
                required: true
            },
            sistema_avaliacao: {
                required: true
            },
            dinamica_metodologia_aulas: {
                required: true
            },
            custo_vida: {
                required: true
            },
            infra_universidade: {
                required: true
            },
            servico_acolhimento: {
                required: true
            },
            estagio: {
                required: true
            },
            atividades_universidade: {
                required: true
            },
            processo_adaptacao: {
                required: true
            },
            relato_pessoal: {
                required: true
            },
            conselhos_calouro: {
                required: true
            }
        },
        messages:{
            periodo_cursava: "Por favor informe o período que cursava." ,
            tempo_afastamento: "Por favor informe o tempo que ficou afastado",
            tipo_mobilidade: "Por favor informe o tipo de mobilidade" ,
            universidade_destino: "Por favor informe a universidade de destino",
            cidade_destino: "Por favor informe a cidade de destino",
            pais_destino: "Por favor informe o país de destino",
            curso_destino: "Por favor informe o curso de destino",
            curso_area_destaque: "Atenção campo obrigatório",
            questoes_linguisticas: "Atenção campo obrigatório",
            tipo_moradia: "Atenção campo obrigatório",
            sistema_avaliacao: "Atenção campo obrigatório",
            dinamica_metodologia_aulas: "Atenção campo obrigatório",
            custo_vida: "Atenção campo obrigatório",
            infra_universidade: "Atenção campo obrigatório",
            servico_acolhimento: "",
            estagio: "",
            atividades_universidade: "Atenção campo obrigatório",
            processo_adaptacao: "Atenção campo obrigatório",
            relato_pessoal: "Atenção campo obrigatório",
            conselhos_calouro: "Atenção campo obrigatório" 

        }
        });
        if($("#mobilidade").valid())
        {
            $("#processando").modal("show");
            
                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var cpf = $("#cpf").val();
                var nome_aluno = $("#nome_aluno").val();
                var curso_aluno = $("#curso_aluno").val();
                var periodo_cursava = $("#periodo_cursava").val();
                var tempo_afastamento = $("#tempo_afastamento").val();
                var tipo_mobilidade = $("#tipo_mobilidade").val();
                var universidade_destino = $("#universidade_destino").val();
                var cidade_destino = $("#cidade_destino").val();
                var pais_destino = $("#pais_destino").val();
                var curso_destino = $("#curso_destino").val();
                var curso_area_destaque = $("#curso_area_destaque").val();
                var questoes_linguisticas = $("#questoes_linguisticas").val();
                var tipo_moradia = $("#tipo_moradia").val();
                var sistema_avaliacao = $("#sistema_avaliacao").val();
                var dinamica_metodologia_aulas = $("#dinamica_metodologia_aulas").val();
                var custo_vida = $("#custo_vida").val();
                var infra_universidade = $("#infra_universidade").val();
                var servico_acolhimento = $("#servico_acolhimento").val();
                var estagio = $("#estagio").val();
                var atividades_universidade = $("#atividades_universidade").val();
                var processo_adaptacao = $("#processo_adaptacao").val();
                var relato_pessoal = $("#relato_pessoal").val();
                var conselhos_calouro = $("#conselhos_calouro").val();
                var id_trabalho_caint = $("#id_trabalho_caint").val();

                // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
                $.post('envio_mobilidade.php', {cpf: cpf, nome_aluno: nome_aluno, curso_aluno: curso_aluno,
                periodo_cursava: periodo_cursava, tempo_afastamento: tempo_afastamento, tipo_mobilidade: tipo_mobilidade,
                universidade_destino: universidade_destino, cidade_destino: cidade_destino, pais_destino: pais_destino,
                curso_destino: curso_destino, curso_area_destaque: curso_area_destaque, questoes_linguisticas: questoes_linguisticas,
                tipo_moradia: tipo_moradia, sistema_avaliacao: sistema_avaliacao, dinamica_metodologia_aulas: dinamica_metodologia_aulas,
                custo_vida: custo_vida, infra_universidade: infra_universidade, servico_acolhimento: servico_acolhimento, estagio: estagio,
                atividades_universidade: atividades_universidade, processo_adaptacao: processo_adaptacao, relato_pessoal: relato_pessoal,
                conselhos_calouro: conselhos_calouro, fgk_status: 1, id_trabalho_caint: id_trabalho_caint }, 
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
        $("#mobilidade").validate({
            rules: {
            periodo_cursava: {
                required: true
            },
            tempo_afastamento: {
                required: true
            },
            tipo_mobilidade: {
                required: true
            },
            universidade_destino: {
                required: true
            },
            cidade_destino: {
                required: true
            },
            pais_destino: {
                required: true
            },
            curso_destino: {
                required: true
            },
            curso_area_destaque: {
                required: true
            },
            questoes_linguisticas: {
                required: true
            },
            tipo_moradia: {
                required: true
            },
            sistema_avaliacao: {
                required: true
            },
            dinamica_metodologia_aulas: {
                required: true
            },
            custo_vida: {
                required: true
            },
            infra_universidade: {
                required: true
            },
            servico_acolhimento: {
                required: true
            },
            estagio: {
                required: true
            },
            atividades_universidade: {
                required: true
            },
            processo_adaptacao: {
                required: true
            },
            relato_pessoal: {
                required: true
            },
            conselhos_calouro: {
                required: true
            }
        },
        messages:{
            periodo_cursava: "Por favor informe o período que cursava." ,
            tempo_afastamento: "Por favor informe o tempo que ficou afastado",
            tipo_mobilidade: "Por favor informe o tipo de mobilidade" ,
            universidade_destino: "Por favor informe a universidade de destino",
            cidade_destino: "Por favor informe a cidade de destino",
            pais_destino: "Por favor informe o país de destino",
            curso_destino: "Por favor informe o curso de destino",
            curso_area_destaque: "Atenção campo obrigatório",
            questoes_linguisticas: "Atenção campo obrigatório",
            tipo_moradia: "Atenção campo obrigatório",
            sistema_avaliacao: "Atenção campo obrigatório",
            dinamica_metodologia_aulas: "Atenção campo obrigatório",
            custo_vida: "Atenção campo obrigatório",
            infra_universidade: "Atenção campo obrigatório",
            servico_acolhimento: "",
            estagio: "",
            atividades_universidade: "Atenção campo obrigatório",
            processo_adaptacao: "Atenção campo obrigatório",
            relato_pessoal: "Atenção campo obrigatório",
            conselhos_calouro: "Atenção campo obrigatório" 

        }
        });
        if($("#mobilidade").valid())
        {
            $("#processando").modal("show");

                // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
                var cpf = $("#cpf").val();
                var nome_aluno = $("#nome_aluno").val();
                var curso_aluno = $("#curso_aluno").val();
                var periodo_cursava = $("#periodo_cursava").val();
                var tempo_afastamento = $("#tempo_afastamento").val();
                var tipo_mobilidade = $("#tipo_mobilidade").val();
                var universidade_destino = $("#universidade_destino").val();
                var cidade_destino = $("#cidade_destino").val();
                var pais_destino = $("#pais_destino").val();
                var curso_destino = $("#curso_destino").val();
                var curso_area_destaque = $("#curso_area_destaque").val();
                var questoes_linguisticas = $("#questoes_linguisticas").val();
                var tipo_moradia = $("#tipo_moradia").val();
                var sistema_avaliacao = $("#sistema_avaliacao").val();
                var dinamica_metodologia_aulas = $("#dinamica_metodologia_aulas").val();
                var custo_vida = $("#custo_vida").val();
                var infra_universidade = $("#infra_universidade").val();
                var servico_acolhimento = $("#servico_acolhimento").val();
                var estagio = $("#estagio").val();
                var atividades_universidade = $("#atividades_universidade").val();
                var processo_adaptacao = $("#processo_adaptacao").val();
                var relato_pessoal = $("#relato_pessoal").val();
                var conselhos_calouro = $("#conselhos_calouro").val();
                var id_trabalho_caint = $("#id_trabalho_caint").val();

                // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
                $.post('envio_mobilidade.php', {cpf: cpf, nome_aluno: nome_aluno, curso_aluno: curso_aluno,
                periodo_cursava: periodo_cursava, tempo_afastamento: tempo_afastamento, tipo_mobilidade: tipo_mobilidade,
                universidade_destino: universidade_destino, cidade_destino: cidade_destino, pais_destino: pais_destino,
                curso_destino: curso_destino, curso_area_destaque: curso_area_destaque, questoes_linguisticas: questoes_linguisticas,
                tipo_moradia: tipo_moradia, sistema_avaliacao: sistema_avaliacao, dinamica_metodologia_aulas: dinamica_metodologia_aulas,
                custo_vida: custo_vida, infra_universidade: infra_universidade, servico_acolhimento: servico_acolhimento, estagio: estagio,
                atividades_universidade: atividades_universidade, processo_adaptacao: processo_adaptacao, relato_pessoal: relato_pessoal,
                conselhos_calouro: conselhos_calouro, fgk_status: 2, id_trabalho_caint: id_trabalho_caint  }, 
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
                            var cpf = $("#cpf").prop( "disabled", true );
                            var nome_aluno = $("#nome_aluno").prop( "disabled", true );
                            var curso_aluno = $("#curso_aluno").prop( "disabled", true );
                            var periodo_cursava = $("#periodo_cursava").prop( "disabled", true );
                            var tempo_afastamento = $("#tempo_afastamento").prop( "disabled", true );
                            var tipo_mobilidade = $("#tipo_mobilidade").prop( "disabled", true );
                            var universidade_destino = $("#universidade_destino").prop( "disabled", true );
                            var cidade_destino = $("#cidade_destino").prop( "disabled", true );
                            var pais_destino = $("#pais_destino").prop( "disabled", true );
                            var curso_destino = $("#curso_destino").prop( "disabled", true );
                            var curso_area_destaque = $("#curso_area_destaque").prop( "disabled", true );
                            var questoes_linguisticas = $("#questoes_linguisticas").prop( "disabled", true );
                            var tipo_moradia = $("#tipo_moradia").prop( "disabled", true );
                            var sistema_avaliacao = $("#sistema_avaliacao").prop( "disabled", true );
                            var dinamica_metodologia_aulas = $("#dinamica_metodologia_aulas").prop( "disabled", true );
                            var custo_vida = $("#custo_vida").prop( "disabled", true );
                            var infra_universidade = $("#infra_universidade").prop( "disabled", true );
                            var servico_acolhimento = $("#servico_acolhimento").prop( "disabled", true );
                            var estagio = $("#estagio").prop( "disabled", true );
                            var atividades_universidade = $("#atividades_universidade").prop( "disabled", true );
                            var processo_adaptacao = $("#processo_adaptacao").prop( "disabled", true );
                            var relato_pessoal = $("#relato_pessoal").prop( "disabled", true );
                            var conselhos_calouro = $("#conselhos_calouro").prop( "disabled", true );
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
});