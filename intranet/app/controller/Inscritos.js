Ext.define('Seic.controller.Inscritos', {
    extend: 'Ext.app.Controller',
    stores: [
		'Inscritos.Inscritos',
		'Inscritos.TipoInscritos',
		'Inscritos.EventoInscritos',
		'Inscritos.InstituicaoInscrito',
		'Inscritos.DepartamentoInscrito',
		'Inscritos.CursoInscrito',
		'Inscritos.Cidades',
		'Inscritos.MiniCursosInscrito',
		'Inscritos.Estados',
		'Inscritos.BoletosInscrito',
		'Inscritos.Area',
	],
    models: [
		'Inscritos.Inscrito',
		'Inscritos.TipoInscrito',
		'Inscritos.MiniCursosInscrito',
		'Inscritos.EventoInscrito',
		'Inscritos.InstituicaoInscrito',
		'Inscritos.DepartamentoInscrito',
		'Inscritos.CursoInscrito',
		'Inscritos.Cidade',
		'Inscritos.Estado',
		'Inscritos.BoletoInscrito',
	],
    views: [
		'Inscritos.gridInscritos',
		'Inscritos.formBuscaAvancada',
		'Inscritos.formMensagemEmail'
	],

    init: function() {
		// console.log('Controller Inscritos carregado');
		Ext.create('Seic.store.Inscritos.Inscritos');
		Ext.create('Seic.store.Inscritos.TipoInscritos');
		Ext.create('Seic.store.Inscritos.EventoInscritos');
		Ext.create('Seic.store.Inscritos.InstituicaoInscrito');
		Ext.create('Seic.store.Inscritos.DepartamentoInscrito');
		Ext.create('Seic.store.Inscritos.CursoInscrito');
		Ext.create('Seic.store.Inscritos.Cidades');
		Ext.create('Seic.store.Inscritos.Estados');
		Ext.create('Seic.store.Inscritos.MiniCursosInscrito');
		Ext.create('Seic.store.Inscritos.BoletosInscrito');
		Ext.create('Seic.store.Inscritos.Area');
		this.control({
			'modinscritos_gridinscritos button#btnAdicionarInscrito': {
            	click: this.adicionarInscrito
            },
			'modinscritos_gridinscritos dataview': {
            	itemdblclick: this.editarInscritoGrid,
				itemclick: this.renomearBtnAtivarInscrito
            },
			'modinscritos_gridinscritos button#btnBuscaAvancada': {
            	click: this.buscaAvancada
            },
			'modinscritos_gridinscritos button#btnEditarInscrito': {
            	click: this.editarInscrito
            },
			'modinscritos_gridinscritos button#modinscritos_btnAtivarInscrito': {
            	click: this.ativarInscrito
            },
			'modinscritos_gridinscritos button#btnApagarInscrito': {
            	click: this.apagarInscrito
            },
			// 'modinscritos_formcadinscritos button#btnGerarBoleto': {
   //          	click: this.gerarBoleto
   //          },
			// 'modinscritos_formcadinscritos button#btnCancelarBoleto': {
   //          	click: this.cancelarBoleto
   //          },
			'modinscritos_formcadinscritos button#btnSalvarInscrito': {
            	click: this.salvarInscrito
            },
			'modinscritos_gridinscritos button#modinscritos_btnLogarComo': {
            	click: this.logarComo
            },
			'modinscritos_formcadinscritos button#modinscritos_btnAlterarSenha': {
            	click: this.alterarSenha
            },
			'modinscritos_formbuscaavancada button#btnBuscarInscrito': {
            	click: this.buscarInscrito
            },
			'modinscritos_gridinscritos button#modinscritos_btnLimparBusca': {
            	click: this.limparBuscaAvancada
            },

            'modinscritos_gridinscritos button#btnPrintEtiquetas': {
            	click: this.printEtiquetas
            },
            
			'modinscritos_gridinscritos menuitem#itemMensagemEmail': {
				click: this.mensagemEmail
            },
			'modinscritos_formMensagemEmail button#btnEnviarEmail': {
				click: this.enviarEmail
			},
            'modinscritos_gridinscritos button#btnExport':{
				click: this.exportarExcel
			},
		});
    },

    printEtiquetas: function(btn){
    	grid = Ext.getCmp('modinscritos_gridInscritos');
		store = grid.getStore();
		if(store.filters.items.length) //verifica se tem busca rapida
			buscaRapida = store.filters.items[0].value;
		else
			buscaRapida = "";
		
    	Ext.Msg.show({
			title:   'Confirmação',
			msg:   'Deseja visualizar os dados para impressão?',
			icon:   Ext.MessageBox.QUESTION,
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					window.open("Server/inscritos/etiquetas.php?buscaRapida="+buscaRapida
						+"&cpf="+store.proxy.extraParams.cpf
						+"&fgk_tipo="+store.proxy.extraParams.fgk_tipo
						+"&fgk_instituicao="+store.proxy.extraParams.fgk_instituicao
						+"&fgk_departamento="+store.proxy.extraParams.fgk_departamento
						+"&departamento="+store.proxy.extraParams.departamento
						+"&fgk_curso="+store.proxy.extraParams.fgk_curso
						+"&mobilidade_ano_passado="+store.proxy.extraParams.mobilidade_ano_passado
						+"&bool_monitoria="+store.proxy.extraParams.bool_monitoria
						+"&bool_temp="+store.proxy.extraParams.bool_temp
						+"&conta_ativada="+store.proxy.extraParams.conta_ativada
						+"&bool_coordenador="+store.proxy.extraParams.bool_coordenador
						+"&bool_revisor="+store.proxy.extraParams.bool_revisor);
				}
			}
		});
    },

    exportarExcel: function(button){
        var store = button.up('window').down('#modinscritos_gridInscritos').getStore();

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
                    window.open("Server/inscritos/exportarExcel.php?filtro="+buscaRapida
                        +"&pa="+store.proxy.extraParams.pa
                        +"&cpf="+store.proxy.extraParams.cpf
                        +"&cpf="+store.proxy.extraParams.cpf
                        +"&fgk_tipo="+store.proxy.extraParams.fgk_tipo
                        +"&fgk_instituicao="+store.proxy.extraParams.fgk_instituicao
                        +"&fgk_departamento="+store.proxy.extraParams.fgk_departamento
                        +"&departamento="+store.proxy.extraParams.departamento
                        +"&fgk_curso="+store.proxy.extraParams.fgk_curso
                        +"&curso="+store.proxy.extraParams.curso
                        +"&mobilidade_ano_passado="+store.proxy.extraParams.mobilidade_ano_passado
                        +"&bool_monitoria="+store.proxy.extraParams.bool_monitoria
                        +"&bool_temp="+store.proxy.extraParams.bool_temp
                        +"&conta_ativada="+store.proxy.extraParams.conta_ativada
                        +"&bool_coordenador="+store.proxy.extraParams.bool_coordenador
                        +"&bool_revisor="+store.proxy.extraParams.bool_revisor
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
			grid = Ext.getCmp('modinscritos_gridInscritos');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/inscritos/checaremails.php',
				params: {
					buscaRapida				: buscaR,
					id_inscrito				: Ext.getCmp('modinscritos_id_inscrito_email').getValue(),
					radio					: form.getForm().findField('inscrito').getValue(),
					pa						: store.proxy.extraParams.pa,
					cpf						: store.proxy.extraParams.cpf,
					fgk_tipo				: store.proxy.extraParams.fgk_tipo,
					fgk_instituicao			: store.proxy.extraParams.fgk_instituicao,
					fgk_departamento		: store.proxy.extraParams.fgk_departamento,
					departamento			: store.proxy.extraParams.departamento,
					fgk_curso				: store.proxy.extraParams.fgk_curso,
					curso					: store.proxy.extraParams.curso,
					mobilidade_ano_passado	: store.proxy.extraParams.mobilidade_ano_passado,
					bool_monitoria			: store.proxy.extraParams.bool_monitoria,
					bool_temp				: store.proxy.extraParams.bool_temp,
					conta_ativada			: store.proxy.extraParams.conta_ativada,
					bool_coordenador		: store.proxy.extraParams.bool_coordenador,
					bool_revisor			: store.proxy.extraParams.bool_revisor
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
									url: 'Server/inscritos/enviarEmail.php',
									params : {
										buscaRapida				: buscaR,
										pa						: store.proxy.extraParams.pa,
										cpf						: store.proxy.extraParams.cpf,
										fgk_tipo				: store.proxy.extraParams.fgk_tipo,
										fgk_instituicao			: store.proxy.extraParams.fgk_instituicao,
										fgk_departamento		: store.proxy.extraParams.fgk_departamento,
										departamento			: store.proxy.extraParams.departamento,
										fgk_curso				: store.proxy.extraParams.fgk_curso,
										curso					: store.proxy.extraParams.curso,
										mobilidade_ano_passado	: store.proxy.extraParams.mobilidade_ano_passado,
										bool_monitoria			: store.proxy.extraParams.bool_monitoria,
										bool_temp				: store.proxy.extraParams.bool_temp,
										conta_ativada			: store.proxy.extraParams.conta_ativada,
										bool_coordenador		: store.proxy.extraParams.bool_coordenador,
										bool_revisor			: store.proxy.extraParams.bool_revisor
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
		var win = Ext.create('Seic.view.Inscritos.formMensagemEmail').show();
		grid = Ext.getCmp('modinscritos_gridInscritos');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modinscritos_id_inscrito_email').setValue(grid.getSelectionModel().getSelection()[0].data.id);
		}
		else{
			Ext.getCmp('modinscritos_radioSelecionado').disable();
			Ext.getCmp('modinscritos_id_inscrito_email').setValue(0);
		}
	},
	logarComo: function(button){
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			if(row.data.bool_temp == 1){
				Ext.Msg.alert({
					title: 'Atenção',
					msg: 'Este inscrito ainda possui um cadastro temporário e não pode acessar a área restrita.',
					buttons: Ext.Msg.OK
				});
			}
			else{
				Ext.Msg.show({
					title:   'Confirmação',
					msg:     'Deseja acessar a área restrita como o inscrito: <b>'+row.data.nome+'<b> ?',
					buttons: Ext.Msg.YESNO,
					fn: function(button){
						if(button=="yes"){
							var mapForm = document.createElement("form");
							mapForm.target = "_blank";
							mapForm.method = "POST";
							mapForm.action = "Server/inscritos/loginAreaRestrita.php";

							var mapInput = document.createElement("input");
							mapInput.name = "data";
							mapInput.value = JSON.stringify(row.data);

							mapForm.appendChild(mapInput);
							document.body.appendChild(mapForm);
							mapForm.submit();

						}
						else { 	}
					},
					animEl: 'elId',
					icon:   Ext.MessageBox.QUESTION
				});
			}

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um inscrito.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	ativarInscrito: function(button) {
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			if(records.data.conta_ativada == '1')
				mensagem = 'Deseja bloquear o inscrito: <b>'+records.data.nome+'</b> ?';
			else
				mensagem = 'Deseja liberar o usuário: <b>'+records.data.nome+'</b> ?';
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     mensagem,
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/inscritos/ativarInscrito.php',
							params: {	id_inscrito: records.data.id, conta_ativada: records.data.conta_ativada	},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso', Ext.JSON.decode(res.responseText).msg);
									store.load();
								}
								else{
									Ext.Msg.alert('Falha', 'Erro 0001. Favor entrar em contato com o administrador do sistema.');
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
			    msg: 'Selecione um inscrito para liberar/bloquear.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	buscarInscrito: function(button) {
		var win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();
		var gridInscritos = Ext.getCmp('modinscritos_gridInscritos');
		gridInscritos.getStore().getProxy().extraParams = {
			pa						: '1',
			cpf						: values.cpf,
			fgk_tipo				: values.fgk_tipo,
			fgk_instituicao			: values.fgk_instituicao,
			fgk_departamento		: values.fgk_departamento,
			departamento			: values.departamento,
			fgk_curso				: values.fgk_curso,
			curso					: values.curso,
			mobilidade_ano_passado	: values.mobilidade_ano_passado,
			bool_monitoria			: values.bool_monitoria,
			bool_temp				: values.bool_temp,
			conta_ativada			: values.conta_ativada,
			bool_coordenador		: values.bool_coordenador,
			bool_revisor			: values.bool_revisor,
		};
		// console.log(values.fgk_instituicao);
		gridInscritos.getStore().load();
		// console.log(values);
		Ext.getCmp("modinscritos_toolBarPA").removeAll();
		Ext.getCmp("modinscritos_toolBarPA").show();
		Ext.getCmp("modinscritos_toolBarPA").add(
			{	xtype: 'label',
				text: 'Listando apenas: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.cpf!=""){
			texto = "CPF: "+values.cpf;
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_tipo!=""){
			texto = "Tipo: "+Ext.getCmp('modinscritos_comboTipoInscrito-PA').getRawValue();
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}

		if(values.fgk_instituicao!=""){
			var data = Ext.getCmp('modinscritos_comboInstituicaoInscrito-PA').findRecordByValue(Ext.getCmp('modinscritos_comboInstituicaoInscrito-PA').getValue()).data;
			texto = "Instituição: "+data.sigla;
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_departamento!=""){
			texto = "Combo Departamento: "+Ext.getCmp('modinscritos_comboDepartamentoInscrito-PA').getRawValue();
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.departamento!=""){
			texto = "Text Departamento: "+values.departamento;
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.fgk_curso!=""){
			texto = "Combo Curso: "+Ext.getCmp('modinscritos_comboCursoInscrito-PA').getRawValue();;
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.curso!=""){
			texto = "Text Curso: "+values.curso;
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.mobilidade_ano_passado=="1"){
			texto = "CAINT";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.bool_monitoria=="1"){
			texto = "Monitoria";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.bool_temp=="1"){
			texto = "Pré cadastro";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.conta_ativada=="1"){
			texto = "Conta ativa";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.bool_coordenador=="1"){
			texto = "Coordenadores";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}
		if(values.bool_revisor=="1"){
			texto = "Revisores";
			Ext.getCmp("modinscritos_toolBarPA").add({xtype:'button',text: texto});
		}

		Ext.getCmp("modinscritos_toolBarPA").add('->');
		Ext.getCmp("modinscritos_toolBarPA").add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modinscritos_btnLimparBusca'
			}
		);
		win.hide();
    },
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modinscritos_toolBarPA').hide();
		Ext.getCmp('modinscritos_formBuscaAvancada').close();
		var gridInscritos = Ext.getCmp('modinscritos_gridInscritos');
		gridInscritos.getStore().getProxy().extraParams = {};
		gridInscritos.getStore().load();
    },
	buscaAvancada: function(button) {
		var win = Ext.getCmp('modinscritos_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Inscritos.formBuscaAvancada');
		else
			win.show();
		// Ext.getCmp('modProt_combotipoproocolo-busca').getStore().load();
    },
	adicionarInscrito: function(button) {
		var win = Ext.create('Seic.view.Inscritos.formCadInscritos').show();
		win.setTitle('Adicionar inscrito');
		Ext.getCmp('modinscritos_comboTipoInscrito').getStore().load();
		Ext.getCmp('modinscritos_comboInstituicaoInscrito').getStore().load();
		Ext.getCmp('modinscritos_comboEstados').getStore().load();
    },
	renomearBtnAtivarInscrito: function(grid, rowIndex){
		Ext.getCmp('modinscritos_btnLogarComo').enable();
		var records = grid.getSelectionModel().getSelection()[0];
		var botao = Ext.getCmp('modinscritos_btnAtivarInscrito');
		if(records.data.conta_ativada == '1'){
			botao.setText('Desativar conta');
			botao.setIconCls('icon-lock');
		}
		else{
			botao.setText('Ativar conta');
			botao.setIconCls('icon-unlock');
		}
	},
	apagarInscrito: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			if(row.data.bool_inscricao_paga){
				Ext.Msg.alert({
					title: 'Atenção',
					msg: 'Este inscrito já está com a inscrição paga. Não é possível removê-lo.',
					buttons: Ext.Msg.OK
				});
			}
			else{
				Ext.Msg.show({
					title:   'Atenção!',
					msg:     'Deseja realmente apagar o inscrito: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
					buttons: Ext.Msg.YESNO,
					fn: function(button){
						if(button=="yes"){
							Ext.Ajax.request({
								waitMsg: 'Aguarde...',
								url: 'Server/inscritos/apagarInscritos.php',
								params: {	id_inscrito: row.data.id	},
								disableCaching: false ,
								success: function (res) {
									if(Ext.JSON.decode(res.responseText).success){
										Ext.Msg.alert('Sucesso','Inscrito apagado com sucesso.');
										grid.getStore().load();
									}
									else{
										Ext.Msg.alert({
											title: 'Falha',
											msg:  Ext.JSON.decode(res.responseText).msg,
											buttons: Ext.Msg.OK,
											icon:   Ext.MessageBox.ERROR
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
			}
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um inscrito para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	// gerarBoleto: function(button) {
	// 	var grid = Ext.getCmp('modinscritos_gridInscritos');
	// 	var row = grid.getSelectionModel().getSelection()[0];
	// 	Ext.Msg.show({
	// 		title:   'Atenção!',
	// 		msg:     'Deseja gerar um novo boleto para: <b>'+row.data.nome+'</b>?',
	// 		buttons: Ext.Msg.YESNO,
	// 		fn: function(button){
	// 			if(button=="yes"){
	// 				var box = Ext.MessageBox.wait('Por favor aguarde enquanto o boleto está sendo gerado.', 'Aguarde');
	// 				Ext.Ajax.request({
	// 					waitMsg: 'Aguarde...',
	// 					url: 'Server/inscritos/gerarBoleto.php',
	// 					params: {
	// 						id_inscrito	: row.data.id,
	// 						nome		: row.data.nome,
	// 						tipo		: row.data.fgk_tipo,
	// 						cpf			: row.data.cpf,
	// 						celular		: row.data.telefone_celular,
	// 						email		: row.data.email
	// 					},
	// 					disableCaching: false ,
	// 					success: function (res) {
	// 						if(Ext.JSON.decode(res.responseText).success){
	// 							box.hide();
	// 							Ext.Msg.alert('Sucesso','Boleto gerado com sucesso.');
	// 							Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().load();
	// 						}
	// 						else{
	// 							box.hide();
	// 							Ext.Msg.alert({
	// 								title: 'Falha',
	// 								msg:  Ext.JSON.decode(res.responseText).msg,
	// 								buttons: Ext.Msg.OK,
	// 								icon:   Ext.MessageBox.ERROR
	// 							});
	// 						}
	// 					}
	// 				});
	// 			}
	// 			else {	}
	// 		},
	// 		animEl: 'elId',
	// 		icon:   Ext.MessageBox.QUESTION
	// 	});
 //    },
	// cancelarBoleto: function(button) {
	// 	var grid = Ext.getCmp('modinscritos_gridBoletosInscrito');
	// 	if(grid.getSelectionModel().hasSelection()){
	// 		var row = grid.getSelectionModel().getSelection()[0];
	// 		if(row.data.status == 0){
	// 			Ext.Msg.show({
	// 				title:   'Atenção!',
	// 				msg:     'Deseja realmente cancelar o boleto selecionado?',
	// 				buttons: Ext.Msg.YESNO,
	// 				fn: function(button){
	// 					if(button=="yes"){
	// 						var box = Ext.MessageBox.wait('Por favor aguarde enquanto o boleto está sendo cancelado.', 'Aguarde');
	// 						Ext.Ajax.request({
	// 							waitMsg: 'Aguarde...',
	// 							url: 'Server/inscritos/cancelarBoleto.php',
	// 							params: {
	// 								id_boleto	: row.data.id_boleto,
	// 								chave		: row.data.chave
	// 							},
	// 							disableCaching: false ,
	// 							success: function (res) {
	// 								if(Ext.JSON.decode(res.responseText).success){
	// 									box.hide();
	// 									Ext.Msg.alert('Sucesso','Boleto cancelado com sucesso.');
	// 									Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().load();
	// 								}
	// 								else{
	// 									box.hide();
	// 									Ext.Msg.alert({
	// 										title: 'Falha',
	// 										msg:  Ext.JSON.decode(res.responseText).msg,
	// 										buttons: Ext.Msg.OK,
	// 										icon:   Ext.MessageBox.ERROR
	// 									});
	// 								}
	// 							}
	// 						});
	// 					}
	// 					else {	}
	// 				},
	// 				animEl: 'elId',
	// 				icon:   Ext.MessageBox.QUESTION
	// 			});
	// 		}
	// 		else{
	// 			if(row.data.status == 1)
	// 				mensagem = "Este boleto já está vencido e não pode ser cancelado.";
	// 			else if(row.data.status == 2)
	// 				mensagem = "Este boleto já foi pago e não pode cancelado.";
	// 			else if(row.data.status == 3)
	// 				mensagem = "Este boleto já foi cancelado anteriormente.";
	// 			Ext.Msg.alert({
	// 				title: 'Atenção',
	// 				msg: mensagem,
	// 				buttons: Ext.Msg.OK
	// 			});
	// 		}
	// 	}
	// 	else{
	// 		Ext.Msg.alert({
	// 		    title: 'Atenção',
	// 		    msg: 'Selecione um boleto para concelar.',
	// 		    buttons: Ext.Msg.OK
	// 		});
	// 	}
 //    },
	editarInscritoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Inscritos.formCadInscritos').show();
		Ext.getCmp('modinscritos_comboTipoInscrito').getStore().load();
		comboInstituicao	= Ext.getCmp('modinscritos_comboInstituicaoInscrito');
		comboCurso	 		= Ext.getCmp('modinscritos_comboCursoInscrito');
		comboDepartamento 	= Ext.getCmp('modinscritos_comboDepartamentoInscrito');
		textDepartamento	= Ext.getCmp('modinscritos_textDepartamentoInscrito');
		textCurso			= Ext.getCmp('modinscritos_textCursoInscrito');
		comboInstituicao.getStore().load({
			callback: function(combo){
				if(comboInstituicao.getValue() == 1 ){
					textDepartamento.hide();
					textDepartamento.disable();
					textCurso.hide();
					textCurso.disable();
					comboDepartamento.enable();
					comboDepartamento.show();
					comboCurso.enable();
					comboCurso.show();
					comboDepartamento.getStore().load();
					comboDepartamento.setValue(row.data.fgk_departamento);
					comboCurso.getStore().getProxy().extraParams = {
						id_departamento	: row.data.fgk_departamento
					};
					comboCurso.getStore().load();
					comboCurso.setValue(row.data.fgk_curso);
				}
				else{
					comboDepartamento.hide();
					comboDepartamento.disable();
					comboCurso.hide();
					comboCurso.disable();
					textDepartamento.show();
					textDepartamento.enable();
					textCurso.show();
					textCurso.enable();
				}
			}
		});
		comboEstado = Ext.getCmp('modinscritos_comboEstados');
		comboEstado.getStore().load();
		comboCidade 	= Ext.getCmp('modinscritos_comboCidades');
		comboCidade.getStore().getProxy().extraParams = {
			id_estado	: row.data.id_estado
		};
		comboCidade.getStore().load();
		win.setTitle('Editar inscrito');
		win.down('form').loadRecord(row);
		if(row.data.bool_coordenador < 1)
			Ext.getCmp('modinscritos_comboAreaCoordenacao').setValue();
		Ext.getCmp('modinscritos_cpfInscrito').setReadOnly(true);
		// Ext.getCmp('modinscritos_gridBoletosInscrito').enable();
		// Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().getProxy().extraParams = {
		// 	id_inscrito	: row.data.id
		// };
		// Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().load();
		Ext.getCmp('modinscritos_btnAlterarSenha').show();
		Ext.getCmp('modinscritos_gridMiniCursos').enable();
    },
	editarInscrito: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Inscritos.formCadInscritos').show();
			Ext.getCmp('modinscritos_comboTipoInscrito').getStore().load();
			comboInstituicao = Ext.getCmp('modinscritos_comboInstituicaoInscrito');
			comboCurso	 	= Ext.getCmp('modinscritos_comboCursoInscrito');
			comboDepartamento 	= Ext.getCmp('modinscritos_comboDepartamentoInscrito');
			textDepartamento	= Ext.getCmp('modinscritos_textDepartamentoInscrito');
			textCurso	= Ext.getCmp('modinscritos_textCursoInscrito');
			comboInstituicao.getStore().load({
				callback: function(combo){
					if(comboInstituicao.getValue() == 1 ){
						textDepartamento.hide();
						textDepartamento.disable();
						textCurso.hide();
						textCurso.disable();
						comboDepartamento.enable();
						comboDepartamento.show();
						comboCurso.enable();
						comboCurso.show();
						comboDepartamento.getStore().load();
						comboDepartamento.setValue(row.data.fgk_departamento);
						comboCurso.getStore().getProxy().extraParams = {
							id_departamento	: row.data.fgk_departamento
						};
						comboCurso.getStore().load();
						comboCurso.setValue(row.data.fgk_curso);
					}
					else{
						comboDepartamento.hide();
						comboDepartamento.disable();
						comboCurso.hide();
						comboCurso.disable();
						textDepartamento.show();
						textDepartamento.enable();
						textCurso.show();
						textCurso.enable();
					}

				}
			});
			comboEstado = Ext.getCmp('modinscritos_comboEstados');
			comboEstado.getStore().load();
			comboCidade 	= Ext.getCmp('modinscritos_comboCidades');
			comboCidade.getStore().getProxy().extraParams = {
				id_estado	: row.data.id_estado
			};
			comboCidade.getStore().load();
			win.setTitle('Editar inscrito');
			win.down('form').loadRecord(row);
			if(row.data.bool_coordenador < 1)
				Ext.getCmp('modinscritos_comboAreaCoordenacao').setValue();
			Ext.getCmp('modinscritos_cpfInscrito').setReadOnly(true);
			// Ext.getCmp('modinscritos_gridBoletosInscrito').enable();
			// Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().getProxy().extraParams = {
			// 	id_inscrito	: row.data.id
			// };
			// Ext.getCmp('modinscritos_gridBoletosInscrito').getStore().load();
			Ext.getCmp('modinscritos_btnAlterarSenha').show();
			Ext.getCmp('modinscritos_gridMiniCursos').enable();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarInscrito: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modinscritos_gridInscritos');
			var store = grid.getStore();
			if (record){
				//Editar inscrito
				form.submit({
					url: 'Server/inscritos/atualizarInscritos.php',
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
			else {
				//adicionar inscrito
				var win_senha = new Ext.window.Window({
					title : 'Definir senha',
					layout: 'fit',
					autoShow: true,
					width: 350,
					autoHeight: true,
					modal: true,
					items:[
						{   xtype: 'form',
							padding: '5 5 5 5',
							border: false,
							items: [
								{	xtype: 'textfield',
									inputType: 'password',
									allowBlank: false,
									name: 'password',
									id: 'modinscritos_passwordInscrito',
									itemId : 'password',
									fieldLabel: 'Senha',
									labelWidth: 80,
									anchor: '100%',
									listeners: {
										validitychange: function(field){
											field.next().validate();
										},
										blur: function(field){
											field.next().validate();
										}
									}
								},
								{	xtype: 'textfield',
									labelWidth: 80,
									anchor: '100%',
									inputType: 'password',
									allowBlank: false,
									fieldLabel: 'Conf. Senha',
									vtype: 'password',
									initialPassField: 'password'
								}
							]
						}
					],
					fbar: [
						'->',
						{	iconCls: 'icon-save',
							text: 'Salvar',
							scope: this,
							handler: function(button){
								form_senha = win_senha.down('form');
								if(form_senha.isValid()) {
									valuesInscrito = form.getValues(false,false,false,true);
									valuesInscrito.password = stringToHex(des("seic2015", Ext.getCmp('modinscritos_passwordInscrito').getValue(), 1));
									var inscrito = Ext.create('Seic.model.Inscritos.Inscrito',valuesInscrito);
									store.add(inscrito);
									store.sync({
										async: false,
										success: function(response, options){
											data = response.proxy.getReader().jsonData;
											if(data.success){
												Ext.Msg.alert({
													title: 'Sucesso',
													msg: data.msg,
													buttons: Ext.Msg.OK,
													fn: function(button){
														win_senha.close();
														win.close();
													}
												});
											}
										},
										failure: function(batch, options) {
											Ext.Msg.alert({
												title: 'Falha',
												msg: batch.proxy.getReader().jsonData.msg,
												buttons: Ext.Msg.OK
											});
										}
									});
								}
								else{
									Ext.Msg.alert({
										title: 'Falha',
										msg: 'Favor conferir todos os campos.',
										buttons: Ext.Msg.OK
									});
								}
							}
						},
						{	iconCls: 'icon-cancel',
							text: 'Fechar',
							scope: this,
							handler: function(){
								win_senha.close();
							}
						}
					]
				});
				return win_senha;
			}
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	alterarSenha: function(){
		var win_senha = new Ext.window.Window({
		title : 'Definir senha',
		layout: 'fit',
		autoShow: true,
		width: 350,
		autoHeight: true,
		modal: true,
		items:[
			{   xtype: 'form',
				padding: '5 5 5 5',
				border: false,
				fieldDefaults: {
                    anchor: '100%',
					labelWidth: 80,
					msgTarget: 'side'
                },
				items: [
					{	xtype: 'textfield',
						inputType: 'password',
						msgTarget: 'side',
						allowBlank: false,
						name: 'password',
						id: 'modinscritos_passwordInscrito',
						itemId : 'password',
						fieldLabel: 'Senha',
						listeners: {
							validitychange: function(field){
								field.next().validate();
							},
							blur: function(field){
								field.next().validate();
							}
						}
					},
					{	xtype: 'textfield',
						inputType: 'password',
						allowBlank: false,
						fieldLabel: 'Conf. Senha',
						vtype: 'password',
						initialPassField: 'password'
					}
				]
			}
		],
		fbar: [
			'->',
			{	iconCls: 'icon-save',
				text: 'Salvar',
				scope: this,
				handler: function(button){
					form_senha = win_senha.down('form');
					if(form_senha.isValid()) {
						var row = Ext.getCmp('modinscritos_gridInscritos').getSelectionModel().getSelection()[0];
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/inscritos/atualizarSenha.php',
							params: {
								id_inscrito: row.data.id,
								cpf: row.data.cpf,
								password: stringToHex(des("seic2015", Ext.getCmp('modinscritos_passwordInscrito').getValue(), 1))
							},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso','Senha atualizada com sucesso.');
									win_senha.close();
								}
								else{
									Ext.Msg.alert({
										title: 'Falha',
										msg:  Ext.JSON.decode(res.responseText).msg,
										buttons: Ext.Msg.OK,
										icon:   Ext.MessageBox.ERROR
									});
								}
							}
						});
					}
					else{
						Ext.Msg.alert({
							title: 'Falha',
							msg: 'Favor conferir todos os campos.',
							buttons: Ext.Msg.OK
						});
					}
				}
			},
			{	iconCls: 'icon-cancel',
				text: 'Fechar',
				scope: this,
				handler: function(){
					win_senha.close();
				}
			}
		]
	});
	return win_senha;
	}
});
