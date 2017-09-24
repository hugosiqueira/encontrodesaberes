Ext.define('Seic.controller.CadastroInstituicoes', {
    extend: 'Ext.app.Controller',
    stores: [
		'CadastroInstituicoes.Instituicoes'
	],
    views: [
		'CadastroInstituicoes.gridInstituicoes'
	],

    init: function() {
		Ext.create('Seic.store.CadastroInstituicoes.Instituicoes');
		this.control({
			'modcadinstituicao_gridInstituicoes button#btnAdicionarInstituicao': {
                click: this.adicionarInstituicao
            },
			'modcadinstituicao_formCadInstituicao button#btnSalvarInstituicao':{
				click: this.salvarInstituicao
			},
			'modcadinstituicao_gridInstituicoes dataview': {
                itemdblclick: this.editarInstituicaoGrid
            },
			'modcadinstituicao_gridInstituicoes button#btnEditarInstituicao': {
                click: this.editarInstituicao
            },
			'modcadinstituicao_gridInstituicoes button#btnApagarInstituicao': {
                click: this.apagarInstituicao
            }
		});
    },
	adicionarInstituicao: function(button) {
		var win = Ext.create('Seic.view.CadastroInstituicoes.formCadInstituicao').show();
		win.setTitle('Nova instituição');
	},
	salvarInstituicao: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadinstituicao_gridInstituicoes');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.CadastroInstituicoes.Instituicoes',values);
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
	editarInstituicao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastroInstituicoes.formCadInstituicao').show();
			win.setTitle('Editar instituição');
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
	editarInstituicaoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastroInstituicoes.formCadInstituicao').show();
		win.setTitle('Editar instituição');
		win.down('form').loadRecord(row);
	},
	apagarInstituicao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar a instituição: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
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
