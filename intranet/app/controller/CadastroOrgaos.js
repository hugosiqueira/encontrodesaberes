Ext.define('Seic.controller.CadastroOrgaos', {
    extend: 'Ext.app.Controller',
    stores: [
		'CadastroOrgaos.Orgaos'
	],
    views: [
		'CadastroOrgaos.gridOrgaos'
	],

    init: function() {
		Ext.create('Seic.store.CadastroOrgaos.Orgaos');
		this.control({
			'modcadorgao_gridOrgaos button#btnAdicionarOrgao': {
                click: this.adicionarOrgao
            },
			'modcadorgao_formCadOrgao button#btnSalvarOrgao':{
				click: this.salvarOrgao
			},
			'modcadorgao_gridOrgaos dataview': {
                itemdblclick: this.editarOrgaosGrid
            },
			'modcadorgao_gridOrgaos button#btnEditarOrgao': {
                click: this.editarOrgaos
            },
			'modcadorgao_gridOrgaos button#btnApagarOrgao': {
                click: this.apagarOrgao
            }
		});
    },
	adicionarOrgao: function(button) {
		var win = Ext.create('Seic.view.CadastroOrgaos.formCadOrgao').show();
		win.setTitle('Novo órgão de fomento');
	},
	salvarOrgao: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadorgao_gridOrgaos');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.CadastroOrgaos.Orgaos',values);
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
	editarOrgaos: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastroOrgaos.formCadOrgao').show();
			win.setTitle('Editar órgão de fomento');
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
	editarOrgaosGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastroOrgaos.formCadOrgao').show();
		win.setTitle('Editar órgão de fomento');
		win.down('form').loadRecord(row);
	},
	apagarOrgao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o órgão: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
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
