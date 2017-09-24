Ext.define('Seic.controller.Trabalhos', {
    extend: 'Ext.app.Controller',
    stores: [
		'Trabalhos.Trabalhos',
		'Trabalhos.AutoresTrabalho',
		'Trabalhos.Projetos',
		'Trabalhos.AreaEspecifica',
		'Trabalhos.Area',
		'Trabalhos.InscritoResponsavel',
		'Trabalhos.Instituicao',
		'Trabalhos.TipoApresentacao',
		'Trabalhos.Status',
		'Trabalhos.Categorias',
		'Trabalhos.TipoAutor',
		'Trabalhos.InstituicaoAutor',
		'Trabalhos.BuscarAutores',
		'Trabalhos.OrgaoFomento'
	],
    models: [
		'Trabalhos.Trabalho',
		'Trabalhos.AutoresTrabalho',
		'Trabalhos.Instituicao',
		'Trabalhos.Projeto',
		'Trabalhos.AreaEspecifica',
		'Trabalhos.Area',
		'Trabalhos.InscritoResponsavel',
		'Trabalhos.Status',
		'Trabalhos.TipoApresentacao',
		'Trabalhos.Categoria',
		'Trabalhos.TipoAutor',
		'Trabalhos.InstituicaoAutor',
		'Trabalhos.OrgaoFomento'
	],
    views: [
		'Trabalhos.gridTrabalhos',
		'Trabalhos.formCadTrabalho',
		'Trabalhos.formMensagemEmail'
	],

    init: function() {
		// console.log('Controller Trabalhos carregado');
		Ext.create('Seic.store.Trabalhos.BuscarAutores');
		Ext.create('Seic.store.Trabalhos.AutoresTrabalho');
		Ext.create('Seic.store.Trabalhos.Trabalhos');
		Ext.create('Seic.store.Trabalhos.TipoApresentacao');
		Ext.create('Seic.store.Trabalhos.Projetos');
		Ext.create('Seic.store.Trabalhos.AreaEspecifica');
		Ext.create('Seic.store.Trabalhos.Instituicao');
		Ext.create('Seic.store.Trabalhos.Area');
		Ext.create('Seic.store.Trabalhos.InscritoResponsavel');
		Ext.create('Seic.store.Trabalhos.Status');
		Ext.create('Seic.store.Trabalhos.Categorias');
		Ext.create('Seic.store.Trabalhos.OrgaoFomento');
		Ext.create('Seic.store.Trabalhos.TipoAutor');
		Ext.create('Seic.store.Trabalhos.InstituicaoAutor');
		this.control({
			'modtrabalhos_gridtrabalhos dataview': {
                itemdblclick: this.editarTrabalhoGrid,
				itemclick: this.liberarDesalocarTrabalho
            },
			'modtrabalhos_formcadautor button#btnBuscarAutor':{
				click: this.buscarAutor
			},
			'modtrabalhos_formcadautor textfield#modtrabalhos_cpfAutor':{
				validitychange: this.buscaCPFAutor
			},
			'modtrabalhos_gridtrabalhos button#btnAdicionarTrabalho': {
                click: this.adicionarTrabalho
            },
			'modtrabalhos_gridtrabalhos button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modtrabalhos_gridtrabalhos button#btnDesalocarTrabalho': {
            	click: this.desalocarTrabalho
            },
			'modtrabalhos_gridtrabalhos button#btnApagarTrabalho': {
                click: this.apagarTrabalho
            },
			'modtrabalhos_formcadautor button#btnSalvarAutor': {
                click: this.salvarAutor
            },
			'modtrabalhos_formcadtrabalho button#btnSalvarTrabalho': {
                click: this.salvarTrabalho
            },
			'modtrabalhos_formcadtrabalho button#btnAdicionarAutor': {
                click: this.adicionarAutor
            },
			'modtrabalhos_formcadtrabalho button#modtrabalhos_btnAceitarJustificativa': {
                click: this.aceitarJustificativa
            },
			'modtrabalhos_formcadtrabalho button#modtrabalhos_btnRejeitarJustificativa': {
                click: this.rejeitarJustificativa
            },
			'modtrabalhos_formcadtrabalho button#btnApagarAutor': {
                click: this.apagarAutor
            },
			'modtrabalhos_formcadtrabalho button#btnEditarAutor': {
                click: this.btnEditarAutor
            },
			'modtrabalhos_gridtrabalhos button#btnEditarTrabalho': {
                click: this.editarTrabalho
            },
			'modtrabalhos_formbuscaavancada button#btnBuscaAvancada': {
                click: this.pesquisarTrabalhos
            },
			'modtrabalhos_gridtrabalhos button#modtrabalhos_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
			'modtrabalhos_gridBuscarAutor button#btnSelecionarAutor': {
                click: this.selecionarAutor
            },
			'modtrabalhos_gridBuscarAutor dataview': {
                itemdblclick: this.selecionarAutorGrid
            },
			'modtrabalhos_gridtrabalhos menuitem#itemMensagemEmail': {
				click: this.mensagemEmail
            },
			'modtrabalhos_gridtrabalhos menuitem#itemMensagemSMS': {
				click: this.mensagemSMS
            },
			'modtrabalhos_formMensagemEmail button#btnEnviarEmail': {
				click: this.enviarEmail
			},

            'modtrabalhos_gridtrabalhos button#btnExport':{
				click: this.exportarExcel
			},
		});
    },

    exportarExcel: function(button){
        var store = button.up('window').down('#modtrabalhos_gridtrabalhos').getStore();

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
                    window.open("Server/trabalhos/exportarExcel.php?filtro="+buscaRapida
                        +"&pa="+store.proxy.extraParams.pa
                        +"&avaliacao="+store.proxy.extraParams.avaliacao
                        +"&nome_autores="+store.proxy.extraParams.nome_autores
                        +"&fgk_status="+store.proxy.extraParams.fgk_status
                        +"&fgk_area="+store.proxy.extraParams.fgk_area
                        +"&fgk_area_especifica="+store.proxy.extraParams.fgk_area_especifica
                        +"&apresentacao_obrigatoria="+store.proxy.extraParams.apresentacao_obrigatoria
                        +"&fgk_tipo_apresentacao="+store.proxy.extraParams.fgk_tipo_apresentacao
                        +"&fgk_categoria="+store.proxy.extraParams.fgk_categoria
                        +"&fgk_orgao_fomento="+store.proxy.extraParams.fgk_orgao_fomento
                    );
                }
            }
        });
    },

	liberarDesalocarTrabalho: function(grid, rowIndex){
		var records = grid.getSelectionModel().getSelection()[0];
		var botao = Ext.getCmp('btnDesalocarTrabalho');
		if(records.data.fgk_status == '3')
			botao.enable();
		else
			botao.disable();
	},
	desalocarTrabalho: function(button) {
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja desalocar o trabalho selecionado?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					grid = Ext.getCmp('modtrabalhos_gridtrabalhos');
					row = grid.getSelectionModel().getSelection()[0];
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/trabalhos/desalocarTrabalho.php',
						params: {
							id_trabalho: row.data.id
						},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso', 'Trabalho desalocado com sucesso.');
								button.disable();
								grid.getSelectionModel().deselectAll();
								grid.getStore().load();
							}
						}
					});
				}
				else {	}
			},
			animEl: 'elId',
			icon:   Ext.MessageBox.WARNING
		});
    },
	rejeitarJustificativa: function(button) {
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja rejeitar a justificativa deste trabalho?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/trabalhos/justificativaTrabalho.php',
						params: {
							id_trabalho: Ext.getCmp('modtrabalhos_id_trabalho').getValue(),
							novo_status: 12
						},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso', 'Justificativa rejeitada com sucesso.');
								Ext.getCmp('modtrabalhos_btnAceitarJustificativa').disable();
								Ext.getCmp('modtrabalhos_btnRejeitarJustificativa').disable();
							}
						}
					});
				}
				else {	}
			},
			animEl: 'elId',
			icon:   Ext.MessageBox.WARNING
		});
    },
	aceitarJustificativa: function(button) {
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja aceitar a justificativa deste trabalho?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/trabalhos/justificativaTrabalho.php',
						params: {
							id_trabalho: Ext.getCmp('modtrabalhos_id_trabalho').getValue(),
							novo_status: 11
						},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso', 'Justificativa aceita com sucesso.');
								Ext.getCmp('modtrabalhos_btnAceitarJustificativa').disable();
								Ext.getCmp('modtrabalhos_btnRejeitarJustificativa').disable();
							}
						}
					});
				}
				else {	}
			},
			animEl: 'elId',
			icon:   Ext.MessageBox.WARNING
		});
    },
	mensagemEmail: function(button) {
		var win = Ext.create('Seic.view.Trabalhos.formMensagemEmail').show();
		grid = Ext.getCmp('modtrabalhos_gridtrabalhos');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modtrabalhos_id_trabalho_email').setValue(grid.getSelectionModel().getSelection()[0].data.id);
		}
		else{
			Ext.getCmp('modtrabalhos_radioTrabalhoSelecionado').disable();
			Ext.getCmp('modtrabalhos_id_trabalho_email').setValue(0);
		}
	},
	mensagemSMS: function(button) {
		var win = Ext.create('Seic.view.Trabalhos.formMensagemSMS').show();
	},
	selecionarAutor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.getCmp('modtrabalhos_cpfAutor').setValue(row.data.cpf);
			Ext.getCmp('modtrabalhos_gridBuscarAutor').up('window').close();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um autor.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	selecionarAutorGrid: function(grid, row){
		Ext.getCmp('modtrabalhos_cpfAutor').setValue(row.data.cpf);
		Ext.getCmp('modtrabalhos_gridBuscarAutor').up('window').close();
	},
	buscarAutor: function(){
		var win = new Ext.window.Window({
			title: 'Buscar autor',
			layout: 'fit',
			autoShow: true,
			width: 750,
			height: 580,
			modal: true,
			items: [
				{	xtype: 'modtrabalhos_gridBuscarAutor'	}
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
	buscaCPFAutor: function(cpffield, isValid){
		if(isValid){
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, procurando autor...',
			    target: Ext.getCmp('modtrabalhos_formCadAutor')
			});
			myMask.show();

    		Ext.Ajax.request({
			    url: 'Server/trabalhos/buscaCPFAutor.php',
			    params: {
			        cpf: cpffield.getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();

			        if(result.success){
						Ext.getCmp('modtrabalhos_nomeAutor').setValue(result.nome);
						Ext.getCmp('modtrabalhos_emailAutor').setValue(result.email);
						Ext.getCmp('modtrabalhos_comboInstituicaoAutor').setValue(result.fgk_instituicao);
						Ext.getCmp('modtrabalhos_comboTipoAutor').setValue(result.fgk_tipo_autor);
						Ext.getCmp('modtrabalhos_camposAutorTrabalho').enable();
			        }
					else{
						Ext.getCmp('modtrabalhos_camposAutorTrabalho').enable();
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
    	}else{
    		// Ext.getCmp('modprojetos_FormNomeOrientador').setValue('');
			// Ext.getCmp('modprojetos_FormEmailOrientador').setValue('');
    	}
    },
	editarTrabalhoGrid: function(grid, record) {
		var win = Ext.create('Seic.view.Trabalhos.formCadTrabalho').show();
		Ext.getCmp('modtrabalhos_abaAvaliacao').enable();
		win.setTitle('Editar trabalho');
		Ext.getCmp('modtrabalhos_abaRevisado').enable();
		Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().getProxy().extraParams = {
			id_trabalho: record.data.id
		};
		Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().load();
		// if(record.data.fgk_inscrito_responsavel)
			// Ext.getCmp('modtrabalhos_comboInscritoResponsavel').setReadOnly(true);

		if(record.data.fgk_status == 10){
			Ext.getCmp('modtrabalhos_btnAceitarJustificativa').enable();
			Ext.getCmp('modtrabalhos_btnRejeitarJustificativa').enable();
		}

		Ext.getCmp('modtrabalhos_comboStatus').getStore().load();
		Ext.getCmp('modtrabalhos_comboInstituicao').getStore().load();
		Ext.getCmp('modtrabalhos_comboArea').getStore().load();
		comboAreaEspecifica = Ext.getCmp('modtrabalhos_comboAreaEspecifica');
		comboAreaEspecifica.getStore().getProxy().extraParams = {
			id_area	: record.data.fgk_area
		};
		comboAreaEspecifica.getStore().load();
		Ext.getCmp('modtrabalhos_comboOrgao').getStore().load();
		Ext.getCmp('modtrabalhos_comboCategoria').getStore().load();
		Ext.getCmp('modtrabalhos_comboTipoApresentacao').getStore().load();

		win.down('form').loadRecord(record);

		var gridAutores = Ext.getCmp('modtrabalhos_gridAutores');
		gridAutores.enable();
		gridAutores.getStore().getProxy().extraParams = {
			id_trabalho: record.data.id
		};
		gridAutores.getStore().load();
    },
	 limparBuscaAvancada: function(button) {
		Ext.getCmp('modtrabalhos_toolBarPA').hide();
		Ext.getCmp('modtrabalhos_btnLimparBusca').hide();
		Ext.getCmp('modtrabalhos_formBuscaAvancada').close();
		var gridTrabalhos = Ext.getCmp('modtrabalhos_gridtrabalhos');
		gridTrabalhos.getStore().getProxy().extraParams = {};
		gridTrabalhos.getStore().load();
    },
	pesquisarTrabalhos: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridTrabalhos = Ext.getCmp('modtrabalhos_gridtrabalhos');
		gridTrabalhos.getStore().getProxy().extraParams = {
			pa					: '1',
			avaliacao				: values.avaliacao,
			apresentacao_obrigatoria: values.apresentacao_obrigatoria,
			nome_autores			: values.nome_autores,
			fgk_status				: values.fgk_status,
			fgk_area				: values.fgk_area,
			fgk_area_especifica		: values.fgk_area_especifica,
			fgk_tipo_apresentacao	: values.fgk_tipo_apresentacao,
			fgk_orgao_fomento		: values.fgk_orgao_fomento,
			fgk_categoria			: values.fgk_categoria
		};
		gridTrabalhos.getStore().load();

		Ext.getCmp("modtrabalhos_toolBarPA").removeAll();
		Ext.getCmp("modtrabalhos_toolBarPA").show();
		Ext.getCmp("modtrabalhos_toolBarPA").add(
			{	xtype: 'label',
				text: 'Listando apenas: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.avaliacao=="1"){
			texto = "Trabalhos avaliados";
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		else if(values.avaliacao=="0"){
			texto = "Trabalhos não avaliados";
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.apresentacao_obrigatoria=="1"){
			texto = "Apresentação obrigatória";
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		else if(values.apresentacao_obrigatoria=="0"){
			texto = "Apresentação não obrigatória";
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.nome_autores!=""){
			texto = "Autores: "+values.nome_autores;
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		// if(values.fgk_inscrito_responsavel!=""){
			// texto = "Responsável: "+Ext.getCmp('modtrabalhos_comboInscritoResponsavel-PA').getRawValue();
			// Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		// }
		if(values.fgk_status!=""){
			texto = "Situação: "+Ext.getCmp('modtrabalhos_comboStatus-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_area!=""){
			texto = "Área: "+Ext.getCmp('modtrabalhos_comboArea-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_area_especifica!=""){
			texto = "Área específica: "+Ext.getCmp('modtrabalhos_comboAreaEspecifica-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_tipo_apresentacao!=""){
			texto = "Apresentação: "+Ext.getCmp('modtrabalhos_comboTipoApresentacao-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_orgao_fomento!=""){
			texto = "Órgão fomento: "+Ext.getCmp('modtrabalhos_comboOrgao-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_categoria!=""){
			texto = "Categoria: "+Ext.getCmp('modtrabalhos_comboCategoria-PA').getRawValue();
			Ext.getCmp("modtrabalhos_toolBarPA").add({xtype:'button',text: texto});
		}

		Ext.getCmp("modtrabalhos_toolBarPA").add('->');
		Ext.getCmp("modtrabalhos_toolBarPA").add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modtrabalhos_btnLimparBusca'
			}
		);
		win.hide();
	},
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modtrabalhos_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Trabalhos.formBuscaAvancada');
		else
			win.show();
		// Ext.getCmp('modtrabalhos_comboInscritoResponsavel-PA').getStore().load();
		Ext.getCmp('modtrabalhos_comboStatus-PA').getStore().load();
		Ext.getCmp('modtrabalhos_comboArea-PA').getStore().load();
		Ext.getCmp('modtrabalhos_comboTipoApresentacao-PA').getStore().load();
		Ext.getCmp('modtrabalhos_comboOrgao-PA').getStore().load();
		Ext.getCmp('modtrabalhos_comboCategoria-PA').getStore().load();
	},
	apagarTrabalho: function(button) {
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
			    msg: 'Selecione um trabalho para remover.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarAutor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o autor: <b>'+records.data.nome+'</b> ?',
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
	adicionarAutor: function(button) {
		var win = Ext.create('Seic.view.Trabalhos.formCadAutor').show();
		grid = Ext.getCmp('modtrabalhos_gridtrabalhos');
		row = grid.getSelectionModel().getSelection()[0];
		Ext.getCmp('modtrabalhos_fgk_trabalho').setValue(Ext.getCmp('modtrabalhos_id_trabalho').getValue());
		win.setTitle('Novo autor');
		Ext.getCmp('modtrabalhos_comboInstituicaoAutor').getStore().load();
		Ext.getCmp('modtrabalhos_comboTipoAutor').getStore().load();
	},
	adicionarTrabalho: function(button) {
		var win = Ext.create('Seic.view.Trabalhos.formCadTrabalho').show();
		win.setTitle('Novo trabalho');
		Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().getProxy().extraParams = {
			id_trabalho: 0
		};
		Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().load();
		Ext.getCmp('modtrabalhos_comboStatus').getStore().load();
		Ext.getCmp('modtrabalhos_comboArea').getStore().load();
		Ext.getCmp('modtrabalhos_comboInstituicao').getStore().load();
		Ext.getCmp('modtrabalhos_comboOrgao').getStore().load();
		Ext.getCmp('modtrabalhos_comboCategoria').getStore().load();
		Ext.getCmp('modtrabalhos_comboTipoApresentacao').getStore().load();
		var gridAutores = Ext.getCmp('modtrabalhos_gridAutores');
		gridAutores.disable();
		gridAutores.getStore().getProxy().extraParams = {
			id_trabalho: 0
		};
		gridAutores.getStore().load();
	},
	editarAutorGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Trabalhos.formCadAutor').show();
		win.setTitle('Editar autor');
		Ext.getCmp('modtrabalhos_comboInstituicaoAutor').getStore().load();
		Ext.getCmp('modtrabalhos_comboTipoAutor').getStore().load();
		win.down('form').loadRecord(row);
		Ext.getCmp('modtrabalhos_cpfAutor').setReadOnly(true);
		Ext.getCmp('modtrabalhos_btnLupa').disable();
    },
	btnEditarAutor: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Trabalhos.formCadAutor').show();
			win.setTitle('Editar autor');
			Ext.getCmp('modtrabalhos_comboInstituicaoAutor').getStore().load();
			Ext.getCmp('modtrabalhos_comboTipoAutor').getStore().load();

			win.down('form').loadRecord(row);
			Ext.getCmp('modtrabalhos_cpfAutor').setReadOnly(true);
			Ext.getCmp('modtrabalhos_btnLupa').disable();

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um autor para editar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
    },
	editarTrabalho: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Trabalhos.formCadTrabalho').show();
			Ext.getCmp('modtrabalhos_abaAvaliacao').enable();
			win.setTitle('Editar trabalho');
			Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().getProxy().extraParams = {
				id_trabalho: row.data.id
			};
			Ext.getCmp('modtrabalhos_comboInscritoResponsavel').getStore().load();
			// if(row.data.fgk_inscrito_responsavel)
				// Ext.getCmp('modtrabalhos_comboInscritoResponsavel').setReadOnly(true);
			Ext.getCmp('modtrabalhos_comboStatus').getStore().load();
			Ext.getCmp('modtrabalhos_comboArea').getStore().load();
			Ext.getCmp('modtrabalhos_comboInstituicao').getStore().load();
			comboAreaEspecifica = Ext.getCmp('modtrabalhos_comboAreaEspecifica');
			comboAreaEspecifica.getStore().getProxy().extraParams = {
				id_area	: row.data.fgk_area
			};
			if(row.data.fgk_status == 10){
				Ext.getCmp('modtrabalhos_btnAceitarJustificativa').enable();
				Ext.getCmp('modtrabalhos_btnRejeitarJustificativa').enable();
			}
			comboAreaEspecifica.getStore().load();
			Ext.getCmp('modtrabalhos_comboOrgao').getStore().load();
			Ext.getCmp('modtrabalhos_comboCategoria').getStore().load();
			Ext.getCmp('modtrabalhos_comboTipoApresentacao').getStore().load();

			win.down('form').loadRecord(row);

			var gridAutores = Ext.getCmp('modtrabalhos_gridAutores');
			gridAutores.enable();
			gridAutores.getStore().getProxy().extraParams = {
				id_trabalho: row.data.id
			};
			gridAutores.getStore().load();
			Ext.getCmp('modtrabalhos_abaRevisado').enable();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para editar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
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
			grid = Ext.getCmp('modtrabalhos_gridtrabalhos');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/trabalhos/checaremails.php',
				params: {
						buscaRapida				: buscaR,
						id_trabalho				:  Ext.getCmp('modtrabalhos_id_trabalho_email').getValue(),
						destinatario_autor		:  Ext.getCmp('modtrabalhos_checkautor').getValue(),
						destinatario_orientador	:  Ext.getCmp('modtrabalhos_checkorientador').getValue(),
						destinataro_coautor		:  Ext.getCmp('modtrabalhos_checkcoautor').getValue(),
						colaborador				:  Ext.getCmp('modtrabalhos_checkcolaborador').getValue(),
						radio					:  Ext.getCmp('modtrabalhos_radioselecionado').getValue(),
						pa						: store.proxy.extraParams.pa,
						avaliacao				: store.proxy.extraParams.avaliacao,
						apresentacao_obrigatoria: store.proxy.extraParams.apresentacao_obrigatoria,
						nome_autores			: store.proxy.extraParams.nome_autores,
						fgk_status				: store.proxy.extraParams.fgk_status,
						fgk_area				: store.proxy.extraParams.fgk_area,
						fgk_area_especifica		: store.proxy.extraParams.fgk_area_especifica,
						fgk_tipo_apresentacao	: store.proxy.extraParams.fgk_tipo_apresentacao,
						fgk_orgao_fomento		: store.proxy.extraParams.fgk_orgao_fomento,
						fgk_categoria			: store.proxy.extraParams.fgk_categoria

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
									url: 'Server/trabalhos/enviarEmail.php',
									params : {
										buscaRapida				: buscaR,
										pa						: store.proxy.extraParams.pa,
										avaliacao				: store.proxy.extraParams.avaliacao,
										apresentacao_obrigatoria: store.proxy.extraParams.apresentacao_obrigatoria,
										nome_autores			: store.proxy.extraParams.nome_autores,
										fgk_status				: store.proxy.extraParams.fgk_status,
										fgk_area				: store.proxy.extraParams.fgk_area,
										fgk_area_especifica		: store.proxy.extraParams.fgk_area_especifica,
										fgk_tipo_apresentacao	: store.proxy.extraParams.fgk_tipo_apresentacao,
										fgk_orgao_fomento		: store.proxy.extraParams.fgk_orgao_fomento,
										fgk_categoria			: store.proxy.extraParams.fgk_categoria
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
	salvarAutor: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modtrabalhos_gridAutores');
			var store = grid.getStore();
			if (record){
				form.submit({
					url: 'Server/trabalhos/atualizarAutoresTrabalho.php',
					waitMsg: 'Salvando autor...',
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
				valuesAutor = form.getValues(false,false,false,true);
				var autor = Ext.create('Seic.model.Trabalhos.AutoresTrabalho',valuesAutor);
				store.add(autor);
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
						msg: data.msg,
						icon: Ext.Msg.WARNING,
						buttons: Ext.Msg.OK
					});
				}
			});
			//
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarTrabalho: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		var id_trabalho;
		var data;
		if(form.isValid()) {
			var grid = Ext.getCmp('modtrabalhos_gridtrabalhos');
			var store = grid.getStore();
			if (record){
				var edicao = 1;
				record.setDirty(true);
				record.set(values);
			}
			else {
				var edicao = 0;
				valuesTrabalho = form.getValues(false,false,false,true);
				var trabalho = Ext.create('Seic.model.Trabalhos.Trabalho',valuesTrabalho);
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
							var trabalho = Ext.create('Seic.model.Trabalhos.Trabalho',data);
							form.loadRecord(trabalho);

							Ext.getCmp('modtrabalhos_id_trabalho').setValue(id_trabalho);

							var gridAutores = Ext.getCmp('modtrabalhos_gridAutores');
							gridAutores.enable();
							gridAutores.getStore().getProxy().extraParams = {
								id_trabalho: id_trabalho
							};
							gridAutores.getStore().load();
						}
						else {
							win.close();
						}
					}
				});
			}
			else{
				win.close();
			}
        }
        else{
			Ext.Msg.alert({
				title: 'Atenção',
				msg: 'Favor informar todos os campos obrigatórios.',
				buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.ERROR,
				fn: function(button){
					form2 = Ext.getCmp('modtrabalhos_formAba2');
					if(!form2.isValid()){
						Ext.getCmp('modtrabalhos_tabCadTrabalho').setActiveTab(1);
					}
				}
			});
		}
	},
});
