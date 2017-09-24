Ext.define('Seic.controller.Credenciamento', {
    extend: 'Ext.app.Controller',
    stores: [
        'Credenciamento.Credenciamento',
        'Credenciamento.Presencas',
        'Credenciamento.Inscritos'
    ],

    models: [
        'Credenciamento.Credenciamento',
        'Credenciamento.Presencas',
        'Credenciamento.Inscritos'
    ],
    
    views: [
        'Credenciamento.mainCredenciamento',
        'Credenciamento.Credenciar',
        'Credenciamento.InscRapida',
        'Credenciamento.buscaInscritos',
        'Credenciamento.viewPresenca',
        'Credenciamento.novaPresenca',
        'Credenciamento.destinoPresenca'
    ],

    init: function() {
        this.control({
            'modcre_maincredenciamento':{
                afterrender: this.gridLoad,
                itemclick: this.ativBtns
            },

            'modcre_maincredenciamento button#modcre_btnCancelar':{
                click: this.fechar
            },

            'modcre_receberinscricao button#modcre_btnCancelar':{
                click: this.fechar
            },

            'modcre_maincredenciamento button#modcre_btnCredenciar':{
                click: this.credenciarinscrito
            },

            'modcre_maincredenciamento button#presencaBtn':{
                click: this.viewPresenca
            },

            'modcre_maincredenciamento button#modcre_btnEdit':{
                click: this.editarCredencial
            },

            'modcre_credenciarinscrito button#modcre_btnPrint':{
                click: this.imprimiCredencial
            },

            'modcre_credenciarinscrito textfield#modcre_cpfinscrito':{
                validitychange: this.buscaInscrito
            },

            'modcre_credenciarinscrito button#salvarCredencial':{
                click: this.salvaCredencial
            },

            'modcre_credenciarinscrito button#gravarCredencial':{
                click: this.gravarCredencial
            },

            'modcre_maincredenciamento button#modcre_btnCadR':{
                click: this.viewInscRapido
            },

            'modcre_inscrapida combobox#comboEstado':{
                select: this.ativCmbCidade
            },

            'modcre_inscrapida form#formIscrito':{
                validitychange: this.ativfieldSet
            },

            'modcre_inscrapida button#gravarNovo':{
                click: this.gravaInscRapida
            },

            'modcre_maincredenciamento button#printRelatorio':{
                click: this.imprimiRelatorio
            },

            'modcre_maincredenciamento button#buscaAvancada':{
                click: this.viewBuscaA
            },

            'modcrebuscainscritos button#btnBuscar':{
                click: this.buscarInscritos
            },

            'modcrebuscainscritos button#btnLimpar':{
                click: this.limpaBuscaA
            },

            'modcre_maincredenciamento button#btnLimpar2barra':{
                click: this.limpaBuscaA
            },

            'modcre_viewpresenca button#btnAdd':{
                click: this.addPresenca
            },

            'modcre_novapresencapop button#btnGrava':{
                click: this.salvaNovaPresenca
            },

            'modcre_viewpresenca button#btnApaga':{
                click: this.apagaPresencaUsuario
            },

            'modcre_viewpresenca button#btnTrans':{
                click: this.selectDestino
            },

            'modcre_tranpresenca combobox#comboInscritos':{
                select: this.tranferirPresenca
            }
        });
    },

    visualizarCertificado_0102: function(button) {
        var grid = button.up('grid');
        if(grid.getSelectionModel().hasSelection()){
            Ext.Msg.show({
                title:   'Confirmação',
                msg:     'Deseja aplicar máscara de fundo neste certificado?',
                buttons: Ext.Msg.YESNOCANCEL,
                fn: function(button){
                    if(button=="yes"){
                        var row = grid.getSelectionModel().getSelection()[0];
                        url = 'http://www.eventsystem.com.br/admin/gerar_certificado.php?c='+row.data.chave_autenticidade+'&f=1';
                        window.open(url,'_blank');

                    }
                    else if(button=="no"){
                        var row = grid.getSelectionModel().getSelection()[0];
                        url = 'http://www.eventsystem.com.br/admin/gerar_certificado.php?c='+row.data.chave_autenticidade+'&f=2';;
                        window.open(url,'_blank');
                    }
                    else {  }
                },
                animEl: 'elId',
                icon:   Ext.MessageBox.QUESTION
            });
        }
        else{
            Ext.Msg.alert({
                title: 'Atenção',
                msg: 'Selecione um certificado para visualizar.',
                buttons: Ext.Msg.OK
            });
        }
    },

    tranferirPresenca: function(combo, records){
        var grid = Ext.getCmp('modcre_viewpresenca').down('grid'),
            ids = [];

        grid.getStore().each(function(record){
            if(record.get('check') == true){
                ids.push(record.data.id_presenca);
                record.set('check') == false;
            }
        });

        if(!Ext.isEmpty(ids)){
            Ext.Ajax.request({
                url: 'Server/credenciamento/transferePresenca.php',
                params: { ids: Ext.JSON.encode(ids), inscrito: combo.getValue()},
                success: function(conn, response, options, eOpts){
                    Ext.Msg.show({
                        title:'Presença',
                        msg: 'Presença transferida com sucesso.',
                        icon: Ext.Msg.INFO,
                        buttons: Ext.Msg.OK
                    });
                    Ext.getCmp('modcre_viewpresenca').down('#gridPresenca').getStore().load();
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
                msg: 'Não existem presencas selecionadas.',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });

        combo.up('window').close();
    },

    selectDestino: function(button){
        Ext.create('Seic.view.Credenciamento.destinoPresenca').show();
    },

    apagaPresencaUsuario: function(button){
        var ids = [];
        button.up('window').down('#gridPresenca').getStore().each(function(record){
            if(record.get('check') == true){
                ids.push(record.data.id_presenca);
                record.set('check') == false;
            }
        });

        if(!Ext.isEmpty(ids)){
            Ext.MessageBox.confirm('Apagar presença', 'Tem certeza que deseja apagar esta presença?',
            function(button){
                if(button == 'yes')
                    Ext.Ajax.request({
                        url: 'Server/credenciamento/apagaPresenca.php',
                        params: { id: Ext.JSON.encode(ids)},
                        success: function(conn, response, options, eOpts){
                            Ext.Msg.show({
                                title:'Presença',
                                msg: 'Presença apagada com sucesso.',
                                icon: Ext.Msg.INFO,
                                buttons: Ext.Msg.OK
                            });
                            Ext.getCmp('modcre_viewpresenca').down('#gridPresenca').getStore().load();
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
            });
        }else
            Ext.Msg.show({
                title:'Erro',
                msg: 'Não existem presencas selecionadas.',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });
    },

    salvaNovaPresenca: function(button){
        var data = button.up('window').down('#data').getValue(),
            modelHora = button.up('window').down('#hora').getSelectionModel(),
            fgk_local = button.up('window').down('#comboLocal').getValue(),
            id = button.up('window').down('#id').getValue(),
            sendData = data.getFullYear() + '-' + (data.getMonth()+1) + '-' + data.getDate() ;

        if( modelHora.hasSelection() && (!Ext.isEmpty(fgk_local)) ){
            var hora = modelHora.getSelection()[0].data.disp;

            Ext.Ajax.request({
                url: 'Server/credenciamento/criaPresenca.php',
                params: { hora: hora, data: sendData, local: fgk_local , id: id},
                success: function(conn, response, options, eOpts){
                    Ext.Msg.show({
                        title:'Presença',
                        msg: 'Nova presença criada com sucesso.',
                        icon: Ext.Msg.INFO,
                        buttons: Ext.Msg.OK
                    });
                    button.up('window').close();
                    Ext.getCmp('modcre_viewpresenca').down('#gridPresenca').getStore().load();
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
                msg: 'Existem dados não selecionados.',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });
    },

    addPresenca: function(button){
        var win = Ext.create('Seic.view.Credenciamento.novaPresenca');

        var id = Ext.getCmp('modcre_maincredenciamento').getSelectionModel().getSelection()[0].data.id;
        win.down('#id').setValue(id);
        win.show();
    },

    viewPresenca: function(button){
        var selected = Ext.getCmp('modcre_maincredenciamento').getSelectionModel().getSelection()[0].data;

        var win = Ext.create('Seic.view.Credenciamento.viewPresenca');
        win.down('#nomeInscrito').setValue(selected.nome);
        win.down('grid').getStore().getProxy().setExtraParam( 'id', selected.id_inscrito );
        win.show();
    },

    limpaBuscaA: function(button){
        var form = button.up('window').down('form');
        if(form)
            form.getForm().reset();
        else
            Ext.getCmp('modpre_buscainscritos').destroy();

        var gridStore = Ext.getCmp('modcre_maincredenciamento').getStore();
        gridStore.getProxy().extraParams = {};
        gridStore.load();
        Ext.getCmp('modcre_barraBusca').setVisible(false);
    },

    buscarInscritos: function(button){
        var win = button.up('window');
        var filtros = win.down('form').getValues(false, true, false, false);

        var gridStore = Ext.getCmp('modcre_maincredenciamento').getStore();
        gridStore.getProxy().extraParams = filtros;
        gridStore.load();
        win.hide();

        var toolbar = Ext.getCmp('modcre_barraBusca');
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

    viewBuscaA: function(){
        var win = Ext.getCmp('modpre_buscainscritos');
        if(win)
            win.show()
        else
            Ext.create('Seic.view.Credenciamento.buscaInscritos').show();
    },

    imprimiRelatorio: function(button){
        var params = Ext.getCmp('modcre_maincredenciamento').getStore().getProxy().extraParams;

        Ext.Ajax.request({
            url: 'Server/credenciamento/printRelatorio.php',
            params: { param: Ext.JSON.encode(params) },
            success: function(conn, response, options, eOpts){
                Ext.create('Ext.window.Window', {
                    title: 'Relatório de presenças',
                    iconCls:'credenciamento-minishortcut',
                    height: 750,
                    width: 750,             
                    modal: true,
                    constrain: true,
                    layout: 'fit',
                    html: conn
                }).show();
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

    },

    gravaInscRapida: function(button){
        var formData = button.up('window').down('form').getValues(false, false, true, true);
        if(button.up('window').down('form').isValid()){
            Ext.Ajax.request({
                url: 'Server/credenciamento/InscricaoRapida.php',
                params: { insc: Ext.JSON.encode(formData) },
                success: function(conn, response, options, eOpts){
                    var result = Ext.JSON.decode(conn.responseText, true);
                    if(result.success){
                        button.up('window').close();
                        Ext.getCmp('modcre_maincredenciamento').getStore().load();
                        Ext.Msg.show({
                            title: 'Informação',
                            msg: result.msg,
                            icon: Ext.Msg.INFO,
                            buttons: Ext.Msg.OK,
                            fn: function(btn) {
                                var wincred = Ext.create('Seic.view.Credenciamento.Credenciar').show();
                                wincred.down('#id').setValue(result.id_novoInscrito);
                                wincred.down('#salvarCredencial').setVisible(true);

                                if(formData.cpf){
                                    wincred.down('#modcre_cpfinscrito').setValue(formData.cpf);
                                }else{
                                    wincred.down('#modcre_cpfinscrito').setValue(formData.passaporte);
                                }
                            }
                        });
                    }else
                        Ext.Msg.show({
                            title:'Erro',
                            msg: result.msg,
                            icon: Ext.Msg.ERROR,
                            buttons: Ext.Msg.OK
                        });
                    button.up('window').down('form').getForm().reset();
                },
                failure: function(conn, response, options, eOpts) {
                    button.up('window').down('form').getForm().reset();
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
                msg: 'Existem campos vazios, ou preenchidos incorretamente.',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });
    },

    ativfieldSet: function(form){
        if(form.isValid())
            Ext.getCmp('modcre_inscrapida').down('#fieldEndereco').setDisabled(false);
    },

    ativCmbCidade: function(combo, records){
        var comboCidade = combo.up('window').down('#comboCidade');
        comboCidade.getStore().getProxy().extraParams = { id_estado: records[0].data.id_estado };
        comboCidade.getStore().load();
        comboCidade.setDisabled(false);
    },

    viewInscRapido: function(){
        var win = Ext.create('Seic.view.Credenciamento.InscRapida');
        Ext.Msg.show({
            title:'Nacionalidade',
            msg: 'O novo inscrito é brasileiro?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(btn) {
                if (btn === 'yes') {
                    win.down('#cpfInsc').setDisabled(false);
                    win.down('#cpfInsc').show();

                    win.down('#comboEstado').setDisabled(false);
                    win.down('#comboEstado').show();

                    win.down('#comboCidade').show();

                    win.down('#estrangeiro').setValue('0');
                    win.show();

                }else if (btn === 'no') {
                    win.down('#passInsc').setDisabled(false);
                    win.down('#passInsc').show();

                    win.down('#textEstado').setDisabled(false);
                    win.down('#textEstado').show();

                    win.down('#textCidade').setDisabled(false);
                    win.down('#textCidade').show();

                    win.down('#inscCEP').setDisabled(true);
                    win.down('#inscCEP').hide();

                    win.down('#estrangeiro').setValue('1');
                    win.show();
                } 
            }
        });
    },

    gravarCredencial: function(button){
        var button = button, php = 'gravaCredencial';
        this.SaveEditCred(button, php);
    },

    salvaCredencial: function(button){
        var php = 'criaCredencial';
        this.SaveEditCred(button, php);
        this.imprimiCredencial();
        button.up('window').close();
        Ext.getCmp('modcre_maincredenciamento').down('#modcre_btnEdit').setDisabled(false);
        Ext.getCmp('modcre_maincredenciamento').down('#modcre_btnCredenciar').setDisabled(true);
    },  

    editarCredencial: function(){
        var record = Ext.getCmp('modcre_maincredenciamento').getSelectionModel().getSelection()[0];
        if(record){
            var win = Ext.create('Seic.view.Credenciamento.Credenciar');
            win.down('#gravarCredencial').setVisible(true);
            win.down('#modcre_btnPrint').setVisible(true);
            win.show()
            win.down('form').loadRecord(record);

            // var settings = {
            //  output: "svg",
            //  bgColor: "#FFFFFF",
            //  color: "#000000",
            //  barWidth: "1",
            //  barHeight: "50",
            //  moduleSize: "5",
            //  posX: "10",
            //  posY: "20",
            //  addQuietZone: "1"
            // };

   //       $jq("#inscBarcodeEL").barcode(record.data.barcode, "ean8", settings);

        }
    },

    SaveEditCred: function(button, php){
        var win = Ext.getCmp('modcre_credenciarinscrito');
        var formData = Ext.JSON.encode(win.down('form').getValues(false, false, true, false));
        var myMask = new Ext.LoadMask({
                msg: 'Por favor, aguarde...',
                target: win
            }).show();

        Ext.Ajax.request({
            url: 'Server/credenciamento/'+php+'.php',
            params: { insc: formData },
            success: function(conn, response, options, eOpts){
                myMask.hide();
                var result = Ext.JSON.decode(conn.responseText, true);
                if(result.success)
                    Ext.Msg.show({
                        title:'Informação',
                        msg: result.msg,
                        icon: Ext.Msg.INFO,
                        buttons: Ext.Msg.OK
                    });
                else
                    Ext.Msg.show({
                        title:'Erro',
                        msg: result.msg,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                Ext.getCmp('modcre_maincredenciamento').getStore().load();
            },
            failure: function(conn, response, options, eOpts) {
                myMask.hide();
                Ext.Msg.show({
                    title:'Erro',
                    msg: 'Entre em contato com o administrador do sistema. ERRO_01CON',
                    icon: Ext.Msg.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        });
    },

    imprimiCredencial: function(button){
        var options = { 
            mode: 'iframe', 
            popClose: true, 
            extraCss: '', 
            retainAttr: '', 
            extraHead : '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>' 
        };

        $jq('#divCredencial').printArea(options);

     //    html2canvas($jq('#divCredencial'), {
        //   onrendered: function(canvas) {
        //      button.up('window').down('#image2print').setSrc(canvas.toDataURL());
        //      $jq('#image2print').printArea(options);
        //   }
        // });
        
    },

    credenciarinscrito: function(){
        var record = Ext.getCmp('modcre_maincredenciamento').getSelectionModel().getSelection()[0];
        if(record){
            var win = Ext.create('Seic.view.Credenciamento.Credenciar');
            win.down('#salvarCredencial').setVisible(true);
            win.show();
            win.down('form').loadRecord(record);
        }
    },

    ativBtns: function(grid, record, item){
        // if((record.data.quite == 1)||(record.data.quite == 2)){
            if(record.data.bool_cracha == 1){
                grid.up('window').down('#modcre_btnCredenciar').setDisabled(true);
                grid.up('window').down('#modcre_btnEdit').setDisabled(false);
            }else{
                grid.up('window').down('#modcre_btnCredenciar').setDisabled(false);
                grid.up('window').down('#modcre_btnEdit').setDisabled(true);
            }
        // }else{
        //     grid.up('window').down('#modcre_btnCredenciar').setDisabled(true);
        //     grid.up('window').down('#modcre_btnEdit').setDisabled(true);
        // }

        if(record.data.credencial == 1)
            grid.up('window').down('#presencaBtn').setDisabled(false);
        else
            grid.up('window').down('#presencaBtn').setDisabled(true);
    },

    buscaInscrito: function(cpffield, isValid){
        var myMask = new Ext.LoadMask({
            msg: 'Aguarde, procurando inscrito...',
            target: Ext.getCmp('modcre_formInscrito')
        });

        myMask.show();

        Ext.Ajax.request({
            url: 'Server/credenciamento/buscaInscrito.php',
            params: {
                cpf: cpffield.getValue()
            },
            success: function(conn, response, options, eOpts){
                var result = Ext.JSON.decode(conn.responseText, true);
                myMask.hide();

                if(result.success){
                    cpffield.up('window').down('#divCredencial').setTitle(result.evento);
                    cpffield.up('window').down('#inscEmail').setValue(result.email);
                    cpffield.up('window').down('#inscNome').setValue(result.nome_credencial);
                    cpffield.up('window').down('#inscBarcode').setValue(result.barcode);
                    cpffield.up('window').down('#nomeCred').setValue(result.nome_credencial);
                    if(result.info_credencial)
                        cpffield.up('window').down('#nomeInst').setValue(result.info_credencial);
                }else{
                    Ext.Msg.show({
                        title:'Erro',
                        msg: 'Inscrito não encontrado em nossa base de dados.',
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
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
    },

    fechar: function(button){
        button.up('window').close();
    },

    gridLoad: function(grid){
        grid.getStore().load();
    }
});
