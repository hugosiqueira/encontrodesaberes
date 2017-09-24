Ext.define('Seic.controller.Projetos', {
    extend: 'Ext.app.Controller',
    stores: [ 
    	'Projetos.Projetos',
    	'Projetos.Area',
    	'Projetos.AreaSpec',
    	'Projetos.Departamento',    	
    	'Projetos.Programa_ic',
    	'Projetos.Orgao',
    	'Projetos.Categoria',
    	'Projetos.Orientador',
    	'Projetos.Aluno'
    ],

    models: [ 
    	'Projetos.Projetos',
    	'Projetos.Area',
    	'Projetos.AreaSpec',
    	'Projetos.Departamento',    	
    	'Projetos.Programa_ic',
    	'Projetos.Orgao',
    	'Projetos.Categoria',
    	'Projetos.Orientador',
    	'Projetos.Aluno'
    ],

    views: [
    	'Projetos.mainProjetos',
    	'Projetos.viewProjeto',
    	'Projetos.buscaProjeto',
    	'Projetos.buscaOrientador',
    	'Projetos.buscaAluno',
    ],

    init: function(){
		this.control({
			'modprojetos_mainprojetos':{
				afterrender: this.loadMainProjetos,
				itemclick: this.ativButtons,
				itemdblclick: this.editViewProject
				
			},

			'modprojetos_mainprojetos button#modprojetos_btnAddProjeto':{
				click: this.addProject
			},			

			'modprojetos_mainprojetos button#modprojetos_btnEditProjeto':{
				click: this.editViewProject
			},

			'modprojetos_mainprojetos button#modprojetos_btnDeletaProjeto':{
				click: this.deleteProject
			},

			'modprojetos_mainprojetos button#modprojetos_btnGerarTrabalho':{
				click: this.criaTrabalho
			},

			'modprojetos_viewprojeto button#modprojetos_btnCancelViewProjeto':{
				click: this.fechar
			},

			'modprojetos_viewprojeto button#modprojetos_btnCancelSalvaProjeto':{
				click: this.salvaProjeto
			},

			'modprojetos_viewprojeto textfield#modprojetos_cpfAluno':{
				validitychange: this.preencheAluno
			},

			'modprojetos_viewprojeto textfield#modprojetos_cpfOrientador':{
				validitychange: this.preencheOrientador
			},

			'modprojetos_viewprojeto combobox#modprojetos_viewComboArea':{
				select: this.ativaAreaSpec
			},

			'modprojetos_mainprojetos button#modprojetos_btnBuscaAvancada':{
				click: this.abreBuscaAvancada
			},

			'modprojetos_buscaProjetoo button#modprojetos_buscaBtnCancelar':{
				click: this.fechaBuscaAvacada
			},

			'modprojetos_buscaProjetoo button#modprojetos_buscaBtnBuscar':{
				click: this.buscarProjetos
			},

			'modprojetos_mainprojetos button#modprojetos_btnlimpaFiltros':{
				click: this.limparFiltros
			},

			'modprojetos_buscaoritador grid#gridOrientador':{
				itemclick: this.AtivaBtnBuscOrientador
			},

			'modprojetos_buscaaluno grid#gridAluno':{
				itemclick: this.AtivaBtnBuscAluno
			},

			'modprojetos_buscaoritador button#btnAddOrientador':{
				click: this.SelecionaBuscaOrientador
			},

			'modprojetos_viewprojeto button#btnBuscaOrientador':{
				click: this.BuscaAddOrientador
			},

			'modprojetos_viewprojeto button#btnBuscaAluno':{
				click: this.BuscaAddAluno
			},

			'modprojetos_buscaaluno button#btnAddAluno':{
				click: this.SelecionaBuscaAluno
			},

			'modprojetos_mainprojetos button#btnExport':{
				click: this.exportarExcel
			},
		});
    },

    exportarExcel: function(button){
        var store = button.up('window').down('#modprojetos_mainprojetos').getStore();

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
                    window.open("Server/projetos/exportarExcel.php?filtro="+buscaRapida
                        +"&cpf="+store.proxy.extraParams.cpf
                        +"&nome="+store.proxy.extraParams.nome
                        +"&email="+store.proxy.extraParams.email
                        +"&titulo="+store.proxy.extraParams.titulo
                        +"&apresentacao_obrigatoria="+store.proxy.extraParams.apresentacao_obrigatoria
                        +"&fgk_area="+store.proxy.extraParams.fgk_area
                        +"&fgk_programa_ic="+store.proxy.extraParams.fgk_programa_ic
                        +"&fgk_orgao_fomento="+store.proxy.extraParams.fgk_orgao_fomento
                        +"&fgk_categoria="+store.proxy.extraParams.fgk_categoria
                        +"&fgk_area_especifica="+store.proxy.extraParams.fgk_area_especifica
                        +"&fgk_departamento="+store.proxy.extraParams.fgk_departamento
                    );
                }
            }
        });
    },

    criaTrabalho: function(button){
    	var grid = button.up('grid'), 
    		record = grid.getSelectionModel().getSelection()[0];

    	Ext.MessageBox.confirm('Confirmação', 'Gerar trabalho a partir do projeto?<br><br><b>Título: </b>'+record.data.titulo+'<br> <b>Aluno: </b>'+record.data.aluno+'.',
        function(button){
			if(button == 'yes'){
				Ext.Ajax.request({
				    url: 'Server/projetos/criaTrabalho.php',
				    params: { id_projeto: record.data.id },
				    success: function(conn, response, options, eOpts){
				        var result = Ext.JSON.decode(conn.responseText, true);
				        myMask.hide();

				        if(result.msg){
				        	Ext.Msg.show({
		                        title:'INFO',
		                        msg: 'Trabalho criado com sucesso.',
		                        icon: Ext.Msg.INFO,
		                        buttons: Ext.Msg.OK
		                    });
				        	Ext.getCmp('modprojetos_mainprojetos').getStore().load();
				        }else{
				        	Ext.Msg.show({
				                title:'Erro',
				                msg: 'Erro ao criar projeto.',
				                icon: Ext.Msg.ERROR,
				                buttons: Ext.Msg.OK
				            });
				            myMask.hide();
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
			}
	  	});
    },

    BuscaAddAluno: function(button){
    	Ext.getCmp('modprojetos_viewFieldsetAluno').down('#modprojetos_cpfAluno').reset();
    	var win = Ext.create('Seic.view.Projetos.buscaAluno').show();
    	win.down('grid').getStore().load();
    },

    SelecionaBuscaAluno: function(button){
    	var record = button.up('window').down('#gridAluno').getSelectionModel().getSelection()[0];
    	var cpfField = Ext.getCmp('modprojetos_viewFieldsetAluno').down('#modprojetos_cpfAluno');
    	cpfField.setValue(record.data.cpf);
    	
    	button.up('window').down('grid').getStore().clearFilter();
    	button.up('window').destroy();
    },

    BuscaAddOrientador: function(button){
    	Ext.getCmp('modprojetos_viewFieldsetOrientador').down('#modprojetos_cpfOrientador').reset();
    	var win = Ext.create('Seic.view.Projetos.buscaOrientador').show();
    	win.down('grid').getStore().load();
    },

    SelecionaBuscaOrientador: function(button){
    	var record = button.up('window').down('#gridOrientador').getSelectionModel().getSelection()[0];
    	var cpfField = Ext.getCmp('modprojetos_viewFieldsetOrientador').down('#modprojetos_cpfOrientador');
    	cpfField.setValue(record.data.cpf);
    	
    	button.up('window').down('grid').getStore().clearFilter();
    	button.up('window').destroy();
    },

    limparFiltros: function(button){
    	var gridStore= Ext.getCmp('modprojetos_mainprojetos').getStore();
    	gridStore.getProxy().extraParams = {};
    	gridStore.load();

    	Ext.getCmp('modprojetos_barraBuscaAvancada').setVisible(false);
    	Ext.getCmp('modprojetos_buscaProjetoo').close();
    },

    buscarProjetos: function(button){
    	var win = button.up('window'),
            form = win.down('form'),
            values = form.getValues(false, true, false, false);

		var gridStore = Ext.getCmp('modprojetos_mainprojetos').getStore();
		gridStore.getProxy().extraParams = values;		
		gridStore.load();

		Ext.getCmp('modprojetos_barraBuscaAvancada').show();
		win.hide();

		var toolbar = Ext.getCmp("modprojetos_barraBuscaAvancada");
		toolbar.removeAll();
		toolbar.add({
			xtype: 'label', 
			text: 'Filtros aplicados:',
			style: {
	            color: 'white'
	        }
		});

		Ext.Object.each(values, function(key, value, myself) {
			if(key == 'cpf')
				var newKey = 'CPF';
		    else if(key == 'nome')
				var newKey = 'Nome';
			else if(key == 'email')
				var newKey = 'E-mail';
			else if(key == 'titulo')
				var newKey = 'Título';
			else if(key == 'apresentacao_obrigatoria')
				var newKey = 'Obrigatório';
			else if(key == 'fgk_area')
				var newKey = 'Área';
			else if(key == 'fgk_programa_ic')
				var newKey = 'Programa';
			else if(key == 'fgk_orgao_fomento')
				var newKey = 'Órgão';
			else if(key == 'fgk_categoria')
				var newKey = 'Categoria';
			else if(key == 'fgk_area_especifica')
				var newKey = 'Área específica';
			else if(key == 'fgk_departamento')
				var newKey = 'Departamento';

			toolbar.add({text: newKey});	
		});

		toolbar.add('->');
		toolbar.add({
            text: 'Limpar filtros',
            itemId: 'modprojetos_btnlimpaFiltros',
            iconCls: 'icon-clear',
            width: 110
        });
    },

    fechaBuscaAvacada: function(button){
    	button.up('window').hide();
    },

    abreBuscaAvancada: function(button){
    	var winBusca = Ext.getCmp('modprojetos_buscaProjetoo');
    	if(!winBusca)
    		Ext.create('Seic.view.Projetos.buscaProjeto').show;
    	else
    		winBusca.show();

    },

    preencheAluno: function(cpffield, isValid){
    	if(isValid){
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, procurando aluno...',
			    target: Ext.getCmp('modprojetos_viewFieldsetAluno')
			});

			myMask.show();

    		Ext.Ajax.request({
			    url: 'Server/projetos/verificaCpf.php',
			    params: {
			        cpf: cpffield.getValue(),
			        tipo: 0 //aluno
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();

			        if(result.msg){
			        	Ext.getCmp('modprojetos_FormNomeAluno').setValue(result.msg.nome);
			        	Ext.getCmp('modprojetos_FormEmailAluno').setValue(result.msg.email);
			        	Ext.getCmp('modprojetos_FormCursoAluno').setValue(result.msg.descricao_curso);
			        }else{
			        	Ext.Msg.show({
			                title:'Erro',
			                msg: 'Aluno não encontrado em nossa base de dados.',
			                icon: Ext.Msg.ERROR,
			                buttons: Ext.Msg.OK
			            });
			            myMask.hide();
			            cpffield.setValue('');
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
    	}else{
    		Ext.getCmp('modprojetos_FormNomeAluno').setValue('');
			Ext.getCmp('modprojetos_FormEmailAluno').setValue('');
			Ext.getCmp('modprojetos_FormCursoAluno').setValue('');
    	}
    },

    preencheOrientador: function(cpffield, isValid){
		if(isValid){
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, procurando professor...',
			    target: Ext.getCmp('modprojetos_viewFieldsetOrientador')
			});

			myMask.show();

    		Ext.Ajax.request({
			    url: 'Server/projetos/verificaCpf.php',
			    params: {
			        cpf: cpffield.getValue(),
			        tipo: 1 //professor
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();

			        if(result.msg){
			        	Ext.getCmp('modprojetos_FormNomeOrientador').setValue(result.msg.nome);
			        	Ext.getCmp('modprojetos_FormEmailOrientador').setValue(result.msg.email);
			        	Ext.getCmp('modprojetos_FormDepartamentoOrientador').setValue(result.msg.fgk_departamento_orientador);
			        }else{
			        	Ext.Msg.show({
			                title:'Erro',
			                msg: 'Professor não encontrado em nossa base de dados.',
			                icon: Ext.Msg.ERROR,
			                buttons: Ext.Msg.OK
			            });
			            myMask.hide();
			            cpffield.setValue('');
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
    	}else{
    		Ext.getCmp('modprojetos_FormNomeOrientador').setValue('');
			Ext.getCmp('modprojetos_FormEmailOrientador').setValue('');
			Ext.getCmp('modprojetos_FormDepartamentoOrientador').setValue('');
    	}
    },

    salvaProjeto: function(button){
    	var store = Ext.getCmp('modprojetos_mainprojetos').getStore();
    	var form = button.up('window').down('form');    	
    	var record = form.getRecord();
    	var values = form.getValues(false, false, true, false);

    	if(form.isValid()){
    		if(values.id){	   
    			record.set(values);		
	    		store.sync();
    		}else{
	    		store.add(values);   		    		
	    		store.sync();	    		
    		}    		
    		button.up('window').close();
    	}else
    		Ext.Msg.alert({
			    title:'Alerta',
			    msg: 'Atenção, o formulário foi preenchido incorretamente, ou existem campos vazios.<br> Por favor, verifique antes de continuar.',
			    buttons: Ext.Msg.OK,
			    icon: Ext.Msg.WARNING
			});		
		store.load();
    },

    editViewProject: function(button){
		var grid = Ext.getCmp('modprojetos_mainprojetos');
		var record = grid.getSelectionModel().getSelection()[0];
		
		if(record){		
			var win = Ext.create('Seic.view.Projetos.viewProjeto').show();
			win.setTitle('Editando projeto');
			win.down('form').loadRecord(record);

			Ext.getCmp('modprojetos_btnCancelSalvaProjeto').setText('Gravar');	  	

  			Ext.getCmp('modprojetos_viewComboArea').getStore().load();
			Ext.getCmp('modprojetos_viewComboDepartamento').getStore().load();
			Ext.getCmp('modprojetos_viewComboAreaSpec').getStore().load();
			Ext.getCmp('modprojetos_viewComboPrograma_ic').getStore().load();
			Ext.getCmp('modprojetos_viewComboOrgao').getStore().load();
			Ext.getCmp('modprojetos_viewComboCategoria').getStore().load();
		}else
			Ext.Msg.alert({
			    title:'Alerta',
			    msg: 'Atenção, selecione um projeto antes de editar.',
			    buttons: Ext.Msg.OK,
			    icon: Ext.Msg.ERROR
			});	
    },

    addProject: function(button){
    	Ext.create('Seic.view.Projetos.viewProjeto').show();
    },

    deleteProject: function(button){
    	var grid = button.up('grid');
    	var store = grid.getStore();
    	var record = grid.getSelectionModel().getSelection()[0];

    	Ext.MessageBox.confirm('Apagar projeto', 'Tem certeza que deseja apagar este projeto?<br><br><b>Título: </b>'+record.data.titulo+'<br> <b>Aluno: </b>'+record.data.aluno+'<br><br><b>Esta ação não pode ser desfeita!</b>',
        function(button){
			if(button == 'yes'){
				if((record.data.fgk_status == 1)||(!record.data.fgk_status)){
				  	store.remove(record);
				  	store.sync();		
			  	}else
				  	Ext.Msg.alert({
				    title:'Alerta',
				    msg: 'Este projeto não pode ser apagado,<br>trabalho relacionado já foi submetido.',
				    buttons: Ext.Msg.OK,
				    icon: Ext.Msg.ERROR
				});
			}
	  	});
    },

    fechar: function(button){
    	var win = button.up('window');
    	win.close();
    },

    ativButtons: function(grid, record){
    	Ext.getCmp('modprojetos_btnEditProjeto').setDisabled(false);
    	Ext.getCmp('modprojetos_btnDeletaProjeto').setDisabled(false);

    	if(!record.data.bool_trabalho)
	    	Ext.getCmp('modprojetos_btnGerarTrabalho').enable();
	    else
	    	Ext.getCmp('modprojetos_btnGerarTrabalho').disable();
    },

    loadMainProjetos: function(grid){
    	grid.getStore().clearFilter();
    	grid.getStore().load();
    },

    ativaAreaSpec: function(combo, records){
    	var comboAreaSpec = Ext.getCmp('modprojetos_viewComboAreaSpec');    
    	var proxyAreaSpec = comboAreaSpec.getStore().getProxy();

    	proxyAreaSpec.setExtraParam('area', combo.getValue());
    	comboAreaSpec.setDisabled(false);
    	comboAreaSpec.getStore().load();
    },

    AtivaBtnBuscOrientador: function(grid){
    	grid.up('window').down('#btnAddOrientador').setDisabled(false);
    },

    AtivaBtnBuscAluno: function(grid){
    	grid.up('window').down('#btnAddAluno').setDisabled(false);
    }
});
