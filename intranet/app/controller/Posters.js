Ext.define('Seic.controller.Posters', {
    extend: 'Ext.app.Controller',
    stores: [
		'Posters.Sessoes',
		'Posters.AlocaRev',
		'Posters.AlocaSessao',
		'Posters.PostersTrabalhos',
		'Posters.CapacidadesSessao'
	],
    views: [
		'Posters.gridSessoes',
		'Posters.gridPostersTrabalhos',
		'Posters.formCadSessao'
	],

    init: function() {
		Ext.create('Seic.store.Posters.Sessoes');
		Ext.create('Seic.store.Posters.AlocaRev');
		Ext.create('Seic.store.Posters.AlocaSessao');
		Ext.create('Seic.store.Posters.PostersTrabalhos');
		Ext.create('Seic.store.Posters.CapacidadesSessao');
		this.control({
			'modposters_formEmailAutores button#btnEnviarEmailAutores': {
				click: this.enviarEmailAutores
            },
			'modposters_formEmailAvaliadores button#btnEnviarEmailAvaliadores': {
				click: this.enviarEmailAvaliadores
            },
			'modposters_gridPostersTrabalhos menuitem#itemEmailAutores': {
				click: this.emailAutores
            },
			'modposters_gridPostersTrabalhos menuitem#itemEmailAvaliadores': {
				click: this.emailAvaliadores
            },
			'modposters_gridPostersTrabalhos button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modposters_formBuscaAvancada button#btnBuscaAvancada': {
                click: this.pesquisarTrabalhos
            },
			'modposters_gridPostersTrabalhos button#btnAlocarRevisorSessao': {
                click: this.alocarRevisorSessao
            },
			'modposters_gridPostersTrabalhos button#btnDesalocarRevisorSessao': {
                click: this.desalocarRevisorSessao
            },
			'modposters_gridPostersTrabalhos dataview': {
                itemdblclick: this.alocarRevisorSessaoGrid
            },
			'modposters_gridSessoes button#btnAdicionarSessao': {
                click: this.adicionarSessao
            },
			'modposters_formCadSessao button#btnSalvarSessao': {
                click: this.salvarSessao
            },
			'modposters_gridSessoes dataview': {
                itemdblclick: this.editarSessaoGrid
            },
			'modposters_gridSessoes button#btnEditarSessao': {
                click: this.editarSessao
            },
			'modposters_gridSessoes button#btnApagarSessao': {
                click: this.apagarSessao
            },
			'modposters_formCadSessao button#btnApagarCapacidade': {
                click: this.apagarCapacidade
            },
			'modposters_formCadSessao button#btnEditarCapacidade': {
                click: this.editarCapacidade
            },
			'modposters_formCadSessao button#btnAdicionarCapacidade': {
                click: this.adicionarCapacidade
            },
			'modposters_formCadCapacidade button#btnSalvarCapacidade': {
                click: this.salvarCapacidade
            },
			'modposters_formAlocarRevisorSessao button#btnSalvarRevisorSessao': {
                click: this.salvarRevisorSessao
            },
			'modposters_gridPostersTrabalhos button#modposters_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            }, 
			'modposters_gridPostersTrabalhos button#btnExport':{
				click: this.exportarExcel
			},
		});
    },
	exportarExcel: function(button){
        var store = button.up('window').down('#modposters_gridPostersTrabalhos').getStore();

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
                    window.open("Server/posters/exportarExcel.php?filtro="+buscaRapida
                        +"&pa="+store.proxy.extraParams.pa
                        +"&fgk_area="+store.proxy.extraParams.fgk_area
                        +"&fgk_revisor="+store.proxy.extraParams.fgk_revisor
                        +"&fgk_sessao="+store.proxy.extraParams.fgk_sessao
                        +"&bool_alocado="+store.proxy.extraParams.bool_alocado
                    );
                }
            }
        });
    },
	enviarEmailAutores: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, contabilizando emails...',
			    target: win
			});
			myMask.show();
			grid = Ext.getCmp('modposters_gridPostersTrabalhos');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/posters/checarEmailAutores.php',
				params: {
						buscaRapida		: buscaR,
						id_trabalho		: Ext.getCmp('modposters_id_trabalho_email_autor').getValue(),
						destinatario_autor		:  Ext.getCmp('modposters_checkautor').getValue(),
						// destinatario_orientador	:  Ext.getCmp('modposters_checkorientador').getValue(),
						destinataro_coautor		:  Ext.getCmp('modposters_checkcoautor').getValue(),
						colaborador				:  Ext.getCmp('modposters_checkcolaborador').getValue(),
						radio			: form.getForm().findField('trabalho').getValue(),
						pa				: store.proxy.extraParams.pa,
						fgk_area		: store.proxy.extraParams.fgk_area,
						fgk_revisor		:  store.proxy.extraParams.fgk_revisor,
						fgk_sessao		: store.proxy.extraParams.fgk_sessao,
						bool_alocado	: store.proxy.extraParams.bool_alocado
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
									url: 'Server/posters/enviarEmailAutores.php',
									params : {
										buscaRapida		: buscaR,
										id_trabalho		: Ext.getCmp('modposters_id_trabalho_email_autor').getValue(),
										radio			: form.getForm().findField('trabalho').getValue(),
										destinatario_autor		:  Ext.getCmp('modposters_checkautor').getValue(),
										// destinatario_orientador	:  Ext.getCmp('modposters_checkorientador').getValue(),
										destinataro_coautor		:  Ext.getCmp('modposters_checkcoautor').getValue(),
										colaborador				:  Ext.getCmp('modposters_checkcolaborador').getValue(),
										pa				: store.proxy.extraParams.pa,
										fgk_area		: store.proxy.extraParams.fgk_area,
										fgk_revisor		:  store.proxy.extraParams.fgk_revisor,
										fgk_sessao		: store.proxy.extraParams.fgk_sessao,
										bool_alocado	: store.proxy.extraParams.bool_alocado
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
	enviarEmailAvaliadores: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, contabilizando emails...',
			    target: win
			});
			myMask.show();
			grid = Ext.getCmp('modposters_gridPostersTrabalhos');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/posters/checarEmailAvaliadores.php',
				params: {
						buscaRapida		: buscaR,
						id_trabalho		: Ext.getCmp('modposters_id_trabalho_email').getValue(),
						radio			: form.getForm().findField('trabalho').getValue(),
						pa				: store.proxy.extraParams.pa,
						fgk_area		: store.proxy.extraParams.fgk_area,
						fgk_revisor		:  store.proxy.extraParams.fgk_revisor,
						fgk_sessao		: store.proxy.extraParams.fgk_sessao,
						bool_alocado	: store.proxy.extraParams.bool_alocado
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
									url: 'Server/posters/enviarEmailAvaliadores.php',
									params : {
										buscaRapida		: buscaR,
										id_trabalho		: Ext.getCmp('modposters_id_trabalho_email').getValue(),
										radio			: form.getForm().findField('trabalho').getValue(),
										pa				: store.proxy.extraParams.pa,
										fgk_area		: store.proxy.extraParams.fgk_area,
										fgk_revisor		:  store.proxy.extraParams.fgk_revisor,
										fgk_sessao		: store.proxy.extraParams.fgk_sessao,
										bool_alocado	: store.proxy.extraParams.bool_alocado
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
	emailAutores: function(button) {
		Ext.Msg.alert({
			title: 'Atenção',
			msg: 'Não altere no texto a palavra: <b>*todostrabalhos*</b>.</br>Ela será substituída automaticamente no momento do envio. O restante do texto pode ser editado normalmente.',
			buttons: Ext.Msg.OK,
			icon:   Ext.MessageBox.WARNING,
			fn: function(button){
				var win = Ext.create('Seic.view.Posters.formEmailAutores').show();
				var texto = 'Prezado(a),</br></br>Agradecemos a sua participação no Encontro de Saberes.</br></br>Desta forma, confirmamos a sua participação com o(s) seguinte(s) trabalho(s), na modalidade Pôster:</br></br>*todostrabalhos*</br></br>Solicitamos que os apresentadores cheguem pelo menos 15 minutos antes do início da sessão para localizar o painel enumerado disponibilizado para o seu pôster conforme programação no site www.encontrodesaberes.ufop.br</br></br>As apresentações acontecerão nas sessões definidas (dias e horários marcados na programação) no Setor de Feiras/Salão Diamantina do Centro de Artes e Convenções da Universidade Federal de Ouro Preto (próximo à Praça da Estação de Ouro Preto).</br></br>Os trabalhos e a sua apresentação serão avaliados por professores da UFOP de sua respectiva área ou áreas afins e os autores deverão permanecer até o fim da sessão em frente ao painel.</br></br>Os certificados serão disponibilizados online, na página do Encontro de Saberes assim como o de participação que será validado por leitura de código de barras como registro de presença ao longo do evento.</br></br>Os participantes que não confirmaram a sua inscrição no evento deverão validar a inscrição mediante pagamento na secretaria de Novas Inscrições, preferencialmente pela manhã.</br></br>Agradecemos e quaisquer dúvidas estamos à disposição.</br></br>Atenciosamente,</br>Equipe organizadora do Encontro de Saberes.';
				Ext.getCmp('modposters_textoEmailAutores').setValue(texto);
				grid = Ext.getCmp('modposters_gridPostersTrabalhos');
				if(grid.getSelectionModel().hasSelection()){
					Ext.getCmp('modposters_id_trabalho_email_autor').setValue(grid.getSelectionModel().getSelection()[0].data.id);
				}
				else{
					Ext.getCmp('modposters_radioSelecionadoAutor').disable();
					Ext.getCmp('modposters_id_trabalho_email_autor').setValue(0);
				}
			}
		});
	},
	emailAvaliadores: function(button) {
		Ext.Msg.alert({
			title: 'Atenção',
			msg: 'Não altere no texto as palavras: <b>*nomerevisor*</b> e <b>*todostrabalhos*</b>.</br>Elas serão substituídas automaticamente no momento do envio. O restante do texto pode ser editado normalmente.',
			buttons: Ext.Msg.OK,
			icon:   Ext.MessageBox.WARNING,
			fn: function(button){
				var win = Ext.create('Seic.view.Posters.formEmailAvaliadores').show();
				var texto = 'Prezado(a) *nomerevisor*,</br></br>Gostaríamos de agradecer sua disponibilidade de participar como avaliador durante o Encontro de Saberes.</br></br>Desta forma, confirmamos sua participação como avaliador dos seguintes trabalhos, na modalidade Pôster:</br></br> *todostrabalhos*</br>Solicitamos que os avaliadores cheguem 15 minutos antes do inicio da sessão para retirar a pasta com os trabalhos que serão avaliados, bem como receber as orientações de avaliação e entrega dos certificados.</br></br>Importante: O estacionamento externo estará aberto.</br></br>Local do evento: Centro de Artes e Convenções da UFOP.</br></br>Agradecemos sua colaboração e quaisquer dúvidas estamos à disposição.';
				Ext.getCmp('modposters_textoEmailAvaliadores').setValue(texto);
				grid = Ext.getCmp('modposters_gridPostersTrabalhos');
				if(grid.getSelectionModel().hasSelection()){
					Ext.getCmp('modposters_id_trabalho_email').setValue(grid.getSelectionModel().getSelection()[0].data.id);
				}
				else{
					Ext.getCmp('modposters_radioSelecionado').disable();
					Ext.getCmp('modposters_id_trabalho_email').setValue(0);
				}
			}
		});
	},
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modposters_toolBarPA').hide();
		Ext.getCmp('modposters_btnLimparBusca').hide();
		Ext.getCmp('modposters_formBuscaAvancada').close();
		var gridTrabalhos = Ext.getCmp('modposters_gridPostersTrabalhos');
		gridTrabalhos.getStore().getProxy().extraParams = {};
		gridTrabalhos.getStore().load();
    },
	pesquisarTrabalhos: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridTrabalhos = Ext.getCmp('modposters_gridPostersTrabalhos');
		gridTrabalhos.getStore().getProxy().extraParams = {
			pa				: '1',
			fgk_area		: values.fgk_area,
			fgk_revisor		: values.fgk_revisor,
			fgk_sessao		: values.fgk_sessao,
			bool_alocado	: values.bool_alocado
		};
		gridTrabalhos.getStore().loadPage(1);

		toolbar = Ext.getCmp("modposters_toolBarPA");
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
			toolbar.add({xtype:'button',text: Ext.getCmp('modposters_comboArea-PA').getRawValue()});
		}
		if(values.fgk_revisor!=""){
			toolbar.add({xtype:'button', text: Ext.getCmp('modposters_comboRevisor-PA').getRawValue()});
		}
		if(values.fgk_sessao!=""){
			toolbar.add({xtype:'button',text: Ext.getCmp('modposters_comboSessao-PA').getRawValue()});
		}
		if(values.bool_alocado=="0"){
			toolbar.add({xtype:'button', text: "Não alocados"});
		}
		if(values.bool_alocado=="1"){
			toolbar.add({xtype:'button', text: "Alocados"});
		}

		toolbar.add('->');
		toolbar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modposters_btnLimparBusca'
			}
		);
		win.hide();
	},
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modposters_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Posters.formBuscaAvancada');
		else
			win.show();

		Ext.getCmp('modposters_comboArea-PA').getStore().load();
		Ext.getCmp('modposters_comboSessao-PA').getStore().load();
		Ext.getCmp('modposters_comboRevisor-PA').getStore().load();
	},
	salvarRevisorSessao: function(button){
		gridAlocaRev = Ext.getCmp('modposters_gridAlocaRev');
		gridAlocaSessao = Ext.getCmp('modposters_gridAlocaSessao');
		if(gridAlocaRev.getSelectionModel().hasSelection()){
			if(gridAlocaSessao.getSelectionModel().hasSelection()){
				rowTrabalho = Ext.getCmp('modposters_gridPostersTrabalhos').getSelectionModel().getSelection()[0];
				rowAlocaRev = gridAlocaRev.getSelectionModel().getSelection()[0];
				rowAlocaSessao = gridAlocaSessao.getSelectionModel().getSelection()[0];
				Ext.Msg.show({
					title:   'Confirmação',
					msg:   'Deseja alocar o revisor: <b>'+rowAlocaRev.data.nome+'</b> na sessão: <b>'+rowAlocaSessao.data.nome+'</b> ?',
					icon:   Ext.MessageBox.QUESTION,
					buttons: Ext.Msg.YESNO,
					fn: function(button){
						if(button=="yes"){
							// if(rowAlocaSessao.data.total < rowAlocaSessao.data.capacidade){
								Ext.Ajax.request({
									url: 'Server/posters/alocarRevSessao.php',
									params: {
										id_trabalho				: rowTrabalho.data.id,
										id_sessao				: rowAlocaSessao.data.id,
										id_revisor				: rowAlocaRev.data.id,
										id_area					: rowAlocaSessao.data.fgk_area,
										alocados				: rowAlocaSessao.data.total,
										id_apresentacao			: rowTrabalho.data.id_apresentacao,
										codigo_area				: rowTrabalho.data.codigo_area
									},
									success: function(res){
										if(Ext.JSON.decode(res.responseText).success){
											Ext.getCmp('modposters_formAlocarRevisorSessao').close();
											Ext.getCmp('modposters_gridPostersTrabalhos').getStore().load();
										}
										else{
											Ext.Msg.show({
												title:'Atenção',
												msg:  Ext.JSON.decode(res.responseText).msg,
												icon: Ext.Msg.WARNING,
												buttons: Ext.Msg.OK
											});
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
							// }
							// else{
								// Ext.Msg.alert({
									// title: 'Atenção',
									// msg: 'A sessão <b>'+rowAlocaSessao.data.nome+'</b> já está com a capacidade esgotada.',
									// icon:   Ext.MessageBox.WARNING,
									// buttons: Ext.Msg.OK
								// });
							// }
						}
					}
				});
			}
			else{
				Ext.Msg.alert({
					title: 'Atenção',
					msg: 'Selecione uma sessão.',
					buttons: Ext.Msg.OK
				});
			}
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um revisor para avaliar o trabalho.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	salvarCapacidade: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modposters_gridCapacidades');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesCapacidade = form.getValues(false,false,false,true);
				var capacidade = Ext.create('Seic.model.Posters.CapacidadesSessao',valuesCapacidade);
				store.add(capacidade);
			}
			store.sync({
				async: false,
				success: function(response, options){
					win.close();
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
	apagarSessao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar a sessão: <b>'+row.data.nome+'</b>?<br>Esta ação não poderá ser revertida.',
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
			    msg: 'Selecione uma sessão para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarCapacidade: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar a capacidade selecionada?',
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
			    msg: 'Selecione uma capacidade para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarCapacidade: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Posters.formCadCapacidade').show();
			win.setTitle('Editar capacidade');
			win.down('form').loadRecord(row);
			win.down('combobox').getStore().load();
			win.down('combobox').setValue(row.data.fgk_area);
			win.down('combobox').disable();
			

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione uma capacidade para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarSessao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Posters.formCadSessao').show();
			win.setTitle('Editar sessão');
			win.down('form').loadRecord(row);
			var gridCapacidades = Ext.getCmp('modposters_gridCapacidades');
			gridCapacidades.enable();
			gridCapacidades.getStore().getProxy().extraParams = {
				id_sessao: row.data.id
			};
			gridCapacidades.getStore().load();

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione uma sessão para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarCapacidadeGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Posters.formCadCapacidade').show();
		win.setTitle('Editar capacidade');
		win.down('form').loadRecord(row);
	},
	editarSessaoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Posters.formCadSessao').show();
		win.setTitle('Editar sessão');
		win.down('form').loadRecord(row);
		var gridCapacidades = Ext.getCmp('modposters_gridCapacidades');
		gridCapacidades.enable();
		gridCapacidades.getStore().getProxy().extraParams = {
			id_sessao: row.data.id
		};
		gridCapacidades.getStore().load();
	},
	alocarRevisorSessaoGrid: function(grid, row) {

		var row = grid.getSelectionModel().getSelection()[0];
		var win = Ext.create('Seic.view.Posters.formAlocarRevisorSessao').show();
		win.setTitle(row.data.descricao_area+' - '+row.data.descricao_area_especifica);
		Ext.getCmp('modposters_tituloAlocaRev').setValue(row.data.titulo_enviado);

		var gridAlocaRev = Ext.getCmp('modposters_gridAlocaRev');
		gridAlocaRev.getStore().getProxy().extraParams = {
			id_area: row.data.fgk_area,
			id_area_especifica: row.data.fgk_area_especifica,
			id_trabalho:  row.data.id
		};
		gridAlocaRev.getStore().load();

		var gridAlocaSessao = Ext.getCmp('modposters_gridAlocaSessao');
		gridAlocaSessao.getStore().getProxy().extraParams = {
			id_revisor: 0,
			id_area: row.data.fgk_area
		};
		gridAlocaSessao.getStore().load();

		comboAreaEspecifica = Ext.getCmp('modposters_comboAreaEspecifica');
		comboAreaEspecifica.enable();
		comboAreaEspecifica.setValue(row.data.fgk_area_especifica);
		comboAreaEspecifica.getStore().getProxy().extraParams = {
			id_area: row.data.fgk_area
		};
		comboAreaEspecifica.getStore().load();

	},
	alocarRevisorSessao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Posters.formAlocarRevisorSessao').show();
			win.setTitle(row.data.descricao_area+' - '+row.data.descricao_area_especifica);
			Ext.getCmp('modposters_tituloAlocaRev').setValue(row.data.titulo_enviado);

			var gridAlocaRev = Ext.getCmp('modposters_gridAlocaRev');
			gridAlocaRev.getStore().getProxy().extraParams = {
				id_area: row.data.fgk_area,
				id_area_especifica: row.data.fgk_area_especifica,
				id_trabalho:  row.data.id
			};
			gridAlocaRev.getStore().load();

			var gridAlocaSessao = Ext.getCmp('modposters_gridAlocaSessao');
			gridAlocaSessao.getStore().getProxy().extraParams = {
				id_revisor: 0,
				id_area: row.data.fgk_area
			};
			gridAlocaSessao.getStore().load();


			comboAreaEspecifica = Ext.getCmp('modposters_comboAreaEspecifica');
			comboAreaEspecifica.enable();
			comboAreaEspecifica.setValue(row.data.fgk_area_especifica);
			comboAreaEspecifica.getStore().getProxy().extraParams = {
				id_area: row.data.fgk_area
			};
			comboAreaEspecifica.getStore().load();

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para alocar um revisor.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	desalocarRevisorSessao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja desalocar o avaliador do trabalho selecionado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							url: 'Server/posters/desalocarRevSessao.php',
							params: {
								id_apresentacao	: records.data.id_apresentacao,

							},
							success: function(conn, response, options, eOpts){
								grid.getStore().load();

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
				animEl: 'elId',
				icon:   Ext.MessageBox.QUESTION
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para desalocar o avaliador.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	adicionarCapacidade: function(button) {
		var win = Ext.create('Seic.view.Posters.formCadCapacidade').show();
		win.setTitle('Nova capacidade');
		Ext.getCmp('modposters_comboAreaCapacidade').getStore().load();
		Ext.getCmp('modposters_fgk_sessao').setValue(Ext.getCmp('modposters_idSessao').getValue());
	},
	adicionarSessao: function(button) {
		var win = Ext.create('Seic.view.Posters.formCadSessao').show();
		win.setTitle('Nova sessão');
		var gridCapacidades = Ext.getCmp('modposters_gridCapacidades');
		gridCapacidades.getStore().getProxy().extraParams = {
			id_sessao: 0
		};
		gridCapacidades.getStore().load();
	},
	salvarSessao: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		var id_sessao;
		var data;
		if(form.isValid()) {
			var grid = Ext.getCmp('modposters_gridSessoes');
			var store = grid.getStore();
			if (record){
				var edicao = 1;
				record.setDirty(true);
				record.set(values);
			}
			else {
				var edicao = 0;
				valuesSessao = form.getValues(false,false,false,true);
				var sessao = Ext.create('Seic.model.Posters.Sessoes',valuesSessao);
				store.add(sessao);
			}
			store.sync({
				async: false,
				success: function(response, options){
					id_sessao = response.proxy.getReader().jsonData.id_sessao;
					if (edicao == 0){
						Ext.Msg.show({
							title:   'Sucesso',
							msg:   'Sessão cadastrada com sucesso. Deseja cadastrar as capacidades agora?',
							icon:   Ext.MessageBox.QUESTION,
							buttons: Ext.Msg.YESNO,
							fn: function(button){
								if(button=="yes"){
									win.setTitle('Editar sessão');
									form.loadRecord(sessao);
									Ext.getCmp('modposters_idSessao').setValue(id_sessao);

									var gridCapacidades = Ext.getCmp('modposters_gridCapacidades');
									gridCapacidades.enable();
									gridCapacidades.getStore().getProxy().extraParams = {
										id_sessao: id_sessao
									};
									gridCapacidades.getStore().load();
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
			});
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    }
});
