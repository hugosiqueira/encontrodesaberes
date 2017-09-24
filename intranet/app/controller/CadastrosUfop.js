Ext.define('Seic.controller.CadastrosUfop', {
    extend: 'Ext.app.Controller',
    stores: [
		'CadastrosUfop.ProfessoresTA',
		'CadastrosUfop.DepartamentosProfessoresTA',
		'CadastrosUfop.CursosAluno',
		'CadastrosUfop.Cursos',
		'CadastrosUfop.Departamentos',
		'CadastrosUfop.AreasDepartamento',
		'CadastrosUfop.Alunos',
		'CadastrosUfop.Areas',
		'CadastrosUfop.AreasEspecificas',
		'CadastrosUfop.AreasEspecificasCursos'
	],
    views: [
		'CadastrosUfop.tabCadastrosUfop',
		'CadastrosUfop.gridProfessoresTA',
		'CadastrosUfop.gridDepartamentos',
		'CadastrosUfop.gridAreas',
		'CadastrosUfop.gridCursos',
		'CadastrosUfop.gridAlunos',
		'CadastrosUfop.gridAreasEspecificas',
		'CadastrosUfop.formCadProfessoresTA',
		'CadastrosUfop.formCadCursos',
		'CadastrosUfop.formCadAlunos',
		'CadastrosUfop.formCadDepartamentos',
		'CadastrosUfop.formCadAreas',
		'CadastrosUfop.formEmailProfessor',
		'CadastrosUfop.formEmailAluno',
		'CadastrosUfop.formCadAreasEspecificas',
		'CadastrosUfop.formBuscaAvancadaAluno',
	],

    init: function() {
		// console.log('Controller CadastrosUfop carregado');
		Ext.create('Seic.store.CadastrosUfop.ProfessoresTA');
		Ext.create('Seic.store.CadastrosUfop.CursosAluno');
		Ext.create('Seic.store.CadastrosUfop.DepartamentosProfessoresTA');
		Ext.create('Seic.store.CadastrosUfop.AreasDepartamento');
		Ext.create('Seic.store.CadastrosUfop.Alunos');
		Ext.create('Seic.store.CadastrosUfop.Cursos');
		Ext.create('Seic.store.CadastrosUfop.Departamentos');
		Ext.create('Seic.store.CadastrosUfop.Areas');
		Ext.create('Seic.store.CadastrosUfop.AreasEspecificas');
		Ext.create('Seic.store.CadastrosUfop.AreasEspecificasCursos');
		this.control({
			'modcadufop_gridAlunos button#btnPesquisaAvancadaAluno': {
            	click: this.buscaAvancadaAluno
            },
			'modcadufop_formCadProfessoresTA textfield#modcadufop_cpfProfessorTA':{
				validitychange: this.buscaCpfProfessorTA
			},
			'modcadufop_formCadAlunos textfield#modcadufop_cpfAluno':{
				validitychange: this.buscaCpfAluno
			},
			'modcadufop_formCadCursos button#btnSalvarCurso':{
				click: this.salvarCurso
			},
			'modcadufop_formCadDepartamentos button#btnSalvarDepartamento':{
				click: this.salvarDepartamento
			},
			'modcadufop_formCadProfessoresTA button#btnSalvarProfessorTA':{
				click: this.salvarProfessorTA
			},
			'modcadufop_formCadAreas button#btnSalvarArea':{
				click: this.salvarArea
			},
			'modcadufop_formCadAreasEspecificas button#btnSalvarAreaEspecifica':{
				click: this.salvarAreaEspecifica
			},
			'modcadufop_formCadAlunos button#brnSalvarAluno':{
				click: this.salvarAluno
			},
			'modcadufop_gridCursos button#btnAdicionarCurso': {
                click: this.adicionarCurso
            },
			'modcadufop_gridDepartamentos button#btnAdicionarDepartamento': {
                click: this.adicionarDepartamento
            },
			'modcadufop_gridAreas button#btnEditarArea': {
                click: this.editarArea
            },
			'modcadufop_gridAreasEspecificas button#btnEditarAreaEspecifica': {
                click: this.editarAreaEspecifica
            },
			'modcadufop_gridAreasEspecificas dataview': {
                itemdblclick: this.editarAreaEspecificaGrid
            },
			'modcadufop_gridAreas dataview': {
                itemdblclick: this.editarAreaGrid
            },
			'modcadufop_gridDepartamentos button#btnEditarDepartamento': {
                click: this.editarDepartamento
            },
			'modcadufop_gridCursos button#btnEditarCurso': {
                click: this.editarCurso
            },
			'modcadufop_gridDepartamentos dataview': {
                itemdblclick: this.editarDepartamentoGrid
            },
			'modcadufop_gridCursos dataview': {
                itemdblclick: this.editarCursoGrid
            },
			'modcadufop_gridAreas button#btnApagarArea': {
                click: this.apagarArea
            },
			'modcadufop_gridAreasEspecificas button#btnApagarAreaEspecifica': {
                click: this.apagarAreaEspecifica
            },
			'modcadufop_gridDepartamentos button#btnApagarDepartamento': {
                click: this.apagarDepartamento
            },
			'modcadufop_gridCursos button#btnApagarCurso': {
                click: this.apagarCurso
            },
			'modcadufop_gridProfessoresTA button#btnAdicionarProfessorTA': {
                click: this.adicionarProfessorTA
            },
			'modcadufop_gridAreasEspecificas button#btnAdicionarAreaEspecifica': {
                click: this.adicionarAreaEspecifica
            },
			'modcadufop_gridAreas button#btnAdicionarArea': {
                click: this.adicionarArea
            },
			'modcadufop_gridAlunos button#btnAdicionarAluno': {
                click: this.adicionarAluno
            },
			'modcadufop_gridProfessoresTA button#btnEditarProfessorTA': {
            	click: this.editarProfessorTA
            },
			'modcadufop_gridAlunos button#btnEditarAluno': {
            	click: this.editarAluno
            },
			'modcadufop_gridAlunos dataview': {
            	itemdblclick: this.editarAlunoGrid
            },
			'modcadufop_gridProfessoresTA dataview': {
            	itemdblclick: this.editarProfessorTAGrid
            },
			'modcadufop_gridProfessoresTA button#btnApagarProfessorTA': {
            	click: this.apagarProfessorTA
            },
			'modcadufop_gridAlunos button#btnApagarAluno': {
            	click: this.apagarAluno
            },
			'modcadufop_gridAlunos menuitem#itemMensagemEmail': {
				click: this.mensagemEmailAluno
            },
			'modcadufop_gridProfessoresTA menuitem#itemMensagemEmail': {
				click: this.mensagemEmailProfessor
            },
			'modcadufop_formEmailProfessor button#btnEnviarEmail': {
				click: this.enviarEmailProfessor
            },
			'modcadufop_formEmailAluno button#btnEnviarEmail': {
				click: this.enviarEmailAluno
            },
			'modcadufop_formBuscaAvancadaAluno button#btnBuscarAluno': {
            	click: this.buscarAluno
            },			
			'modcadufop_gridAlunos button#modcadufop_btnLimparBuscaAluno': {
            	click: this.limparBuscaAvancadaAluno
            },
		});
    },	
	limparBuscaAvancadaAluno: function(button) {
		Ext.getCmp('modcadufop_toolBarAlunoPA').hide();
		Ext.getCmp('modcadufop_formBuscaAvancadaAluno').close();
		var gridAlunos = Ext.getCmp('modcadufop_gridAlunos');
		gridAlunos.getStore().getProxy().extraParams = {};
		gridAlunos.getStore().load();
    },
	buscarAluno: function(button) {
		var win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();
		var gridAlunos = Ext.getCmp('modcadufop_gridAlunos');
		gridAlunos.getStore().getProxy().extraParams = {
			pa						: '1',
			bool_monitoria			: values.bool_monitoria,
			mobilidade_ano_passado	: values.mobilidade_ano_passado,
			fgk_curso				: values.fgk_curso,
			mobilidade_ano_atual	: values.mobilidade_ano_atual
		};
		gridAlunos.getStore().loadPage(1);
		var toolBar = Ext.getCmp("modcadufop_toolBarAlunoPA");
		toolBar.removeAll();
		toolBar.show();
		toolBar.add(
			{	xtype: 'label',
				text: 'Filtros aplicados: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.fgk_curso!=""){
			texto = "Curso";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.bool_monitoria!="-1"){
			texto = "Seminário de monitoria";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.mobilidade_ano_atual!="-1"){
			texto = "Mobilidade este ano";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.mobilidade_ano_passado!="-1"){
			texto = "Mobilidade ano passdo";
			toolBar.add({xtype:'button',text: texto});
		}
		toolBar.add('->');
		toolBar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modcadufop_btnLimparBuscaAluno'
			}
		);
		win.hide();
    },
	buscaAvancadaAluno: function(button) {
		var win = Ext.getCmp('modcadufop_formBuscaAvancadaAluno');
		if (!win){
			Ext.create('Seic.view.CadastrosUfop.formBuscaAvancadaAluno');
			Ext.getCmp('modcadufop_comboCursoAluno-PA').getStore().load();
		}
		else
			win.show();
    },
	enviarEmailProfessor: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, contabilizando emails...',
			    target: win
			});
			myMask.show();
			grid = Ext.getCmp('modcadufop_gridProfessoresTA');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/cadastrosufop/checaremailProfessor.php',
				params: {
					buscaRapida				: buscaR,
					id_professor			:  Ext.getCmp('modcadufop_id_professor_email').getValue(),
					professor					:  Ext.getCmp('modcadufop_radioFiltrado').getValue()
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
									url: 'Server/cadastrosufop/enviarEmailProfessor.php',
									params : {
										buscaRapida				: buscaR
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
	enviarEmailAluno: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, contabilizando emails...',
			    target: win
			});
			myMask.show();
			grid = Ext.getCmp('modcadufop_gridAlunos');
			store = grid.getStore();
			if(store.filters.items.length) //verifica se tem busca rapida
				buscaR = store.filters.items[0].value;
			else
				buscaR = "";
			Ext.Ajax.request({
				url: 'Server/cadastrosufop/checaremailAluno.php',
				params: {
					buscaRapida				: buscaR,
					id_aluno				: Ext.getCmp('modcadufop_id_aluno_email').getValue(),
					aluno					: form.getForm().findField('aluno').getValue(),
					pa						: store.proxy.extraParams.pa,
					fgk_curso				: store.proxy.extraParams.fgk_curso,
					bool_monitoria			: store.proxy.extraParams.bool_monitoria,
					mobilidade_ano_atual	: store.proxy.extraParams.mobilidade_ano_atual,
					mobilidade_ano_passado	: store.proxy.extraParams.mobilidade_ano_passado
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
									url: 'Server/cadastrosufop/enviarEmailAluno.php',
									params : {
										buscaRapida				: buscaR,
										pa						: store.proxy.extraParams.pa,
										bool_monitoria			: store.proxy.extraParams.bool_monitoria,
										fgk_curso				: store.proxy.extraParams.fgk_curso,
										mobilidade_ano_atual	: store.proxy.extraParams.mobilidade_ano_atual,
										mobilidade_ano_passado	: store.proxy.extraParams.mobilidade_ano_passado
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
	mensagemEmailProfessor: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formEmailProfessor').show();
		grid = Ext.getCmp('modcadufop_gridProfessoresTA');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modcadufop_id_professor_email').setValue(grid.getSelectionModel().getSelection()[0].data.id_professor);
		}
		else{
			Ext.getCmp('modcadufop_radioProfessorSelecionado').disable();
			Ext.getCmp('modcadufop_id_professor_email').setValue(0);
		}
	},
	mensagemEmailAluno: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formEmailAluno').show();
		grid = Ext.getCmp('modcadufop_gridAlunos');
		if(grid.getSelectionModel().hasSelection()){
			Ext.getCmp('modcadufop_id_aluno_email').setValue(grid.getSelectionModel().getSelection()[0].data.id_aluno);
		}
		else{
			Ext.getCmp('modcadufop_radioAlunoSelecionado').disable();
			Ext.getCmp('modcadufop_id_aluno_email').setValue(0);
		}
	},
	salvarCurso: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadufop_gridCursos');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesCurso = form.getValues(false,false,false,true);
				curso = Ext.create('Seic.model.CadastrosUfop.Cursos',valuesCurso);
				store.add(curso);
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
	salvarArea: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadufop_gridAreas');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesAreas = form.getValues(false,false,false,true);
				area = Ext.create('Seic.model.CadastrosUfop.Areas',valuesAreas);
				store.add(area);
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
							store.load();
							win.close();
						}
					});
				},
				failure: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Erro',
						msg: data.msg,
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
	salvarAreaEspecifica: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadufop_gridAreasEspecificas');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesAreasEspecificacs = form.getValues(false,false,false,true);
				areaespecifica = Ext.create('Seic.model.CadastrosUfop.AreasEspecificas',valuesAreasEspecificacs);
				store.add(areaespecifica);
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
							store.load();
							win.close();
						}
					});
				},
				failure: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Erro',
						msg: data.msg,
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
	salvarDepartamento: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('modcadufop_gridDepartamentos');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesDepartamento = form.getValues(false,false,false,true);
				departamento = Ext.create('Seic.model.CadastrosUfop.Departamentos',valuesDepartamento);
				store.add(departamento);
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
							store.load();
							win.close();
						}
					});
				},
				failure: function(response, options){
					data = response.proxy.getReader().jsonData;
					Ext.Msg.show({
						title:'Erro',
						msg: data.msg,
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
	apagarArea: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar a área: <b>'+row.data.descricao_area+'</b>?<br>Esta ação não pode ser revertida.',
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
    },
	apagarAreaEspecifica: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar a área específica: <b>'+row.data.descricao_area_especifica+'</b>?<br>Esta ação não pode ser revertida.',
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
    },
	apagarDepartamento: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o departamento: <b>'+row.data.nome_departamento+'</b>?<br>Esta ação não pode ser revertida.',
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
    },
	apagarCurso: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o curso: <b>'+row.data.descricao_curso+'</b>?<br>Esta ação não pode ser revertida.',
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
    },
	apagarAluno: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o aluno: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/cadastrosufop/apagarAluno.php',
							params: {	id_aluno: row.data.id_aluno	},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso','Aluno apagado com sucesso.');
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
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarProfessorTA: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o professor/TA: <b>'+row.data.nome+'</b>?<br>Esta ação não pode ser revertida.',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/cadastrosufop/apagarProfessorTA.php',
							params: {	id_professor: row.data.id_professor	},
							disableCaching: false ,
							success: function (res) {
								if(Ext.JSON.decode(res.responseText).success){
									Ext.Msg.alert('Sucesso','Professor/TA apagado com sucesso.');
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
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarAlunoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAlunos').show();
		Ext.getCmp('modcadufop_comboCursoAluno').getStore().load();
		win.setTitle('Editar aluno');
		win.down('form').loadRecord(row);
	},
	editarProfessorTAGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadProfessoresTA').show();
		Ext.getCmp('modcadufop_comboDepartamentoProfessorTA').getStore().load();

		win.setTitle('Editar Professor/TA');
		win.down('form').loadRecord(row);
	},
	editarAluno: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadAlunos').show();
			Ext.getCmp('modcadufop_comboCursoAluno').getStore().load();

			win.setTitle('Editar Professor/TA');
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
	editarArea: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadAreas').show();
			win.setTitle('Editar área');
			win.down('form').loadRecord(row);
			Ext.getCmp('modcadufop_textCodigoArea').setReadOnly(true);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarAreaEspecifica: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadAreasEspecificas').show();
			Ext.getCmp('modcadufop_comboAreasAreaEspecifica').getStore().load();
			win.setTitle('Editar área específica');
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
	editarDepartamento: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadDepartamentos').show();
			Ext.getCmp('modcadufop_comboAreasDepartamento').getStore().load();
			win.setTitle('Editar departamento');
			win.down('form').loadRecord(row);
			Ext.getCmp('modcadufop_textIdDepartamento').setReadOnly(true);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarCurso: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadCursos').show();
			Ext.getCmp('modcadufop_comboDepartamentosCurso').getStore().load();
			Ext.getCmp('modcadufop_comboAreasEspecificasCurso').getStore().load();
			win.setTitle('Editar curso');
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
	editarProfessorTA: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.CadastrosUfop.formCadProfessoresTA').show();
			Ext.getCmp('modcadufop_comboDepartamentoProfessorTA').getStore().load();

			win.setTitle('Editar Professor/TA');
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
	salvarProfessorTA: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			id_professor = form.getForm().findField('id_professor').getValue();
			var grid = Ext.getCmp('modcadufop_gridProfessoresTA');
			var store = grid.getStore();
			if (id_professor > 0){
				form.submit({
					url: 'Server/cadastrosufop/atualizarProfessoresTA.php',
					waitMsg: 'Atualizando registro...',
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
				form.submit({
					url: 'Server/cadastrosufop/criarProfessoresTA.php',
					waitMsg: 'Gravando registro...',
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
        }
        else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarAluno: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			id_aluno = form.getForm().findField('id_aluno').getValue();
			var grid = Ext.getCmp('modcadufop_gridAlunos');
			var store = grid.getStore();
			if (id_aluno > 0){
				form.submit({
					url: 'Server/cadastrosufop/atualizarAluno.php',
					waitMsg: 'Atualizando registro...',
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
				form.submit({
					url: 'Server/cadastrosufop/criarAluno.php',
					waitMsg: 'Gravando registro...',
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
        }
        else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarAreaGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAreas').show();
		win.setTitle('Editar área');
		win.down('form').loadRecord(row);
		Ext.getCmp('modcadufop_textCodigoArea').setReadOnly(true);
	},
	editarAreaEspecificaGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAreasEspecificas').show();
			Ext.getCmp('modcadufop_comboAreasAreaEspecifica').getStore().load();
			win.setTitle('Editar área específica');
			win.down('form').loadRecord(row);
	},
	editarDepartamentoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadDepartamentos').show();
		Ext.getCmp('modcadufop_comboAreasDepartamento').getStore().load();
		win.setTitle('Editar departamento');
		win.down('form').loadRecord(row);
		Ext.getCmp('modcadufop_textIdDepartamento').setReadOnly(true);
	},
	editarCursoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadCursos').show();
		Ext.getCmp('modcadufop_comboDepartamentosCurso').getStore().load();
		Ext.getCmp('modcadufop_comboAreasEspecificasCurso').getStore().load();

		win.setTitle('Editar curso');
		win.down('form').loadRecord(row);
	},
	adicionarDepartamento: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadDepartamentos').show();
		win.setTitle('Novo departamento');
		Ext.getCmp('modcadufop_comboAreasDepartamento').getStore().load();
	},
	adicionarCurso: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadCursos').show();
		win.setTitle('Novo curso');
		Ext.getCmp('modcadufop_comboAreasEspecificasCurso').getStore().load();
		Ext.getCmp('modcadufop_comboDepartamentosCurso').getStore().load();
	},
	adicionarProfessorTA: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadProfessoresTA').show();
		win.setTitle('Novo professor/TA');
		Ext.getCmp('modcadufop_comboDepartamentoProfessorTA').getStore().load();
	},
	adicionarArea: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAreas').show();
		win.setTitle('Nova área');
	},
	adicionarAreaEspecifica: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAreasEspecificas').show();
		win.setTitle('Nova área específica');
		Ext.getCmp('modcadufop_comboAreasAreaEspecifica').getStore().load();
	},
	adicionarAluno: function(button) {
		var win = Ext.create('Seic.view.CadastrosUfop.formCadAlunos').show();
		win.setTitle('Novo aluno');
		Ext.getCmp('modcadufop_comboCursoAluno').getStore().load();
	},
	buscaCpfProfessorTA: function(cpffield, isValid){
		if(isValid){
			form = Ext.getCmp('modcadufop_formCadProfessoresTA').down('form');
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, procurando professor...',
			    target: Ext.getCmp('modcadufop_camposCadProfessoresTA')
			});
			myMask.show();

    		Ext.Ajax.request({
			    url: 'Server/cadastrosufop/buscaCpfProfessorTA.php',
			    params: {
			        cpf: cpffield.getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();

			        if(result.success){

						form.getForm().findField('id_professor').setValue(result.id_professor);
						form.getForm().findField('cod_siape').setValue(result.cod_siape);
						form.getForm().findField('fgk_tipo').setValue(result.fgk_tipo);
						form.getForm().findField('fgk_departamento').setValue(result.fgk_departamento);
						form.getForm().findField('nome').setValue(result.nome);
						form.getForm().findField('email').setValue(result.email);
						form.getForm().findField('bool_avaliador').setValue(result.bool_avaliador);
						// form.getForm().findField('cursos').setValue(result.cursos);
						form.getForm().findField('bool_coordenador').setValue(result.bool_coordenador);
						form.getForm().findField('bool_monitoria').setValue(result.bool_monitoria);
						Ext.getCmp('modcadufop_camposCadProfessoresTA').enable();
						Ext.getCmp('modcadufop_siapeProfessorTA').enable();
			        }
					else{
						form.getForm().findField('id_professor').setValue(0);
						form.getForm().findField('cod_siape').setValue('');
						form.getForm().findField('fgk_tipo').setValue('');
						form.getForm().findField('fgk_departamento').setValue('');
						form.getForm().findField('nome').setValue('');
						form.getForm().findField('email').setValue('');
						form.getForm().findField('bool_avaliador').setValue('');
						// form.getForm().findField('cursos').setValue('');
						form.getForm().findField('bool_coordenador').setValue('');

						Ext.getCmp('modcadufop_camposCadProfessoresTA').enable();
						Ext.getCmp('modcadufop_siapeProfessorTA').enable();
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
			 // Ext.getCmp('modcadufop_formCadProfessoresTA').down('form').getForm().reset();
    	}
    },
	buscaCpfAluno: function(cpffield, isValid){
		if(isValid){
			form = Ext.getCmp('modcadufop_formCadAlunos').down('form');
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, procurando aluno...',
			    target: Ext.getCmp('modcadufop_camposCadAluno')
			});
			myMask.show();

    		Ext.Ajax.request({
			    url: 'Server/cadastrosufop/buscaCpfAlunos.php',
			    params: {
			        cpf: cpffield.getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();

			        if(result.success){

						form.getForm().findField('id_aluno').setValue(result.id_aluno);
						form.getForm().findField('matricula').setValue(result.matricula);
						form.getForm().findField('nome').setValue(result.nome);
						form.getForm().findField('email').setValue(result.email);
						form.getForm().findField('fgk_curso').setValue(result.fgk_curso);
						form.getForm().findField('bool_pos').setValue(result.bool_pos);
						form.getForm().findField('mobilidade_ano_passado').setValue(result.mobilidade_ano_passado);
						form.getForm().findField('mobilidade_ano_atual').setValue(result.mobilidade_ano_atual);
						form.getForm().findField('bool_monitoria').setValue(result.bool_monitoria);
						Ext.getCmp('modcadufop_matriculaAluno').enable();
						Ext.getCmp('modcadufop_posAluno').enable();
						Ext.getCmp('modcadufop_camposCadAluno').enable();
			        }
					else{
						form.getForm().findField('id_aluno').setValue(0);
						form.getForm().findField('matricula').setValue('');
						form.getForm().findField('nome').setValue('');
						form.getForm().findField('email').setValue('');
						form.getForm().findField('fgk_curso').setValue('');
						form.getForm().findField('bool_pos').setValue('');
						form.getForm().findField('mobilidade_ano_passado').setValue('');
						form.getForm().findField('mobilidade_ano_atual').setValue('');

						Ext.getCmp('modcadufop_matriculaAluno').enable();
						Ext.getCmp('modcadufop_posAluno').enable();
						Ext.getCmp('modcadufop_camposCadAluno').enable();
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

    	}
    },
});
