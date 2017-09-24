Ext.define('Seic.controller.MiniProp', {
    extend: 'Ext.app.Controller',
    stores: [
		'MiniProp.MiniCursosPropostos',
		'MiniProp.MiniCursosAprovados',
		'MiniProp.MiniCursosInscritos',
		'MiniProp.Servicos',
	],
    views: [
		'MiniProp.gridMiniCursosPropostos',
		'MiniProp.gridMiniCursosAprovados',
		'MiniProp.gridMiniCursosInscritos',
		'MiniProp.tabPrincipal',
		'MiniProp.formCadMiniCursosPropostos',
		'MiniProp.formCadMiniCursosAprovados',
		'MiniProp.formStatus',
	],

    init: function() {
		Ext.create('Seic.store.MiniProp.MiniCursosPropostos');
		Ext.create('Seic.store.MiniProp.MiniCursosAprovados');
		Ext.create('Seic.store.MiniProp.MiniCursosInscritos');
		Ext.create('Seic.store.MiniProp.Servicos');
		this.control({
			'modminiprop_formCadMiniCursosInscritos button#btnSalvarMiniCursoInscrito': {
                click: this.salvarMiniCursoInscrito
            },
			'modminiprop_formCadMiniCursosAprovados button#btnSalvarMiniCursoAprovado': {
                click: this.salvarMiniCursoAprovado
            },
			'modminiprop_gridMiniCursosPropostos button#btnAlterarStatus': {
                click: this.alterarStatus
            },
			'modminiprop_gridMiniCursosPropostos button#btnAprovar': {
                click: this.aprovar
            },
			'modminiprop_gridMiniCursosPropostos button#btnReprovar': {
                click: this.reprovar
            },
			'modminiprop_gridMiniCursosInscritos button#btnImprimirLista': {
                click: this.imprimirLista
            },
			'modminiprop_gridMiniCursosInscritos button#modminiprop_btnAdicionarInscrito': {
                click: this.adicionarInscrito
            },
			'modminiprop_gridMiniCursosAprovados button#btnVisualizarMiniCursoAprovado': {
                click: this.visualizarMiniCursoAprovado
            },
			'modminiprop_gridMiniCursosPropostos button#btnVisualizarMiniProp': {
                click: this.visualizarMiniProp
            },
			'modminiprop_formStatus button#btnSalvarStatus': {
                click: this.salvarStatus
            },
			'modminiprop_gridMiniCursosPropostos dataview': {
                itemdblclick: this.visualizarMiniPropGrid
            },
			'modminiprop_gridMiniCursosAprovados dataview': {
                itemdblclick: this.visualizarMiniCursoAprovadoGrid
            },
			'modminiprop_formCadMiniCursosInscritos textfield#modminiprop_cpfInscrito':{
				validitychange: this.buscaCpfInscrito
			},
		});
    },
	imprimirLista: function(button) {
		var id_minicurso = Ext.getCmp('modminiprop_comboMiniCurso').getValue();
		if(id_minicurso > 0){
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja imprimir a lista de presença?',
				width: 300,
				buttons: Ext.Msg.YESNO,
				icon:   Ext.MessageBox.QUESTION,
				fn: function(button){
					if(button=="yes"){
						Ext.create('Ext.window.Window', {
							title: 'Lista de presença',
							height: 750,
							width: 750,
							layout: 'fit',
							modal: true,
							constrain: true,
							html: '<iframe src="Server/miniprop/imprimirLista.php?id='+id_minicurso+'" width="100%" height="100%" frameborder=0></iframe>'
						}).show();
					}
				}
			});
		}
		else{
			Ext.Msg.alert({
				title: 'Atenção',
				msg: 'Selecione um minicurso para imprimir a lista de presença.',
				buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
	buscaCpfInscrito: function(cpffield, isValid){
		if(isValid){
			form = Ext.getCmp('modminiprop_formCadMiniCursosInscritos').down('form');
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, buscando cpf...',
			    target: Ext.getCmp('modminiprop_camposInscrito')
			});
			myMask.show();
    		Ext.Ajax.request({
			    url: 'Server/miniprop/buscaCpfInscrito.php',
			    params: {
			        cpf: cpffield.getValue(),
					id_minicurso: Ext.getCmp('modminiprop_comboMiniCurso').getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();
			        if(result.success){
						form.getForm().findField('nome').setValue(result.nome);
						form.getForm().findField('email').setValue(result.email);
						form.getForm().findField('rend_departamento').setValue(result.rend_departamento);
						form.getForm().findField('id').setValue(result.id_inscrito);
						Ext.getCmp('modminiprop_camposInscrito').enable();
			        }
					else{
						Ext.Msg.show({
							title:'Falha',
							msg: result.msg,
							icon: Ext.Msg.WARNING,
							buttons: Ext.Msg.OK,
							fn: function(button){
								form.getForm().reset();
								Ext.getCmp('modminiprop_camposInscrito').disable();
							}
						});
			        }
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
    	}
    },
	salvarMiniCursoAprovado: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()){
			var grid = Ext.getCmp('modminiprop_gridMiniCursosAprovados');
			var store = grid.getStore();
			record.set(values);
			store.sync({
				async: false,
				success: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Sucesso',
						msg: "Minicurso alterado com sucesso.",
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
	salvarMiniCursoInscrito: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modminiprop_gridMiniCursosInscritos');
			var store = grid.getStore();
			Ext.getCmp('modminiprop_idMinicurso').setValue(Ext.getCmp('modminiprop_comboMiniCurso').getValue());
			form.submit({
				url: 'Server/miniprop/criarMiniCursoInscrito.php',
				waitMsg: 'Salvando inscrito...',
				success: function (form,action) {
					var data= Ext.decode(action.response.responseText);
					if(data.success){
						Ext.Msg.alert({
							title: 'Sucesso',
							msg: data.msg,
							buttons: Ext.Msg.OK,
							fn: function(button){
								win.close();
								grid.getSelectionModel().deselectAll();
								store.load();
							}
						});
					}
				},
				failure: function (form, action) {
					var data = Ext.decode(action.response.responseText);
					Ext.Msg.alert({
						title: 'Falha',
						msg: data.msg,
						buttons: Ext.Msg.OK,
						icon:   Ext.MessageBox.ERROR
					});
				}
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	salvarStatus: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modminiprop_gridMiniCursosPropostos');
			var store = grid.getStore();
			form.submit({
				url: 'Server/miniprop/atualizarStatus.php',
				waitMsg: 'Atualizando status...',
				success: function (form,action) {
					var data= Ext.decode(action.response.responseText);
					if(data.success){
						Ext.Msg.alert({
							title: 'Sucesso',
							msg: data.msg,
							buttons: Ext.Msg.OK,
							fn: function(button){
								win.close();
								grid.getSelectionModel().deselectAll();
								store.load();
							}
						});
					}
				},
				failure: function (form, action) {
					var data = Ext.decode(action.response.responseText);
					Ext.Msg.alert({
						title: 'Falha',
						msg: data.msg,
						buttons: Ext.Msg.OK,
						icon:   Ext.MessageBox.ERROR
					});
				}
			});
		}
	},
	adicionarInscrito: function(grid, row) {
		var win = Ext.create('Seic.view.MiniProp.formCadMiniCursosInscritos').show();
		win.setTitle('Adicionar inscrito');
	},
	visualizarMiniCursoAprovadoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.MiniProp.formCadMiniCursosAprovados').show();
		win.setTitle('Visualizar minicuso');
		win.down('form').loadRecord(row);
	},
	visualizarMiniPropGrid: function(grid, row) {
		var win = Ext.create('Seic.view.MiniProp.formCadMiniCursosPropostos').show();
		win.setTitle('Visualizar proposta');
		win.down('form').loadRecord(row);
	},
	aprovar: function(button){
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente aprovar o minicurso selecionado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/miniprop/aprovarMinicurso.php',
							params: {	id: records.data.id_minicurso_prop, responsavel: records.data.nome	},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso', Ext.JSON.decode(res.responseText).msg);
									store.load();
								}
								else{
									Ext.Msg.alert('Falha', Ext.JSON.decode(res.responseText).msg);
								}
							}
						});
					}
					else {	}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.WARNING
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um minicurso para aprovar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	reprovar: function(button){
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente reprovar o minicurso selecionado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/miniprop/reprovarMinicurso.php',
							params: {	id: records.data.id_minicurso_prop	},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso', Ext.JSON.decode(res.responseText).msg);
									store.load();
								}
								else{
									Ext.Msg.alert('Falha', Ext.JSON.decode(res.responseText).msg);
								}
							}
						});
					}
					else {	}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.WARNING
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um minicurso para reprovar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	alterarStatus: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.MiniProp.formStatus').show();
			win.setTitle('Visualizar proposta');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para visualizar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
	visualizarMiniCursoAprovado: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.MiniProp.formCadMiniCursosAprovados').show();
			win.setTitle('Visualizar minicurso');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para visualizar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
    },
	visualizarMiniProp: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.MiniProp.formCadMiniCursosPropostos').show();
			win.setTitle('Visualizar proposta');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para visualizar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
    },

});
