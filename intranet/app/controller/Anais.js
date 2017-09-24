Ext.define('Seic.controller.Anais', {
    extend: 'Ext.app.Controller',
    stores: [
    	'Seic.store.Anais.Anais',
    	'Seic.store.Anais.AutoresAnais',

    ],

    models: [
    	'Seic.model.Anais.Anais',
    	'Seic.model.Anais.AutoresAnais'
    ],

    views: [
    	'Seic.view.Anais.gridAnais'
    ],

    init: function() {
		this.control({
			'modanais_formBuscaAvancada button#btnPesquisar': {
            	click: this.pesquisarAvaliacoes
            },
			'modanais_gridAnais button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modanais_gridAnais button#modanais_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
			'modanais_gridAnais dataview': {
                itemdblclick: this.editarAnaisGrid
            },
			'modanais_gridAnais button#btnAdicionarAnais': {
                click: this.adicionarAnais
            },
			'modanais_gridAnais button#btnEditarAnais': {
                click: this.editarAnais
            },
			'modanais_formAnais dataview': {
                itemdblclick: this.editarAutorGrid
            },
			'modanais_formAnais button#btnEditarAutor': {
                click: this.editarAutor
            },
			'modanais_formAnais button#btnSalvarAnais': {
				click: this.salvarAnais
            },
			'modanais_formAnais button#btnAdicionarAutor': {
                click: this.adicionarAutor
            },
			'modanais_formAutorAnais button#btnSalvarAutorAnais':{
				click: this.salvarAutorAnais
			},
			'modanais_formAnais button#btnApagarAutor': {
                click: this.apagarAutor
            },
		});
    },
	adicionarAnais: function(button) {
		var win = Ext.create('Seic.view.Anais.formAnais').show();
		win.setTitle('Adicionar trabalho');
		Ext.getCmp('modanais_comboAreaEspecifica').getStore().load();
		var gridAutores = Ext.getCmp('modanais_gridAutores');
		gridAutores.disable();
		gridAutores.getStore().getProxy().extraParams = {
			id_trabalho: 0
		};
		gridAutores.getStore().load();
	},
	apagarAutor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o autor selecionado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						var store = grid.getStore();
						store.remove(records);
						store.sync();
					}
					else { 	}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.WARNING
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um autor para remover.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarAutorAnais: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modanais_gridAutores');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.Anais.AutoresAnais',values);
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
	adicionarAutor: function(button) {
		var win = Ext.create('Seic.view.Anais.formAutorAnais').show();
		win.setTitle('Novo autor');
		Ext.getCmp('modanais_comboTipoAutor').getStore().load();
		Ext.getCmp('modanais_fgk_trabalho_anais').setValue(Ext.getCmp('modtrabalhos_id_trabalho').getValue());
	},
	salvarAnais: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		var id_anais;
		var data;
		if(form.isValid()) {
			var grid = Ext.getCmp('modanais_gridAnais');
			var store = grid.getStore();
			if (record){
				var edicao = 1;
				record.setDirty(true);
				record.set(values);
			}
			else {
				var edicao = 0;
				valuesTrabalho = form.getValues(false,false,false,true);
				var trabalho = Ext.create('Seic.model.Anais.Anais',valuesTrabalho);
				store.add(trabalho);
			}
			store.sync({
				async: false,
				success: function(response, options){
					id_trabalho = response.proxy.getReader().jsonData.id_trabalho;
					data = response.proxy.getReader().jsonData.resultado;
				}
			});
			if (edicao == 0){
				Ext.Msg.show({
					title:   'Sucesso',
					msg:   'Trabalho cadastrado com sucesso. Deseja cadastrar os autores agora?',
					icon:   Ext.MessageBox.QUESTION,
					buttons: Ext.Msg.YESNO,
					fn: function(button){
						if(button=="yes"){
							win.setTitle('Editar trabalho');
							var trabalho = Ext.create('Seic.model.Anais.Anais',data);
							form.loadRecord(trabalho);
							Ext.getCmp('modtrabalhos_id_trabalho').setValue(id_trabalho);
							var gridAutores = Ext.getCmp('modanais_gridAutores');
							gridAutores.enable();
							gridAutores.getStore().getProxy().extraParams = {
								id_trabalho: id_trabalho
							};
							gridAutores.getStore().load();
						}
						else {
							win.close();
							store.load();
						}
					}
				});
			}
			else{
				win.close();
				store.load();
			}
        }
        else{
			Ext.Msg.alert({
				title: 'Atenção',
				msg: 'Favor informar todos os campos obrigatórios.',
				buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.ERROR
			});
		}
	},
	editarAutorGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Anais.formAutorAnais').show();
		win.setTitle('Editar autor');
		Ext.getCmp('modanais_comboTipoAutor').getStore().load();
		win.down('form').loadRecord(row);
	},
	editarAnaisGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Anais.formAnais').show();
		win.setTitle('Editar trabalho');
		Ext.getCmp('modanais_comboAreaEspecifica').getStore().load();
		win.down('form').loadRecord(row);
		var gridAutores = Ext.getCmp('modanais_gridAutores');
		gridAutores.enable();
		gridAutores.getStore().getProxy().extraParams = {
			id_trabalho: row.data.id
		};
		gridAutores.getStore().load();
	},
	editarAutor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var win = Ext.create('Seic.view.Anais.formAutorAnais').show();
			win.setTitle('Editar autor');
			Ext.getCmp('modanais_comboTipoAutor').getStore().load();
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um autor para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarAnais: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Anais.formAnais').show();
			win.setTitle('Editar trabalho');
			Ext.getCmp('modanais_comboAreaEspecifica').getStore().load();
			win.down('form').loadRecord(row);
			var gridAutores = Ext.getCmp('modanais_gridAutores');
			gridAutores.enable();
			gridAutores.getStore().getProxy().extraParams = {
				id_trabalho: row.data.id
			};
			gridAutores.getStore().load();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	pesquisarAvaliacoes: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridAnais = Ext.getCmp('modanais_gridAnais');
		gridAnais.getStore().getProxy().extraParams = {
			pa				: '1',
			fgk_area_especifica	: values.fgk_area_especifica,
			bool_premiado		: values.bool_premiado
		};
		gridAnais.getStore().load();
		gridAnais.getStore().loadPage(1);
		toolbar = Ext.getCmp("modanais_toolBarPA");
		toolbar.removeAll();
		toolbar.show();
		toolbar.add(
			{	xtype: 'label',
				text: 'Listando apenas: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.fgk_area_especifica!=""){
			toolbar.add({xtype:'button',text: Ext.getCmp('modanais_comboAreaEspecifica-PA').getRawValue()});
		}
		if(values.bool_premiado!="-1"){
			if(values.bool_premiado=="0")
				toolbar.add({xtype:'button', text:"Não premiados"});
			else
				toolbar.add({xtype:'button', text:"Premiados"});
		}
		toolbar.add('->');
		toolbar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modanais_btnLimparBusca'
			}
		);
		win.hide();
	},
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modanais_toolBarPA').hide();
		Ext.getCmp('modanais_btnLimparBusca').hide();
		Ext.getCmp('modanais_formBuscaAvancada').close();
		gridAnais = Ext.getCmp('modanais_gridAnais');
		gridAnais.getStore().getProxy().extraParams = {};
		gridAnais.getStore().load();
    },
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modanais_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Anais.formBuscaAvancada');
		else
			win.show();
		Ext.getCmp('modanais_comboAreaEspecifica-PA').getStore().load();
	}
});
