Ext.define('Seic.controller.Avaliacoes', {
    extend: 'Ext.app.Controller',
    stores: [
    	'Seic.store.Avaliacoes.Avaliacoes',
    	'Seic.store.Avaliacoes.AutoresTrabalho',
    	'Seic.store.Avaliacoes.RankGeral',
    ],

    models: [
    	'Seic.model.Avaliacoes.Avaliacoes',
    	'Seic.model.Avaliacoes.AutoresTrabalho',
    	'Seic.model.Avaliacoes.RankGeral',
    ],

    views: [
    	'Seic.view.Avaliacoes.gridAvaliacoes',
    	'Seic.view.Avaliacoes.formCadAvaliacao',
    	'Seic.view.Avaliacoes.formCodBarras',
    	'Seic.view.Avaliacoes.gridRank',
    ],

    init: function() {
		this.control({
			'modaval_gridAvaliacoes button#btnRank': {
            	click: this.rank
            },
			'modaval_gridAvaliacoes button#btnCodBarras': {
            	click: this.abrirCodBarras
            },
			'modaval_gridAvaliacoes button#btnAvaliarTrabalho': {
            	click: this.avaliarTrabalho
            },
			'modaval_gridAvaliacoes button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modaval_formBuscaAvancada button#btnPesquisar': {
            	click: this.pesquisarAvaliacoes
            },
			'modaval_gridAvaliacoes button#modaval_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
			'modaval_gridAvaliacoes menuitem#itemImprimirFicha': {
				click: this.imprimirFicha
            },
			'modaval_gridAvaliacoes menuitem#itemImprimirResumo': {
				click: this.imprimirResumo
            },
			'modaval_formCadAvaliacao button#btnReprovar': {
				click: this.reprovar
            },
			'modaval_formCadAvaliacao button#btnSalvarAvaliacao': {
				click: this.salvarAvaliacao
            },
			'modaval_gridAvaliacoes dataview': {
                itemdblclick: this.avaliarTrabalhoGrid
            },
		});
    },
	reprovar: function(button) {
		win = button.up('window');
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja realmente marcar como apresentador ausente?<br>Um email será enviado para todos os autores automaticamente.',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						async: false,
						waitMsg: 'Aguarde...',
						params: {
							id_apresentacao: Ext.getCmp('modaval_id_avaliacao').getValue(),
							titulo_enviado : Ext.getCmp('modaval_tituloTrabalho').getValue(),
						},
						url: 'Server/avaliacoes/reprovar.php',
						callback: function ( options,success,response ){
							var data = Ext.decode(response.responseText);
							if( data.success ){
								Ext.getCmp('modaval_gridAvaliacoes').getStore().load();
								win.close();
							}
							else{
								form.getForm().reset();
								Ext.Msg.alert({
									title: 'Falha',
									msg: "Entre em contato com um administrador do sistema.",
									buttons: Ext.Msg.OK,
									icon:   Ext.MessageBox.WARNING
								});
							}
						}
					});
				}
				else {	}
			},
			animEl: 'elId',
			icon:   Ext.MessageBox.QUESTION
		});
    },
	salvarAvaliacao: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modaval_gridAvaliacoes');
			if(values.status!=1){
				Ext.Msg.show({
					title:   'Confirmação',
					msg:     'Deseja certificar e enviar email para o apresentador e avaliador agora?',
					width: 300,
					buttons: Ext.Msg.YESNOCANCEL,
					icon:   Ext.MessageBox.QUESTION,
					fn: function(button){
						if(button=="yes"){
							form.submit({
								params: {certificadoemail:  1	},
								url: 'Server/avaliacoes/salvarAvaliacao.php',
								waitMsg: 'Gravando notas...',
								success: function (form,action) {
									var data= Ext.decode(action.response.responseText);
									if(data.success){
										win.close();
										grid.getStore().load();
										Ext.Msg.show({
											title:'Sucesso',
											msg: 'Notas gravadas com sucesso.',
											buttons: Ext.Msg.OK
										});
									}
								},
								failure: function (form, action) {
									var data = Ext.decode(action.response.responseText);
									console.log('D:');
								}
							});
						}
						else if(button=="no"){
							form.submit({
								params: {certificadoemail:  0	},
								url: 'Server/avaliacoes/salvarAvaliacao.php',
								waitMsg: 'Gravando notas...',
								success: function (form,action) {
									var data= Ext.decode(action.response.responseText);
									if(data.success){
										win.close();
										grid.getStore().load();
										Ext.Msg.show({
											title:'Sucesso',
											msg: 'Notas gravadas com sucesso.',
											buttons: Ext.Msg.OK
										});
									}
								},
								failure: function (form, action) {
									var data = Ext.decode(action.response.responseText);
									console.log('D:');
								}
							});
						}
					}
				});
			}
			else{
				form.submit({
					params: {certificadoemail:  0	},
					url: 'Server/avaliacoes/salvarAvaliacao.php',
					waitMsg: 'Gravando notas...',
					success: function (form,action) {
						var data= Ext.decode(action.response.responseText);
						if(data.success){
							win.close();
							grid.getStore().load();
							Ext.Msg.show({
								title:'Sucesso',
								msg: 'Notas gravadas com sucesso.',
								buttons: Ext.Msg.OK
							});
						}
					},
					failure: function (form, action) {
						var data = Ext.decode(action.response.responseText);
						console.log('D:');
					}
				});
			}
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor conferir todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	buscarCodBarras: function(text){
		form = text.up('form');
		cod_barras = text.getValue();
		if(form.isValid()) {
			Ext.Ajax.request({
				async: false,
				waitMsg: 'Aguarde...',
				params: {
					cod_barras: cod_barras
				},
				url: 'Server/avaliacoes/buscarCodBarras.php',
				callback: function ( options,success,response ){
					var data = Ext.decode(response.responseText);
					if( data.success ){
						form.up('window').close();
						win = Ext.create('Seic.view.Avaliacoes.formCadAvaliacao').show();
						Ext.getCmp('modaval_comboRevisor').getStore().load();
						win.setTitle('Avaliar trabalho');
						form = win.down('form');
						form.getForm().findField('id').setValue(data.id_apresentacao);
						form.getForm().findField('status').setValue(data.status);
						form.getForm().findField('fgk_revisor').setValue(data.nome_avaliador);
						form.getForm().findField('titulo_enviado').setValue(data.titulo_enviado);
						form.getForm().findField('descricao_area').setValue(data.descricao_area);
						form.getForm().findField('cod_poster').setValue(data.cod_poster);
						form.getForm().findField('nome_sessao').setValue(data.nome_sessao);
						form.getForm().findField('nota_a').setValue(data.nota_a);
						form.getForm().findField('nota_b').setValue(data.nota_b);
						form.getForm().findField('nota_c').setValue(data.nota_c);
						form.getForm().findField('nota_d').setValue(data.nota_d);
						form.getForm().findField('nota_e').setValue(data.nota_e);

						gridAutores = Ext.getCmp('modaval_gridAutores');
						gridAutores.enable();
						gridAutores.getStore().getProxy().extraParams = {
							id_trabalho: data.fgk_trabalho
						};
						gridAutores.getStore().load();

						Ext.getCmp('modaval_notaA').focus();
					}
					else{
						form.getForm().reset();
						Ext.Msg.alert({
							title: 'Falha',
							msg: "Código de barras não encontrado.",
							buttons: Ext.Msg.OK,
							icon:   Ext.MessageBox.WARNING
						});
					}
				}
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
	rank: function(button) {
		var win = new Ext.window.Window({
			title : 'Classificação',
			layout: 'fit',
			autoShow: true,
			width: 850,
			height: 720,
			modal: true,
			items: [
				{	xtype: 'modaval_gridRank'	}
			],
			fbar: [
				'->',
				{	iconCls: 'icon-cancel',
					text: 'Fechar',
					scope: this,
					handler: function(button){
						button.up('window').close();
					}
				}
			],
			listeners: {
				render: function(){
					Ext.getCmp('modaval_gridRank').getStore().load();
				}
			}
		});
		return win;

	},
	abrirCodBarras: function(button) {
		var win = Ext.create('Seic.view.Avaliacoes.formCodBarras').show();
		Ext.getCmp('modaval_codBarras').focus();
    },
	avaliarTrabalhoGrid: function(grid, row) {
		var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Avaliacoes.formCadAvaliacao').show();
			win.setTitle('Avaliar trabalho');
			Ext.getCmp('modaval_comboRevisor').getStore().load();

			win.down('form').loadRecord(row);
			var gridAutores = Ext.getCmp('modaval_gridAutores');
			gridAutores.enable();
			gridAutores.getStore().getProxy().extraParams = {
				id_trabalho: row.data.fgk_trabalho
			};
			gridAutores.getStore().load();
			Ext.getCmp('modaval_notaA').focus();
	},
	avaliarTrabalho: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Avaliacoes.formCadAvaliacao').show();
			win.setTitle('Avaliar trabalho');
			Ext.getCmp('modaval_comboRevisor').getStore().load();

			win.down('form').loadRecord(row);
			var gridAutores = Ext.getCmp('modaval_gridAutores');
			gridAutores.enable();
			gridAutores.getStore().getProxy().extraParams = {
				id_trabalho: row.data.fgk_trabalho
			};
			gridAutores.getStore().load();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para avaliar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
    },
	imprimirResumo: function(button) {
		grid = button.up('grid');
		store = grid.getStore();
		if(store.filters.items.length)
			buscaR = store.filters.items[0].value;
		else
			buscaR = "";
		// console.log(store.proxy.extraParams);
		Ext.Msg.show({
			title:   'Confirmação',
			msg:     'Deseja imprimir o resumo dos trabalhos listados?',
			width: 300,
			buttons: Ext.Msg.YESNO,
			icon:   Ext.MessageBox.QUESTION,
			fn: function(button){
				if(button=="yes"){
					Ext.create('Ext.window.Window', {
						title: 'Resumos',
						height: 750,
						width: 750,
						layout: 'fit',
						modal: true,
						constrain: true,
						html: "<iframe src='Server/avaliacoes/imprimirResumo.php?buscaRapida="+buscaR+"&pa="+store.proxy.extraParams.pa+"&fgk_area="+store.proxy.extraParams.fgk_area+"&fgk_revisor="+store.proxy.extraParams.fgk_revisor+"&fgk_sessao="+store.proxy.extraParams.fgk_sessao+"&status="+store.proxy.extraParams.status+"' width='100%' height='100%' frameborder=0></iframe>"
					}).show();
				}
			}
		});

	},
	imprimirFicha: function(button) {
		grid = button.up('grid');
		store = grid.getStore();
		if(store.filters.items.length)
			buscaR = store.filters.items[0].value;
		else
			buscaR = "";
		// console.log(store.proxy.extraParams);
		Ext.Msg.show({
			title:   'Confirmação',
			msg:     'Deseja imprimir a ficha de avaliação dos trabalhos listados?',
			width: 300,
			buttons: Ext.Msg.YESNO,
			icon:   Ext.MessageBox.QUESTION,
			fn: function(button){
				if(button=="yes"){
					Ext.create('Ext.window.Window', {
						title: 'Ficha de avaliação',
						height: 650,
						width: 900,
						layout: 'fit',
						modal: true,
						constrain: true,
						html: "<iframe src='Server/avaliacoes/imprimirFicha.php?buscaRapida="+buscaR+"&pa="+store.proxy.extraParams.pa+"&fgk_area="+store.proxy.extraParams.fgk_area+"&fgk_revisor="+store.proxy.extraParams.fgk_revisor+"&fgk_sessao="+store.proxy.extraParams.fgk_sessao+"&status="+store.proxy.extraParams.status+"' width='100%' height='100%' frameborder=0></iframe>"
					}).show();
				}
			}
		});

	},
	pesquisarAvaliacoes: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridAvaliacoes = Ext.getCmp('modaval_gridAvaliacoes');
		gridAvaliacoes.getStore().getProxy().extraParams = {
			pa				: '1',
			fgk_area		: values.fgk_area,
			fgk_revisor		: values.fgk_revisor,
			fgk_sessao		: values.fgk_sessao,
			status			: values.status
		};
		gridAvaliacoes.getStore().load();
		gridAvaliacoes.getStore().loadPage(1);
		toolbar = Ext.getCmp("modaval_toolBarPA");
		toolbar.removeAll();
		toolbar.show();
		toolbar.add(
			{	xtype: 'label',
				text: 'Listando apenas: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);

		if(values.fgk_area!=""){
			toolbar.add({xtype:'button',text: Ext.getCmp('modaval_comboArea-PA').getRawValue()});
		}
		if(values.fgk_revisor!=""){
			toolbar.add({xtype:'button', text: Ext.getCmp('modaval_comboRevisor-PA').getRawValue()});
		}
		if(values.fgk_sessao!=""){
			toolbar.add({xtype:'button',text: Ext.getCmp('modaval_comboSessao-PA').getRawValue()});
		}
		if(values.status=="0"){
			toolbar.add({xtype:'button', text: "Não avaliados"});
		}
		if(values.status=="1"){
			toolbar.add({xtype:'button', text: "Avaliados"});
		}
		if(values.status=="2"){
			toolbar.add({xtype:'button', text: "Apresentador ausente"});
		}
		toolbar.add('->');
		toolbar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modaval_btnLimparBusca'
			}
		);
		win.hide();
	},
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modaval_toolBarPA').hide();
		Ext.getCmp('modaval_btnLimparBusca').hide();
		Ext.getCmp('modaval_formBuscaAvancada').close();
		gridAvaliacoes = Ext.getCmp('modaval_gridAvaliacoes');
		// gridAvaliacoes.getStore().clearFilter();
		gridAvaliacoes.getStore().getProxy().extraParams = {};
		gridAvaliacoes.getStore().load();

    },
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modaval_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Avaliacoes.formBuscaAvancada');
		else
			win.show();

		Ext.getCmp('modaval_comboArea-PA').getStore().load();
		Ext.getCmp('modaval_comboSessao-PA').getStore().load();
		Ext.getCmp('modaval_comboRevisor-PA').getStore().load();
	},
});
