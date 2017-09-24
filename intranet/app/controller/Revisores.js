Ext.define('Seic.controller.Revisores', {
    extend: 'Ext.app.Controller',
    stores: [
		'Revisores.Revisores',
		'Revisores.Area',
		'Revisores.BuscarRevisores',
		'Revisores.SessoesRevisores',
		'Revisores.TrabalhosAvaliacaoRevisores',
		'Revisores.TipoInscrito',
		'Revisores.TrabalhosRevisores',
	],
    views: [
		'Revisores.gridRevisores',
		'Revisores.gridBuscarRevisor'
	],

    init: function() {
		Ext.create('Seic.store.Revisores.Revisores');
		Ext.create('Seic.store.Revisores.Area');
		Ext.create('Seic.store.Revisores.TrabalhosRevisores');
		Ext.create('Seic.store.Revisores.SessoesRevisores');
		Ext.create('Seic.store.Revisores.BuscarRevisores');
		Ext.create('Seic.store.Revisores.TrabalhosAvaliacaoRevisores');
		Ext.create('Seic.store.Revisores.TipoInscrito');
		this.control({
			'modrevisores_gridRevisores menuitem#itemMensagemEmail': {
				click: this.mensagemEmail
            },
			'modrevisores_gridRevisores button#btnAdicionarRevisor': {
                click: this.adicionarRevisor
            },
			'modrevisores_gridRevisores button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modrevisores_formCadRevisor textfield#modrevisores_cpfRevisor':{
				validitychange: this.buscaCpfRevisor
			},
			'modrevisores_formCadRevisor button#btnBuscarRevisor':{
				click: this.buscarRevisor
			},
			'modrevisores_formCadRevisor button#btnSalvarRevisor':{
				click: this.salvarRevisor
			},
			'modrevisores_gridBuscarRevisor button#btnSelecionarRevisor': {
                click: this.selecionarRevisor
            },
			'modrevisores_gridRevisores dataview': {
                itemdblclick: this.editarRevisorGrid
            },
			'modrevisores_gridBuscarRevisor dataview': {
                itemdblclick: this.selecionarRevisorGrid
            },
			'modrevisores_gridRevisores button#btnEditarRevisor': {
                click: this.editarRevisor
            },
			'modrevisores_gridRevisores button#btnApagarRevisor': {
                click: this.apagarRevisor
            },
			'modrevisores_formBuscaAvancada button#btnBuscaAvancada': {
                click: this.pesquisarRevisores
            },
			'modrevisores_gridRevisores button#modrevisores_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
			'modrevisores_formMensagemEmail button#btnEnviarEmail': {
				click: this.enviarEmail
            },
		});
    },
	mensagemEmail: function(button) {
		var win = Ext.create('Seic.view.Revisores.formMensagemEmail').show();
		grid = Ext.getCmp('modrevisores_gridRevisores');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modrevisores_id_revisor_email').setValue(grid.getSelectionModel().getSelection()[0].data.id);
		}
		else{
			Ext.getCmp('modrevisores_radioRevisorSelecionado').disable();
			Ext.getCmp('modrevisores_id_revisor_email').setValue(0);
		}
	},
	enviarEmail: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, contabilizando emails...',
			    target: win
			});
			myMask.show();
			grid = Ext.getCmp('modrevisores_gridRevisores');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			
			Ext.Ajax.request({
				url: 'Server/revisores/checaremails.php', 
				params: {
						buscaRapida				: buscaR,
						id_revisor				: Ext.getCmp('modrevisores_id_revisor_email').getValue(),
						radio					: form.getForm().findField('revisor').getValue(),
						pa						: store.proxy.extraParams.pa,
						nome					: store.proxy.extraParams.nome,
						fgk_tipo				: store.proxy.extraParams.fgk_tipo,
						fgk_area				: store.proxy.extraParams.fgk_area,
						fgk_area_especifica		: store.proxy.extraParams.fgk_area_especifica,
						bool_avaliador_prograd	: store.proxy.extraParams.bool_avaliador_prograd,
						bool_avaliador_proex	: store.proxy.extraParams.bool_avaliador_proex,
						bool_avaliador_caint	: store.proxy.extraParams.bool_avaliador_caint,
						com_trabalho			: store.proxy.extraParams.com_trabalho,
						pendentes				: store.proxy.extraParams.pendentes
				},
				success: function(conn, response, options, eOpts){
					myMask.hide();
					var result = Ext.JSON.decode(conn.responseText, true);
					Ext.Msg.show({
						title:   'Confirmação',
						msg:     'Deseja enviar este email para os destinatários escolhidos?<br><i>'+result.total+' emails serão enviados.</i>',
						buttons: Ext.Msg.YESNO,
						fn: function(button){
							if(button=="yes"){
								form.submit({
									url: 'Server/revisores/enviarEmail.php',
									params : {
										buscaRapida				: buscaR,
										id_revisor				: Ext.getCmp('modrevisores_id_revisor_email').getValue(),
										radio					: form.getForm().findField('revisor').getValue(),
										pa						: store.proxy.extraParams.pa,
										nome					: store.proxy.extraParams.nome,
										fgk_tipo				: store.proxy.extraParams.fgk_tipo,
										fgk_area				: store.proxy.extraParams.fgk_area,
										fgk_area_especifica		: store.proxy.extraParams.fgk_area_especifica,
										bool_avaliador_prograd	: store.proxy.extraParams.bool_avaliador_prograd,
										bool_avaliador_proex	: store.proxy.extraParams.bool_avaliador_proex,
										bool_avaliador_caint	: store.proxy.extraParams.bool_avaliador_caint,
										com_trabalho			: store.proxy.extraParams.com_trabalho,
										pendentes				: store.proxy.extraParams.pendentes
									},
									waitMsg: 'Enviando email(s)...',
									success: function (form,action) {
										var data= Ext.decode(action.response.responseText);
										if(data.success){
											win.close();
											Ext.Msg.show({
												title:'Sucesso',
												msg: 'Emails enviados com sucesso.',
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
							else { 	}
						},
						animEl: 'elId',
						icon:   Ext.MessageBox.WARNING
					});
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
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
	pesquisarRevisores: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridRevisores = Ext.getCmp('modrevisores_gridRevisores');
		gridRevisores.getStore().getProxy().extraParams = {
			pa						: '1',
			nome					: values.nome,
			fgk_tipo				: values.fgk_tipo,
			fgk_area				: values.fgk_area,
			fgk_area_especifica		: values.fgk_area_especifica,
			bool_avaliador_prograd	: values.bool_avaliador_prograd,
			bool_avaliador_proex	: values.bool_avaliador_proex,
			bool_avaliador_caint	: values.bool_avaliador_caint,
			com_trabalho			: values.com_trabalho,
			pendentes				: values.pendentes
		};
		gridRevisores.getStore().loadPage(1);

		var toolbar = Ext.getCmp('modrevisores_toolbarPA');
		toolbar.removeAll();
		toolbar.show();
		toolbar.add(
			{	xtype: 'label',
				text: 'Filtros aplicados: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.com_trabalho=="1"){
			texto = "Com trabalhos vinculados";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.com_trabalho=="0"){
			texto = "Sem trabalhos vinculados";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.pendentes=="2"){
			texto = "Sem avaliação pendente";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.pendentes=="1"){
			texto = "Com avaliação pendente";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.bool_avaliador_prograd=="1"){
			texto = "Avaliador PROGRAD";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.bool_avaliador_proex=="1"){
			texto = "Avaliador PROEX";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.bool_avaliador_caint=="1"){
			texto = "Avaliador CAINT";
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.nome!=""){
			texto = "Nome: "+values.nome;
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.fgk_tipo!=""){
			texto = "Tipo: "+Ext.getCmp('modrevisores_comboTipo-PA').getRawValue();
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.fgk_area!=""){
			texto = "Área: "+Ext.getCmp('modrevisores_comboArea-PA').getRawValue();
			toolbar.add({xtype:'button',text: texto});
		}
		if(values.fgk_area_especifica!=""){
			texto = "Área específica: "+Ext.getCmp('modrevisores_comboAreaEspecifica-PA').getRawValue();
			toolbar.add({xtype:'button',text: texto});
		}
		toolbar.add('->');
		toolbar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modrevisores_btnLimparBusca'
			}
		);
		win.hide();
	},
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modrevisores_toolbarPA').hide();
		Ext.getCmp('modrevisores_btnLimparBusca').hide();
		Ext.getCmp('modrevisores_formBuscaAvancada').close();
		var gridRevisores = Ext.getCmp('modrevisores_gridRevisores');
		gridRevisores.getStore().getProxy().extraParams = {};
		gridRevisores.getStore().load();
    },
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modrevisores_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Revisores.formBuscaAvancada');
		else
			win.show();
		Ext.getCmp('modrevisores_comboTipo-PA').getStore().load();
		Ext.getCmp('modrevisores_comboArea-PA').getStore().load();
	},
	selecionarRevisorGrid: function(grid, row){
		Ext.getCmp('modrevisores_cpfRevisor').setValue(row.data.cpf);
		Ext.getCmp('modrevisores_gridBuscarRevisor').up('window').close();
	},
	buscarRevisor: function(){
		var win = new Ext.window.Window({
			title: 'Buscar revisor',
			layout: 'fit',
			autoShow: true,
			width: 600,
			height: 580,
			modal: true,
			items: [
				{	xtype: 'modrevisores_gridBuscarRevisor'	}
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
			]
		});
		return win;
	},
	buscaCpfRevisor: function(cpffield, isValid){
		if(isValid){
			// Ext.getCmp('modrevisores_comboArea').getStore().load();
			form = Ext.getCmp('modrevisores_formCadRevisor').down('form');
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, buscando cpf...',
			    target: Ext.getCmp('modrevisores_camposRevisor')
			});
			myMask.show();
    		Ext.Ajax.request({
			    url: 'Server/revisores/buscaCpfRevisor.php',
			    params: {
			        cpf: cpffield.getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();
			        if(result.success){
						Ext.getCmp('modrevisores_comboArea').getStore().load();

						form.getForm().findField('tipo_revisor').setValue(result.tipo_revisor);
						form.getForm().findField('nome').setValue(result.nome);
						form.getForm().findField('rend_departamento').setValue(result.rend_departamento);
						form.getForm().findField('email').setValue(result.email);
						form.getForm().findField('id').setValue(result.id_revisor);
						if(result.tipo_revisor=="-1"){
							comboAreaEspecifica = Ext.getCmp('modrevisores_comboAreaEspecifica');
							comboAreaEspecifica.getStore().getProxy().extraParams = {
								id_area	: parseInt(result.fgk_area)
							};
							comboAreaEspecifica.getStore().load();
							form.getForm().findField('fgk_area').setValue(parseInt(result.fgk_area));
							form.getForm().findField('fgk_area_especifica').setValue(parseInt(result.fgk_area_especifica));
							form.getForm().findField('bool_avaliador_prograd').setValue(result.bool_avaliador_prograd);
							form.getForm().findField('bool_avaliador_proex').setValue(result.bool_avaliador_proex);
							form.getForm().findField('bool_avaliador_caint').setValue(result.bool_avaliador_caint);
						}
						Ext.getCmp('modrevisores_camposRevisor').enable();

			        }
					else{
						Ext.Msg.show({
							title:'Atenção',
							msg: 'Nenhuma pessoa foi encontrada para o CPF: <b>'+cpffield.getValue()+'</b>',
							icon: Ext.Msg.WARNING,
							buttons: Ext.Msg.OK,
							fn: function(button){
								form.getForm().reset();
								Ext.getCmp('modrevisores_camposRevisor').disable();
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
	adicionarRevisor: function(button) {
		var win = Ext.create('Seic.view.Revisores.formCadRevisor').show();

		win.setTitle('Novo revisor');
	},
	salvarRevisor: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modrevisores_gridRevisores');
			var store = grid.getStore();
			if (form.getForm().findField('id').getValue() > 0){
				form.submit({
					url: 'Server/revisores/atualizarRevisores.php',
					waitMsg: 'Salvando revisor...',
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
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.Revisores.Revisores',values);
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
							if(win)
								win.close();
						}
					});
				},
				failure: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Atenção',
						msg:  data.msg,
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
	selecionarRevisor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.getCmp('modrevisores_cpfRevisor').setValue(row.data.cpf);
			Ext.getCmp('modrevisores_gridBuscarRevisor').up('window').close();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um revisor.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarRevisor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Revisores.formCadRevisor').show();
			win.setTitle('Editar revisor');
			Ext.getCmp('modrevisores_comboArea').getStore().load();
			comboAreaEspecifica = Ext.getCmp('modrevisores_comboAreaEspecifica');
			comboAreaEspecifica.getStore().getProxy().extraParams = {
				id_area	: row.data.fgk_area
			};
			comboAreaEspecifica.getStore().load();
			Ext.getCmp('modrevisores_cpfRevisor').setReadOnly(true);
			Ext.getCmp('modrevisores_btnLupa').disable();
			win.down('form').loadRecord(row);
			Ext.getCmp('modrevisores_gridTrabalhosRevisores').enable();
			Ext.getCmp('modrevisores_gridTrabalhosAvaliacaoRevisores').enable();
			Ext.getCmp('modrevisores_gridSessoesRevisores').enable();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarRevisorGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Revisores.formCadRevisor').show();
		win.setTitle('Editar revisores');
		Ext.getCmp('modrevisores_comboArea').getStore().load();
		comboAreaEspecifica = Ext.getCmp('modrevisores_comboAreaEspecifica');
		comboAreaEspecifica.getStore().getProxy().extraParams = {
			id_area	: row.data.fgk_area
		};
		comboAreaEspecifica.getStore().load();
		Ext.getCmp('modrevisores_cpfRevisor').setReadOnly(true);
		Ext.getCmp('modrevisores_btnLupa').disable();
		win.down('form').loadRecord(row);
		Ext.getCmp('modrevisores_gridTrabalhosRevisores').enable();
		Ext.getCmp('modrevisores_gridTrabalhosAvaliacaoRevisores').enable();
		Ext.getCmp('modrevisores_gridSessoesRevisores').enable();
	},
	apagarRevisor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o revisor: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
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
