Ext.define('Seic.controller.CadastroIC', {
    extend: 'Ext.app.Controller',
    stores: [
		'CadastroIC.IC'
	],
    views: [
		'CadastroIC.gridIC'
	],

    init: function() {
		Ext.create('Seic.store.CadastroIC.IC');
		this.control({
			'modcadic_gridIC button#btnAdicionarIC': {
                click: this.adicionarIC
            },
			'modcadic_formCadIC button#btnSalvarIC':{
				click: this.salvarIC
			},
			'modcadic_gridIC dataview': {
                itemdblclick: this.editarICGrid
            },
			'modcadic_gridIC button#btnEditarIC': {
                click: this.editarIC
            },
			'modcadic_gridIC button#btnApagarIC': {
                click: this.apagarIC
            }
		});
    },
	adicionarIC: function(button) {
		var win = Ext.create('Seic.view.CadastroIC.formCadIC').show();
		win.setTitle('Novo programa de iniciação científica');
	},
	salvarIC: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadic_gridIC');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.CadastroIC.IC',values);
				store.add(novoRegistro);
			}
			store.sync({
				async: false,
				success: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Sucesso',
						msg: data.msg,
						buttons: Ext.Msg.OK,
						fn: function(button){
							win.close();
						}
					});
				},
				failure: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Erro',
						msg: "Entre em contato com o administrador do sistema. ERRO_01CON",
						icon: Ext.Msg.WARNING,
						buttons: Ext.Msg.OK
					});
				}
			});
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarIC: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastroIC.formCadIC').show();
			win.setTitle('Editar programa de iniciação científica');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarICGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastroIC.formCadIC').show();
		win.setTitle('Editar programa de iniciação científica');
		win.down('form').loadRecord(row);
	},
	apagarIC: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o programa: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						var store = grid.getStore();
						store.remove(row);
						store.sync();
					}
					else {	}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.QUESTION
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    }
});
