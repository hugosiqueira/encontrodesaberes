Ext.define('Seic.controller.Presenca', {
    extend: 'Ext.app.Controller',
    stores: [
    	'Seic.store.Presenca.Inscritos',
        'Seic.store.Presenca.Checkpoints',
        'Seic.store.Presenca.Chart1'
    ],

    models: [
    	'Seic.model.Presenca.Inscritos',
        'Seic.model.Presenca.Checkpoints',
        'Seic.model.Presenca.Chart1'
    ],
    
    views: [
    	'Seic.view.Presenca.mainPresenca',
        'Seic.view.Presenca.Alerta',
        'Seic.view.Presenca.buscaAvancada',
        'Seic.view.Presenca.infoCheckpoints'
    ],

    init: function() {
		this.control({
			'modpre_mainpresenca':{
				afterrender: this.defineLocal
			},

            'modpre_mainpresenca button#BA_presencas':{
                click: this.viewBusca
            },

			'modpre_mainpresenca numberfield#codcred':{
				// change: this.ValidaCod,
				specialkey: this.codEnter
			},

            'modpre_buscavancada button#busca':{
                click: this.buscarPresenca
            },

            'modpre_buscavancada button#fechar':{
                click: this.close
            },

            'modpre_mainpresenca button#btnLimpar2barra':{
                click: this.limpaBusca
            },

            'modpre_mainpresenca button#infoCheckpoints':{
                click: this.presencaChart
            },

            'infocheckpointschart':{
                afterrender: this.loadchart
            }
		});
    },

    loadchart: function(win){
        win.down('chart').getStore().load();
    },

    presencaChart: function(button){
        Ext.create('Seic.view.Presenca.infoCheckpoints').show();
    },

    limpaBusca: function(button){
        button.up('toolbar').hide();
        button.up('window').down('#modpre_paggingPresenca').hide();
        Ext.getCmp('modpre_modpre_buscavancada').close();

        var gridStore = Ext.getCmp('modpre_mainpresenca').down('#gridPresencas').getStore();
        gridStore.getProxy().setExtraParam('busca', '');
        gridStore.load();

    },

    close: function(button){
        button.up('window').hide();
    },

    buscarPresenca: function(button){
        var record = button.up('window').down('form').getValues(false, false, true, false);

        var gridStore = Ext.getCmp('modpre_mainpresenca').down('#gridPresencas').getStore();
        gridStore.getProxy().setExtraParam('busca', Ext.JSON.encode(record));
        gridStore.load();

        //////////////BARRA DE BUSCA
        Ext.getCmp('modpre_paggingPresenca').show();
        var toolbar = Ext.getCmp('modpre_barraBusca');
        toolbar.show();

        toolbar.removeAll();
        toolbar.add({
            xtype: 'label', 
            text: 'Filtros aplicados:',
            style: {
                color: 'white'
            }
        });
        var sizeFiltros = Ext.Object.getSize(record);
        var i = 0, dataMin  = 0, dataMax = 0, valueMin = 0, valueMax = 0;

        Ext.Object.each(record, function(key, value, myself) {
            i++;
            
            if((key == 'nome')&&(value != ""))
                var newKey = 'Nome';
            else if((key == 'id_checkpoint')&&(value != ""))
                var newKey = 'Checkpoint';
            else if((key == 'dateMin')&&(value != "")){
                dataMin = 'Presença após o dia: '+Ext.Date.format(new Date(value), 'd/m/Y');
                valueMin = value;
            }else if((key == 'dateMax')&&(value != "")){
                dataMax = 'Presença antes do dia: '+Ext.Date.format(new Date(value), 'd/m/Y');
                valueMax = value;
            }

            if(i == sizeFiltros){
                if((valueMin == valueMax) && (valueMin != 0) && (valueMax != 0)){
                    toolbar.add({text: 'Presença no dia: '+Ext.Date.format(new Date(value), 'd/m/Y') });  
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

        button.up('window').hide();
    },

    viewBusca: function(button){
        var win = Ext.getCmp('modpre_modpre_buscavancada');
        if(win)
            win.show();
        else
            Ext.create('Seic.view.Presenca.buscaAvancada').show();
    },

    defineLocal: function(panel){
    	Ext.Ajax.request({
            url: 'Server/presenca/localPresencas.php',
            disableCaching: false,
            success: function(conn, response, options, eOpts){
                var result = Ext.JSON.decode(conn.responseText, true);
                if(result.success){ 
                    panel.down('#nome_local').setValue(result.nome_local);
                    panel.down('#id_local').setValue(result.id_local);
                    Ext.getCmp('modpre_mainpresenca').down('#gridPresencas').getStore().getProxy().setExtraParam('id_local', result.id_local);
                    Ext.getCmp('modpre_mainpresenca').down('#gridPresencas').getStore().load();
                }else{
                    var winMsg = Ext.Msg.show({
                        title: "ERRO",
                        msg: result.msg,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK,
                    });
                    // setTimeout(function(){ winMsg.down('button').click(); }, 2000);
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

    codEnter: function(field, e){
    	if (e.getKey() == e.ENTER) {
            var store = field.up('window').down('#gridPresencas').getStore();
            Ext.Ajax.request({
                url: 'Server/presenca/criaPresencas.php',
                params: { 
                	barcode: field.getSubmitValue(),
                	id_local: field.up('window').down('#id_local').getValue()
                },
                disableCaching: false,
                success: function(conn, response, options, eOpts){
                    var result = Ext.JSON.decode(conn.responseText, true);
                    if(result.success){ 
                    	store.load();
                    }else{
                       var alert = Ext.create('Seic.view.Presenca.Alerta');
                       alert.down('#messageWarning').setValue(result.msg);
                       alert.show();
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
			field.setValue('');
        }
    }
});
