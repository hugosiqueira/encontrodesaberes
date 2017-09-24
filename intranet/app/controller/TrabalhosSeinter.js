Ext.define('Seic.controller.TrabalhosSeinter', {
    extend: 'Ext.app.Controller',
    stores: [
		'TrabalhosSeinter.TrabalhosSeinter',
		'TrabalhosSeinter.Status'
	],
    views: [
		'TrabalhosSeinter.gridTrabalhosSeinter'
	],

    init: function() {
		// console.log('Controller TrabalhosSeinter carregado');
		Ext.create('Seic.store.TrabalhosSeinter.Status');
		Ext.create('Seic.store.TrabalhosSeinter.TrabalhosSeinter');
		this.control({
			'modtrabalhosseinter_gridtrabalhosseinter dataview': {
                itemdblclick: this.editarTrabalhoSeinterGrid
            },			
			'modtrabalhosseinter_gridtrabalhosseinter menuitem#itemMensagemEmail': {
				click: this.mensagemEmail
            },
			'modtrabalhosseinter_gridtrabalhosseinter button#btnAdicionarTrabalho': {
            	click : this.adicionarTrabalhoSeinter
            },
			'modtrabalhosseinter_gridtrabalhosseinter button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modtrabalhosseinter_gridtrabalhosseinter button#btnEditarTrabalho': {
            	click : this.editarTrabalhoSeinter
            },
			'modtrabalhosseinter_gridtrabalhosseinter button#btnApagarTrabalho': {
            	click : this.apagarTrabalhoSeinter
            },
			'modtrabalhosseinter_formcadtrabalhosseinter button#btnSalvarTrabalhoSeinter': {
            	click : this.salvarTrabalhosSeinter
            },
			'modtrabalhosseinter_formbuscaavancada button#btnBuscaAvancada': {
                click: this.pesquisarTrabalhosSeinter
            },
			'modtrabalhosseinter_gridtrabalhosseinter button#modtrabalhosseinter_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
			'modtrabalhesseinter_formMensagemEmail button#btnEnviarEmail': {
				click: this.enviarEmail
            },

			'modtrabalhosseinter_gridtrabalhosseinter button#btnExport':{
				click: this.exportarExcel
			},
		});
    },

    exportarExcel: function(button){
        var store = button.up('window').down('#modtrabalhosseinter_gridtrabalhosSeinter').getStore();

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
                    window.open("Server/trabalhosseinter/exportarExcel.php?filtro="+buscaRapida
                        +"&cpf="+store.proxy.extraParams.cpf
                        +"&nome_aluno="+store.proxy.extraParams.nome_aluno
                        +"&curso_aluno="+store.proxy.extraParams.curso_aluno
                        +"&universidade_destino="+store.proxy.extraParams.universidade_destino
                        +"&tempo_afastamento="+store.proxy.extraParams.tempo_afastamento
                        +"&fgk_status="+store.proxy.extraParams.fgk_status
                    );
                }
            }
        });
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
			grid = Ext.getCmp('modtrabalhosseinter_gridtrabalhosSeinter');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			
			Ext.Ajax.request({
				url: 'Server/trabalhosseinter/checaremails.php', 
				params: {
						buscaRapida				: buscaR,
						id_trabalho				: Ext.getCmp('modtrabalhosseinter_id_trabalho_email').getValue(),
						radio					: form.getForm().findField('trabalho').getValue(),
						pa						: store.proxy.extraParams.pa,
						cpf					: store.proxy.extraParams.cpf,
						nome_aluno				: store.proxy.extraParams.nome_aluno,
						curso_aluno				: store.proxy.extraParams.curso_aluno,
						universidade_destino		: store.proxy.extraParams.universidade_destino,
						tempo_afastamento	: store.proxy.extraParams.tempo_afastamento,
						fgk_status	: store.proxy.extraParams.fgk_status
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
									url: 'Server/trabalhosseinter/enviarEmail.php',
									params : {
										buscaRapida				: buscaR,
										id_trabalho				: Ext.getCmp('modtrabalhosseinter_id_trabalho_email').getValue(),
										radio					: form.getForm().findField('trabalho').getValue(),
										pa						: store.proxy.extraParams.pa,
										cpf					: store.proxy.extraParams.cpf,
										nome_aluno				: store.proxy.extraParams.nome_aluno,
										curso_aluno				: store.proxy.extraParams.curso_aluno,
										universidade_destino		: store.proxy.extraParams.universidade_destino,
										tempo_afastamento	: store.proxy.extraParams.tempo_afastamento,
										fgk_status	: store.proxy.extraParams.fgk_status
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
	mensagemEmail: function(button) {
		var win = Ext.create('Seic.view.TrabalhosSeinter.formMensagemEmail').show();
		grid = Ext.getCmp('modtrabalhosseinter_gridtrabalhosSeinter');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modtrabalhosseinter_id_trabalho_email').setValue(grid.getSelectionModel().getSelection()[0].data.id);
		}
		else{
			Ext.getCmp('modtrabalhosseinter_radioTrabalhoSelecionado').disable();
			Ext.getCmp('modtrabalhosseinter_id_trabalho_email').setValue(0);
		}
	},
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modtrabalhosseinter_toolBarPA').hide();
		Ext.getCmp('modtrabalhosseinter_btnLimparBusca').hide();
		Ext.getCmp('modtrabalhosseinter_formBuscaAvancada').close();
		var grid = Ext.getCmp('modtrabalhosseinter_gridtrabalhosSeinter');
		grid.getStore().getProxy().extraParams = {};
		grid.getStore().load();
    },
	pesquisarTrabalhosSeinter: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		grid = Ext.getCmp('modtrabalhosseinter_gridtrabalhosSeinter');
		grid.getStore().getProxy().extraParams = {
			pa					: '1',
			cpf					: values.cpf,
			nome_aluno			: values.nome_aluno,
			curso_aluno				: values.curso_aluno,
			universidade_destino	: values.universidade_destino,
			tempo_afastamento		: values.tempo_afastamento,
			fgk_status				: values.fgk_status
		};
		grid.getStore().load();

		Ext.getCmp("modtrabalhosseinter_toolBarPA").removeAll();
		Ext.getCmp("modtrabalhosseinter_toolBarPA").show();
		Ext.getCmp("modtrabalhosseinter_toolBarPA").add(
			{	xtype: 'label',
				text: 'Listando apenas: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.cpf!=""){
			texto = "CPF: "+values.cpf;
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_status!=""){
			texto = "Situação: "+Ext.getCmp('modtrabalhosseinter_comboStatus-PA').getRawValue();
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.nome_aluno!=""){
			texto = "Aluno: "+values.nome_aluno;
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.curso_aluno!=""){
			texto = "Curso: "+values.curso_aluno;
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.universidade_destino!=""){
			texto = "Universidade: "+values.universidade_destino;
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.tempo_afastamento!=""){
			texto = "Meses afastado: "+values.tempo_afastamento;
			Ext.getCmp("modtrabalhosseinter_toolBarPA").add({xtype:'button',text: texto});
		}

		Ext.getCmp("modtrabalhosseinter_toolBarPA").add('->');
		Ext.getCmp("modtrabalhosseinter_toolBarPA").add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modtrabalhosseinter_btnLimparBusca'
			}
		);
		win.hide();
	},
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modtrabalhosseinter_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.TrabalhosSeinter.formBuscaAvancada');
		else
			win.show();
		Ext.getCmp('modtrabalhosseinter_comboStatus-PA').getStore().load();
	},
	adicionarTrabalhoSeinter: function(button) {
		var win = Ext.create('Seic.view.TrabalhosSeinter.formCadTrabalhosSeinter').show();
		win.setTitle('Novo trabalho');
		Ext.getCmp('modtrabalhosseinter_comboStatus').getStore().load();
	},
	editarTrabalhoSeinterGrid: function(grid, row) {
		var win = Ext.create('Seic.view.TrabalhosSeinter.formCadTrabalhosSeinter').show();
		win.setTitle('Editar trabalho');
		Ext.getCmp('modtrabalhosseinter_comboStatus').getStore().load();
		win.down('form').loadRecord(row);
		Ext.getCmp('modtrabalhosseinter_abaAvaliacao').enable();
	},
	editarTrabalhoSeinter: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.TrabalhosSeinter.formCadTrabalhosSeinter').show();
			win.setTitle('Editar trabalho');
			win.down('form').loadRecord(row);
			Ext.getCmp('modtrabalhosseinter_abaAvaliacao').enable();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	apagarTrabalhoSeinter: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o trabalho selecionado?',
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
			    msg: 'Selecione um trabalho para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarTrabalhosSeinter: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modtrabalhosseinter_gridtrabalhosSeinter');
			var store = grid.getStore();
			if (record){
				record.setDirty(true);
				record.set(values);
			}
			else {
				valuesTrabalho = form.getValues(false,false,false,true);
				var trabalho = Ext.create('Seic.model.TrabalhosSeinter.TrabalhosSeinter',valuesTrabalho);
				store.add(trabalho);
			}
			store.sync();
			win.close();
			grid.getSelectionModel().deselectAll();
        }
        else{
			Ext.Msg.alert({
				title: 'Atenção',
				msg: 'Favor verificar todos os campos obrigatórios.',
				buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.ERROR,
				fn: function(button){

				}
			});
		}
	}
});
