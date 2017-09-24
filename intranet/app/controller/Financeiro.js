Ext.define('Seic.controller.Financeiro', {
    extend: 'Ext.app.Controller',
    stores: [
    	'Seic.store.Financeiro.gridPrincipal',
        'Seic.store.Financeiro.Boletos',
        'Seic.store.Financeiro.InscServicos',
        'Seic.store.Financeiro.Pagamentos',
        'Seic.store.Financeiro.TipoPagamentos',
        'Seic.store.Financeiro.TipoInscritos',
        'Seic.store.Financeiro.Instituicoes',
        'Seic.store.Financeiro.PgTipos'
    ],

    models: [
    	'Seic.model.Financeiro.gridPrincipal',
        'Seic.model.Financeiro.Boletos',
        'Seic.model.Financeiro.InscServicos',
        'Seic.model.Financeiro.Pagamentos',
        'Seic.model.Financeiro.TipoPagamentos',
        'Seic.model.Financeiro.TipoInscritos',
        'Seic.model.Financeiro.Instituicoes',
        'Seic.model.Financeiro.PgTipos'
    ],

    views: [
    	'Seic.view.Financeiro.mainFinanceiro',
        'Seic.view.Financeiro.infoInscritos',
        'Seic.view.Financeiro.InfoAddServico',
        'Seic.view.Financeiro.tabInscritos',
        'Seic.view.Financeiro.tabPagamentos',
        'Seic.view.Financeiro.buscaPagamentos',
        'Seic.view.Financeiro.buscaInscritos',
        'Seic.view.Financeiro.detailBoleto',
        'Seic.view.Financeiro.pgSelection'
        
    ],

    init: function() {
		this.control({
			'modfin_tabinscritos':{
				afterrender: this.LoadGrid,
                itemclick: this.AtivaBtnMain,
                destroy: this.LimpaFiltroGrid,
                itemdblclick: this.Informacoes
			},

            'modfin_tabpagamentos grid#gridPagamentos':{
                afterrender: this.LoadGrid
            },

            'modfin_tabpagamentos button#BA_pagamentos':{
                click: this.showBuscaAvancadaPG
            },

            'modfin_tabpagamentos button#btnLimpar2barra':{
                click: this.LimpaBuscaPagamentos
            },

            'modfin_infoaddservico grid#gridAddServico':{
                afterrender: this.LoadGrid,
                itemclick: this.AtivabtnAddServ
            },

            'modfin_infoaddservico button#addServico2Inscrito':{
                click: this.AddServ2Insc
            },

            'modfin_tabinscritos button#modfin_btnInformacao':{
                click: this.Informacoes
            },

            'modfin_tabinscritos button#modfin_btnDetalhamento':{
                click: this.Pre_Detalhamento
            },

            'modfin_tabinscritos button#BA_inscritos':{
                click: this.showBuscaAvancadaINSC
            },

            'modfin_tabinscritos button#btnLimpar2barra':{
                click: this.LimpaBuscaInscritos
            },

            'modfin_infoinscritos grid#inscServicos':{
                itemclick: this.AtivaBtnInfoS
            },

            'modfin_infoinscritos grid#inscBoletos':{
                itemclick: this.AtivaBtnInfoB
            },

            'modfin_infoinscritos button#receberServico':{
                click: this.PagamentoServico
            },

            // 'modfin_infoinscritos button#cancelarBoleto':{
            //     click: this.CancelaBoleto
            // },

            'modfin_infoinscritos button#visualizarBoleto':{
                click: this.ViewBoleto
            },

            'modfin_infoinscritos button#editarBoleto':{
                click: this.editarBoleto
            },

            'modfin_infoinscritos button#addServico':{
                click: this.AddServico
            },

            'modfin_infoinscritos button#removeServico':{
                click: this.RemoveServico
            },

            'buscapagamentos button#btnBuscar':{
                click: this.BuscaPagamentos
            },

            'buscapagamentos button#btnLimpar':{
                click: this.LimpaBuscaPagamentos
            },

            'buscainscritos button#btnBuscar':{
                click: this.BuscaInscritos
            },

            'buscainscritos button#btnLimpar':{
                click: this.LimpaBuscaInscritos
            },

            'modpfin_detailboleto displayfield#inscritoCPF':{
                change: this.preencheInscrito
            },

            'modpfin_detailboleto button#btnConfirmar':{
                click: this.CheckBoleto
            },

            'modfin_pgselection button#pgOk':{
                click: this.isValidCriaPG
            },

            'modfin_pgselection combobox#comboPg':{
                select: this.showDatePicker
            },

            'modfin_infoinscritos button#reenviarEmail':{
                click: this.reenviarEmail
            },

            'modfin_tabpagamentos button#btnExportarExcel':{
                click: this.exportarExcel
            },
		});
    },

    exportarExcel: function(button){
        var store = button.up('#modfin_tabpagamentos').down('grid').getStore();

        if(store.filters.items.length) //verifica se tem busca rapida
            buscaRapida = store.filters.items[0].value;
        else
            buscaRapida = "";
        Ext.Msg.show({
            title:   'Confirmação',
            msg:   'Deseja exportar os dados abaixo em uma planilha?',
            icon:   Ext.MessageBox.QUESTION,
            buttons: Ext.Msg.YESNO,
            fn: function(button){
                if(button=="yes"){
                    window.open("Server/financeiro/exportarExcel.php?buscaRapida="+buscaRapida
                        +"&tipo_pagamento="+store.proxy.extraParams.tipo_pagamento
                        +"&tipo_inscrito="+store.proxy.extraParams.tipo_inscrito
                        +"&fgk_instituicao="+store.proxy.extraParams.fgk_instituicao
                        +"&servico="+store.proxy.extraParams.servico
                        +"&dataMin="+store.proxy.extraParams.dataMin
                        +"&dataMax="+store.proxy.extraParams.dataMax
                    );
                }
            }
        });
    },

    editarBoleto: function(button){
        var record = button.up('window').down('#inscBoletos').getSelectionModel().getSelection()[0].data,
            win = Ext.create('Seic.view.Financeiro.editBoleto');

        win.show();
    },

    reenviarEmail: function(button){
        var record = button.up('window').down('#inscBoletos').getSelectionModel().getSelection()[0].data;

        Ext.Msg.show({
            title:'Confirmação',
            msg: 'Deseja reenviar este boleto por e-mail?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(button){
                if(button=="yes"){
                    Ext.Ajax.request({
                        waitMsg: 'Aguarde...',
                        url: 'Server/financeiro/reenviarEmail.php',
                        params: {   id_boleto: record.id_boleto },
                        disableCaching: false ,
                        success: function (res) {
                            if(Ext.JSON.decode(res.responseText).success)
                                Ext.Msg.alert({
                                    title: 'Informação',
                                    msg: 'Email reenviado com sucesso',
                                    buttons: Ext.Msg.OK,
                                    icon:   Ext.MessageBox.INFO
                                });
                            else
                                Ext.Msg.alert({
                                    title: 'Falha',
                                    msg: 'Entre em contato com o administrador do sistema.',
                                    buttons: Ext.Msg.OK,
                                    icon:   Ext.MessageBox.ERROR
                                });
                        }
                    });
                }
            }       
        });
    },

    showDatePicker: function(combo, records){
        var datepicker = combo.up('window').down('#dataVencimento');

        if(records[0].data.bool_boleto == 1){
            datepicker.enable();
            datepicker.show();
        }else{
            datepicker.disable();
            datepicker.hide();
        }
    },

    isValidCriaPG: function(button){
        var win = button.up('window');
        var recordBOL = Ext.getCmp('modfin_tabinscritos').getSelectionModel().getSelection()[0];
        if(win.down('form').isValid()){
            var id_forma_pagamento = win.down('#comboPg').getValue(), 
                id_ins_servico = Ext.getCmp('modfin_formInscINFO').up('window').down('#inscServicos').getSelectionModel().getSelection()[0].data.id_inscrito_servico,
                bool_boleto = win.down('#comboPg').findRecord('id_tipo_pagamento', id_forma_pagamento).data.bool_boleto;

            if(bool_boleto == 1)
                var dataVencimento = win.down('#dataVencimento').getSubmitData().dataVencimento;

            var myMask = new Ext.LoadMask({
                msg: 'Aguarde, gerando pagamento...',
                target: win
            });

            myMask.show();

            Ext.Ajax.request({
                url: 'Server/financeiro/criaPagamento.php',
                params: { 
                    id_inscrito_servico: id_ins_servico,
                    id_forma_pagamento: id_forma_pagamento,
                    dataVencimento: dataVencimento
                 },
                success: function(res){
                    myMask.hide();
                    if(Ext.JSON.decode(res.responseText).success){
                        Ext.Msg.alert({
                            title: 'Informação',
                            msg: Ext.JSON.decode(res.responseText).msg,
                            buttons: Ext.Msg.OK,
                            icon:   Ext.MessageBox.INFO
                        });
                        Ext.getCmp('modfin_formInscINFO').up('window').down('#inscServicos').getStore().load({
                            params:{ id: recordBOL.data.id }
                        }); 

                        Ext.getCmp('modfin_formInscINFO').up('window').down('#inscBoletos').getStore().load({
                            params:{ id: recordBOL.data.id }
                        }); 

                        win.close();
                    }else{
                        Ext.Msg.alert({
                            title: 'Erro',
                            msg: Ext.JSON.decode(res.responseText).msg,
                            buttons: Ext.Msg.OK,
                            icon:   Ext.MessageBox.ERROR
                        });
                    }
                },
                failure: function(conn, response, options, eOpts) {
                    Ext.Msg.show({
                        title:'Erro',
                        msg: 'Entre em contato com o administrador do sistema. ERRO_01CON',
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            });

        }else
            Ext.Msg.show({
                title:'Erro',
                msg: 'Selecione uma forma de pagamento antes de continuar.',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            }); 
    },

    CheckBoleto: function(button){
        var form = button.up('window').down('form');

        if(form.isValid()){
            var record = Ext.JSON.encode(form.getValues(false, false, true, false));

            Ext.Ajax.request({
                url: 'Server/financeiro/registraBoleto.php',
                params: { boleto: record },
                success: function(conn, response, options, eOpts){
                    var result = Ext.JSON.decode(conn.responseText, true);
                    console.log(result)
                },
                failure: function(conn, response, options, eOpts) {
                    Ext.Msg.show({
                        title:'Erro',
                        msg: 'Entre em contato com o administrador do sistema. ERRO_01CON',
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            });

            button.up('window').destroy();

        }else
            Ext.Msg.alert('Erro', 'Existem campos vazios, ou inválidos.');
    },

    preencheInscrito: function(cpffield, isValid){
        if(isValid){
            var myMask = new Ext.LoadMask({
                msg: 'Aguarde, procurando inscrito...',
                target: Ext.getCmp('modfin_fieldsetDetailIsc')
            });

            myMask.show();

            Ext.Ajax.request({
                url: 'Server/financeiro/buscaCpf.php',
                params: { cpf: cpffield.getValue() },
                success: function(conn, response, options, eOpts){
                    var result = Ext.JSON.decode(conn.responseText, true);
                    myMask.hide();

                    if(result.msg){
                        Ext.getCmp('modfin_formIscNome').setValue(result.msg.nome);
                        Ext.getCmp('modfin_formIscEmail').setValue(result.msg.email);
                        Ext.getCmp('modfin_formIscTipo').setValue(result.msg.descricao_tipo);
                    }else{
                        Ext.Msg.show({
                            title: 'Erro',
                            msg: 'Inscrito não encontrado em nossa base de dados.',
                            icon: Ext.Msg.ERROR,
                            buttons: Ext.Msg.OK
                        });
                        myMask.hide();
                        cpffield.setValue('');
                    }

                },
                failure: function(conn, response, options, eOpts) {
                    Ext.Msg.show({
                        title:'Erro',
                        msg: 'Entre em contato com o administrador do sistema. ERRO_01CON',
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            });
        }else{
            Ext.getCmp('modfin_formIscNome').setValue('');
            Ext.getCmp('modfin_formIscEmail').setValue('');
            Ext.getCmp('modfin_formIscTipo').setValue('');
        }
    },

    Pre_Detalhamento: function(button){
        Ext.Msg.prompt('Detalhamento', 'Por favor, insira a chave do boleto', function(btn, text){
            if (btn == 'ok'){
                var winDetail = Ext.create('Seic.view.Financeiro.detailBoleto');
                    winDetail.show();
                var mask = new Ext.LoadMask({
                    msg: 'Por favor, aguarde...',
                    target: winDetail
                });

                mask.show();
                Ext.Ajax.request({
                    waitMsg: 'Aguarde...',
                    url: 'Server/financeiro/detalharBoleto.php',
                    params: { chave: text },
                    disableCaching: false ,
                    success: function (res) {
                        if(Ext.JSON.decode(res.responseText).success){
                            mask.hide();
                            var record = Ext.create('Seic.model.Financeiro.Detalhamento');
                            record.set(Ext.JSON.decode(res.responseText).boleto);
                            winDetail.down('form').loadRecord(record);
                        }else
                            Ext.Msg.alert({
                                title: 'Aviso',
                                msg: 'Boleto não encontrado no sistema.',
                                buttons: Ext.Msg.OK,
                                icon:   Ext.MessageBox.ERROR,
                                fn: function(btn) {
                                    if (btn === 'ok') {
                                        winDetail.destroy();
                                    } 
                                }
                            });
                    }
                });
            }
        });
    },

    LimpaBuscaInscritos: function(button){
        var form = button.up('window').down('form');
        if(form)
            form.getForm().reset();
        else
            Ext.getCmp('modfin_buscainscritos').destroy();

        var gridStore = Ext.getCmp('modfin_tabinscritos').getStore();
        gridStore.getProxy().extraParams = {};
        gridStore.load();
        Ext.getCmp('modcfin_barraBuscaInscritos').setVisible(false);
    },

    BuscaInscritos: function(button){
        var win = button.up('window');
        var filtros = win.down('form').getValues(false, true, false, false);

        var gridStore = Ext.getCmp('modfin_tabinscritos').getStore();
        gridStore.getProxy().extraParams = filtros;
        gridStore.load();
        win.hide();

        var toolbar = Ext.getCmp('modcfin_barraBuscaInscritos');
        toolbar.show();

        toolbar.removeAll();
        toolbar.add({
            xtype: 'label', 
            text: 'Filtros aplicados:',
            style: {
                color: 'white'
            }
        });

        Ext.Object.each(filtros, function(key, value, myself) {
            if(key == 'cpf')
                var newKey = 'CPF';
            else if(key == 'nome')
                var newKey = 'Nome';
            else if(key == 'tipo_inscrito')
                var newKey = 'Tipo de inscrito';
            else if(key == 'instituicao')
                var newKey = 'Instituição';
            else if(key == 'quite'){
                if(value == 0){
                    var newKey = 'Sem pedências: não';
                }else if( value == 1){
                    var newKey = 'Sem pedências: sim';
                }
            }else if(key == 'credenciado'){
                if(value == 0){
                    var newKey = 'Credenciado: não';
                }else if( value == 1){
                    var newKey = 'Credenciado: sim';
                }
            }else if(key == 'num_servicos')
                var newKey = 'Número de serviços: '+value;


            toolbar.add({text: newKey});    
        });

        toolbar.add('->');
        toolbar.add({
            text: 'Limpar filtros',
            itemId: 'btnLimpar2barra',
            iconCls: 'icon-clear',
            width: 110
        });
    },

    showBuscaAvancadaINSC: function(button){
        var win = Ext.getCmp('modfin_buscainscritos');
        if (!win)
            Ext.create('Seic.view.Financeiro.buscaInscritos');
        else
            win.show();
    },

    LimpaBuscaPagamentos: function(button){
        var form = button.up('window').down('form');
        if(form)
            form.getForm().reset();
        else
            Ext.getCmp('modfin_buscapagamentos').destroy();

        var gridStore = Ext.getCmp('modfin_tabpagamentos').down('#gridPagamentos').getStore();
        gridStore.getProxy().extraParams = {};
        gridStore.load();
        Ext.getCmp('modcfin_barraBuscaPagamentos').setVisible(false);
        Ext.getCmp('modfin_receitaEventoFiltro').setVisible(false);
    },

    BuscaPagamentos: function(button){
        var win = button.up('window');
        var filtros = win.down('form').getValues(false, true, false, false);

        var gridStore = Ext.getCmp('modfin_tabpagamentos').down('#gridPagamentos').getStore();
        gridStore.getProxy().extraParams = filtros;
        gridStore.load();
        win.hide()

        Ext.getCmp('modfin_receitaEventoFiltro').show();
        var toolbar = Ext.getCmp('modcfin_barraBuscaPagamentos');
        toolbar.show();

        toolbar.removeAll();
        toolbar.add({
            xtype: 'label', 
            text: 'Filtros aplicados:',
            style: {
                color: 'white'
            }
        });
        var sizeFiltros = Ext.Object.getSize(filtros);
        var i = 0, dataMin  = 0, dataMax = 0, valueMin = 0, valueMax = 0;

        Ext.Object.each(filtros, function(key, value, myself) {
            i += 1;
            
            if(key == 'servico')
                var newKey = 'Tipo de serviço';
            else if(key == 'tipo_pagamento')
                var newKey = 'Tipo de pagamento';
            else if(key == 'tipo_inscrito')
                var newKey = 'Tipo de inscrito';
            else if(key == 'dataMin'){
                dataMin = 'Pago após o dia: '+Ext.Date.format(new Date(value), 'd/m/Y');
                valueMin = value;
            }else if(key == 'dataMax'){
                dataMax = 'Pago antes do dia: '+Ext.Date.format(new Date(value), 'd/m/Y');
                valueMax = value;
            }

            if(i == sizeFiltros){
                if((valueMin == valueMax) && (valueMin != 0) && (valueMax != 0)){
                    toolbar.add({text: 'Pago no dia: '+Ext.Date.format(new Date(value), 'd/m/Y') });  
                }else{
                    if(dataMin)
                        toolbar.add({text: dataMin}); 
                    if(dataMax)
                        toolbar.add({text: dataMax}); 
                }
            }
            if(newKey)
                toolbar.add({text: newKey});    
        });

        toolbar.add('->');
        toolbar.add({
            text: 'Limpar filtros',
            itemId: 'btnLimpar2barra',
            iconCls: 'icon-clear',
            width: 110
        });
    },

    showBuscaAvancadaPG: function(button, e, eopts){
        var win = Ext.getCmp('modfin_buscapagamentos');
        if (!win)
            Ext.create('Seic.view.Financeiro.buscaPagamentos');
        else
            win.show();
    },

    ViewBoleto: function(button){
        var record = button.up('window').down('#inscBoletos').getSelectionModel().getSelection()[0].data;

        Ext.create('Ext.window.Window', {
            title: 'Boleto',
            iconCls: 'financeiro-minishortcut',
            height: 750,
            width: 750,             
            modal: true,
            constrain: true,
            layout: 'fit',
            html: "<iframe src='"+record.link+"' width='100%'' height='100%' frameborder=0> </iframe>"
        }).show();
    },

    CancelaBoleto: function(button){
        var record = button.up('window').down('#inscBoletos').getSelectionModel().getSelection()[0].data;
        var StoreIS = button.up('window').down('#inscServicos').getStore();
        var StoreBOL = button.up('window').down('#inscBoletos').getStore();
        var recordBOL = Ext.getCmp('modfin_tabinscritos').getSelectionModel().getSelection()[0];

        if(record.bool_pago == 1)
            Ext.Msg.alert('Alerta', 'Este boleto já foi pago, não pode mais ser cancelado.');
        else
            Ext.Msg.show({
                title:'Confirmação',
                msg: 'Cancelar o boleto de <b>'+record.descricao_servico+'</b></br>no valor de <b>R$ '+Ext.util.Format.number(record.valor_servico/100, '0.0,0')+'</b></br>.',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function(button){
                    if(button=="yes"){
                        Ext.Ajax.request({
                            waitMsg: 'Aguarde...',
                            url: 'Server/financeiro/cancelarBoleto.php',
                            params: {   id_boleto: record.id_boleto },
                            disableCaching: false ,
                            success: function (res) {
                                if(Ext.JSON.decode(res.responseText).success){
                                    StoreIS.load({
                                        params:{ id: recordBOL.data.id }
                                    });                                
                                    StoreBOL.load({
                                        params:{ id: recordBOL.data.id }
                                    });
                                }else
                                    Ext.Msg.alert({
                                        title: 'Falha',
                                        msg: 'Entre em contato com o administrador do sistema.',
                                        buttons: Ext.Msg.OK,
                                        icon:   Ext.MessageBox.ERROR
                                    });
                            }
                        });
                    }
                }       
            });
    },
    
    AddServ2Insc: function(button){
        var win = button.up('window');
        var recordGridServico = win.down('grid').getSelectionModel().getSelection()[0];
        var inscritoId = Ext.getCmp('modfin_formInscINFO').getRecord().data.id ;
        var StoreIS = Ext.getCmp('modfin_formInscINFO').down('#inscServicos').getStore();

        var record = Ext.create('Seic.model.Financeiro.InscServicos',{
            id_servico: recordGridServico.data.id,
            valor_servico: recordGridServico.data.valor_servico
        });

        Ext.Msg.show({
            title:'Confirmação',
            msg: 'Adicionar serviço: <b>'+recordGridServico.data.descricao_servico+'</b></br> no valor de <b>R$'
                +Ext.util.Format.number(recordGridServico.data.valor_servico/100, '0.0,0')+' </b>?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(button){
                if(button=="yes"){
                    StoreIS.getProxy().setExtraParam( 'id', inscritoId );
                    StoreIS.add(record);
                    StoreIS.sync();
                    StoreIS.load();
                }
            }       
        });
        win.destroy();
    },

    RemoveServico: function(button){
        var StoreIS = button.up('window').down('#inscServicos').getStore();
        var StoreBOL = button.up('window').down('#inscBoletos').getStore();
        var recordIS = button.up('window').down('#inscServicos').getSelectionModel().getSelection()[0];
        var recordInscrito = Ext.getCmp('modfin_tabinscritos').getSelectionModel().getSelection()[0];

        if(recordIS.data.bool_pago == '1')
            Ext.Msg.alert('Alerta', 'Este serviço já foi pago, não pode mais ser removido.');
        else
            Ext.Msg.show({
                title:'Confirmação',
                msg: 'Excluir este serviço?</br><b>'+recordIS.data.descricao_servico+'</b>',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.QUESTION,
                fn: function(button){
                    if(button=="yes"){
                        StoreIS.remove(recordIS);
                        StoreIS.sync();
                        StoreBOL.load({
                            params:{ id: recordInscrito.data.id }
                        });
                    }
                }       
            });
    },

    PagamentoServico: function(button){
        Ext.create('Seic.view.Financeiro.pgSelection').show();
    },

    AddServico: function(button){
        Ext.create('Seic.view.Financeiro.InfoAddServico').show();
    },

    Informacoes: function(button){
        var win = Ext.create('Seic.view.Financeiro.infoInscritos')
        var record = button.up('grid').getSelectionModel().getSelection()[0];
        win.down('form').loadRecord(record);
        
        win.show();
        win.down('#inscServicos').getStore().load({
            params:{
                id: record.data.id
            }
        });

        win.down('#inscBoletos').getStore().load({
            params:{
                id: record.data.id
            }
        });
    },

    Fechar: function(button){
    	button.up('window').close();
    },

    LoadGrid: function(grid){
        var store = grid.getStore();
        store.getProxy().extraParams = {};
    	store.load();
    },

    AtivaBtnMain: function(grid, record){
        grid.up('window').down('#modfin_btnInformacao').setDisabled(false);
    },

    AtivaBtnInfoS: function(grid, record){
        var win = grid.up('window');
        win.down('#removeServico').setDisabled(false);
        if(record.data.bool_pago == 0)
            win.down('#receberServico').setDisabled(false);
        else
            win.down('#receberServico').setDisabled(true);
    },

    AtivaBtnInfoB: function(grid, record){
        var win = grid.up('window');
        win.down('#editarBoleto').enable();
        win.down('#visualizarBoleto').enable();
        win.down('#reenviarEmail').enable();
    },

    AtivabtnAddServ: function(grid){
        grid.up('window').down('#addServico2Inscrito').setDisabled(false);
    },

    LimpaFiltroGrid: function(grid){
        grid.getStore().clearFilter();
    }
});
