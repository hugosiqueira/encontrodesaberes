Ext.define('Seic.controller.Admin', {
    extend: 'Ext.app.Controller',
    stores: [
		'Admin.Usuarios',
		'Admin.Modulos',
		'Admin.UsuarioEventos',
		'Admin.EventosDoUsuario',
		'Admin.UsuariosDoEvento',
		'Admin.Eventos',
		'Admin.Grupos',
		'Admin.CertificadosEvento',
		'Seic.store.Admin.Servicos',
		'Seic.store.Admin.Checkpoint',
        'Seic.store.Admin.Responsaveis'
	],
    models: [
		'Admin.Usuario',
		'Admin.Modulo',
		'Admin.Evento',
		// 'Admin.Permissao',
		'Admin.Grupo',
		'Seic.model.Admin.Servicos',
		'Seic.model.Admin.Checkpoint',
        'Seic.model.Admin.Responsaveis'
	],
    views: [
		'Admin.tabAdmin',
		'Admin.gridUsuarios',
		'Admin.gridModulos',
		'Admin.gridEventos',
		'Admin.gridDefinirEventos',
		'Admin.gridGrupos',
		'Seic.view.Admin.tabServicos',
		'Seic.view.Admin.viewServico',
		'Seic.view.Admin.tabCheckpoints',
		'Seic.view.Admin.viewCheckpoint',
        'Seic.view.Admin.viewResponsaveis',
        'Seic.view.Admin.viewUsuariosVinculados'
	],

    init: function() {
		// console.log('Controller Admin carregado')
		Ext.create('Seic.store.Admin.Usuarios');
		Ext.create('Seic.store.Admin.Grupos');
		Ext.create('Seic.store.Admin.Eventos');
		Ext.create('Seic.store.Admin.EventosDoUsuario');
		Ext.create('Seic.store.Admin.UsuariosDoEvento');
		Ext.create('Seic.store.Admin.Modulos');
		Ext.create('Seic.store.Admin.UsuarioEventos');
		Ext.create('Seic.store.Admin.GruposModulos');
		Ext.create('Seic.store.Admin.GruposPermissoes');
		Ext.create('Seic.store.Admin.CertificadosEvento');
        this.control({

			'gridpermissoes dataview': {
                // itemdblclick: this.editarPermissaoGrid, RETIRADO POR CAUSA DE PERMISSÕES
            },
			'gridpermissoes button[action=adicionarPermissao]': {
            	click: this.adicionarPermissao
            },
			'formcadevento button#btnAdicionarTipoCertificado': {
            	click: this.adicionarTipoCertificado
            },
			'formcadevento button#btnEditarTipoCertificado': {
            	click: this.editarTipoCertificado
            },
			'formcadevento button#btnApagarTipoCertificado': {
            	click: this.apagarTipoCertificado
            },
			'formcadpermissao button[action=salvarPermissao]': {
                click: this.salvarPermissao
            },
			'gridpermissoes button[action=editarPermissao]': {
            	click: this.editarPermissao
            },
			'gridpermissoes button[action=apagarPermissao]': {
            	click: this.apagarPermissao
            },

			'gridmodulos dataview': {
                // itemdblclick: this.editarModuloGrid, RETIRADO POR CAUSA DE PERMISSÕES
                itemclick: this.renomearBtnLiberarModulo
            },
			'gridmodulos button[action=adicionarModulo]': {
            	click: this.adicionarModulo
            },
			'formcadmodulo button[action=salvarModulo]': {
                click: this.salvarModulo
            },
			'gridmodulos button[action=editarModulo]': {
            	click: this.editarModulo
            },
			'gridmodulos button[action=apagarModulo]': {
            	click: this.apagarModulo
            },
			'gridmodulos button[action=liberarModulo]': {
            	click: this.liberarModulo
            },

			'gridgrupos dataview': {
                // itemdblclick: this.editarGrupoGrid, RETIRADO POR CAUSA DE PERMISSÕES
                itemclick: this.renomearBtnLiberarGrupo
            },
			'gridgruposmodulos dataview': {
                itemclick: this.carregarGrupoPermissoes
            },
			'grideventos button[action=adicionarEvento]': {
            	click: this.adicionarEvento
            },
			'gridgrupos button[action=adicionarGrupo]': {
            	click: this.adicionarGrupo
            },
			'modadmin_formCadTipoCertificado button#btnSalvarTipoCertificado': {
                click: this.salvarTipoCertificado
            },
			'formcadevento button[action=salvarEvento]': {
                click: this.salvarEvento
            },
			'formcadevento button#btnUploadLogoEvento': {
                click: this.uploadLogoEvento
            },
			'modadmin_formCadTipoCertificado button#modadmin_btnApagarImagemCertificado': {
                click: this.apagarImagemTipoCertificado
            },
			'modadmin_formCadTipoCertificado button#btnUploadImagemCertificado': {
                click: this.uploadImagemTipoCertificado
            },
			'formcadevento button#btnUploadWallpaperEvento': {
                click: this.uploadWallpaperEvento
            },
			'formcadevento button#btnApagarLogoEvento': {
                click: this.apagarLogoEvento
            },
			'formcadevento button#btnApagarWallpaperEvento': {
                click: this.apagarWallpaperEvento
            },
			'formcadgrupo button[action=salvarGrupo]': {
                click: this.salvarGrupo
            },
			'grideventos button[action=editarEvento]': {
            	click: this.editarEvento
            },
			'gridgrupos button[action=editarGrupo]': {
            	click: this.editarGrupo
            },
			'panelmodulospermissoes button[action=salvarGruposModulos]': {
            	click: this.salvarGruposModulos
            },
			'grideventos button[action=apagarEvento]': {
            	click: this.apagarEvento
            },
			'gridgrupos button[action=apagarGrupo]': {
            	click: this.apagarGrupo
            },
			'gridgrupos button[action=liberarGrupo]': {
            	click: this.liberarGrupo
            },
			'gridgrupos button#btnModulosGrupo': {
            	click: this.modulosGrupo
            },
			// USUÁRIOS
			'gridusuarios dataview': {
                // itemdblclick: this.editarUsuarioGrid, RETIRADO POR CAUSA DE PERMISSÕES
                itemclick: this.renomearBtnLiberarUsuario
            },
			'gridusuarios button[action=adicionarUsuario]': {
            	click: this.adicionarUsuario
            },
			'formcadusuario button[action=salvarUsuario]': {
                click: this.salvarUsuario
            },
			'formcadusuariogrupo button[action=salvarUsuarioGrupo]': {
                click: this.salvarUsuarioGrupo
            },
			'gridusuarios button[action=definirEventos]': {
            	click: this.definirEventos
            },
			'gridusuarios button[action=editarUsuario]': {
            	click: this.editarUsuario
            },
			'gridusuarios button[action=apagarUsuario]': {
            	click: this.apagarUsuario
            },
			'gridusuarios button[action=liberarUsuario]': {
            	click: this.liberarUsuario
            },
			'gridusuarios button[action=definirGrupo]': {
            	click: this.definirGrupo
            },

            'modadmin_tabservicos grid#gridServico':{
                afterrender: this.LoadGrid,
                itemclick: this.AtivabtnAddServ2
            },

            'modadmin_tabservicos button#addServico':{
                click: this.AddEditServico
            },

            'modadmin_tabservicos button#editServico':{
                click: this.EditaServico
            },

            'modadmin_tabservicos button#apagarServico':{
                click: this.ApagarServico
            },

            'modadmin_viewservico button#salvarServico':{
                click: this.SalvaEditaServico
            },

            'modadmin_tabcheckpoints grid#gridCheckpoints':{
            	afterrender: this.LoadGrid,
            	itemclick: this.AtivBtnCheck
            },

            'modadmin_tabcheckpoints button#addLocal':{
            	click: this.AddCheckpoint
            },

            'modadmin_tabcheckpoints button#editLocal':{
            	click: this.EditaCheckpoint
            },

            'modadmin_tabcheckpoints button#apagarLocal':{
            	click: this.ApagaCheckpoint
            },

            'modadmin_viewcheckpoint button#okCheck':{
            	click: this.SalvaGravaCheckpoint
            },

            'modadmin_tabcheckpoints button#respLocal':{
                click: this.AddResponsavel
            },

            'modadmin_viewresponsaveis button#addResp':{
                click: this.viewUsuariosEvento
            },

            'modadmin_viewusuariosvinculados button#okSelect':{
                click: this.SelecionarResponsavel
            },

            'modadmin_viewresponsaveis grid#gridResponsaveis':{
                afterrender: this.loadGridResponsaveis,
                itemclick: this.ativBtnResp
            },

            'modadmin_viewresponsaveis button#apagarResp':{
                click: this.apagaRespLocal
            }
        });
    },

    apagaRespLocal: function(button){
        var store = Ext.getCmp('modadmin_gridResponsaveis').getStore(),
            userRecord = Ext.getCmp('modadmin_gridResponsaveis').getSelectionModel().getSelection()[0],
            id_local = Ext.getCmp('gridCheckpoints').getSelectionModel().getSelection()[0].data.id_local_presenca,
            me = this;

        userRecord.set('id_local', id_local);

        Ext.Msg.show({
            width: 250,
            title:'Confirmação',
            msg: 'Deseja remover <b>'+userRecord.data.nome_usuario+'</b> deste checkpoint?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(button){
                if(button=="yes"){
                    store.remove(userRecord);
                    store.sync();
                    // me.loadGridResponsaveis(Ext.getCmp('modadmin_gridResponsaveis'));
                }
            }
        });
    },

    ativBtnResp: function(grid){
        grid.up('window').down('#apagarResp').setDisabled(false);
    },

    loadGridResponsaveis: function(grid){
        var row = Ext.getCmp('gridEventos').getSelectionModel().getSelection()[0],
            checkpoint = Ext.getCmp('gridCheckpoints').getSelectionModel().getSelection()[0].data.id_local_presenca;
        grid.getStore().load({
            params:{
                id_evento: row.data.id,
                checkpoint: checkpoint
            }
        });
    },

    SelecionarResponsavel: function(button){
        var userRecord = button.up('window').down('grid').getSelectionModel().getSelection()[0],
            idLocal = Ext.getCmp('gridCheckpoints').getSelectionModel().getSelection()[0].data.id_local_presenca,
            newResp = Ext.create('Seic.model.Admin.Responsaveis',{
                id_usuario: userRecord.data.id_usuario,
                id_local: idLocal
            }),
            store = Ext.getCmp('modadmin_gridResponsaveis').getStore();

        store.add(newResp);
        store.sync();
        button.up('window').close();
        this.loadGridResponsaveis(Ext.getCmp('modadmin_gridResponsaveis'));
    },

    viewUsuariosEvento: function(button){
        Ext.create('Seic.view.Admin.viewUsuariosVinculados').show();
    },

    AddResponsavel: function(button){
        Ext.create('Seic.view.Admin.viewResponsaveis').show();
    },

    ApagaCheckpoint: function(button){
    	var record = Ext.getCmp('modadmin_tabcheckpoints').down('grid').getSelectionModel().getSelection()[0];
        var store = Ext.getCmp('modadmin_tabcheckpoints').down('grid').getStore();
        Ext.Msg.show({
            width: 500,
            title:'Confirmação',
            msg: 'Deseja excluir este checkpoint do evento atual?</br><b>'+record.data.descricao_local+'</b></br>',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(button){
                if(button=="yes"){
                    store.remove(record);
                    store.sync();
                }
            }
        });
    },

    EditaCheckpoint: function(button){
    	var record = button.up('panel').down('grid').getSelectionModel().getSelection()[0];
        var win = Ext.create('Seic.view.Admin.viewCheckpoint');
        win.setTitle('Editar checkpoint');
        win.down('#okCheck').setText('Gravar');

        win.down('form').loadRecord(record);
        win.show();
    },

    AtivBtnCheck: function(grid){
    	grid.up('window').down('#editLocal').setDisabled(false);
        grid.up('window').down('#apagarLocal').setDisabled(false);
        grid.up('window').down('#respLocal').setDisabled(false);
    },

    SalvaGravaCheckpoint: function(button){
    	var win = button.up('window'), form = win.down('form');
    	var values = form.getValues(false, false, true, false), record = form.getRecord();
    	var store = Ext.getCmp('modadmin_tabcheckpoints').down('#gridCheckpoints').getStore();
    	
    	if(form.isValid()){
    		if(record){
                record.set(values);
                store.sync();
            }else{
                store.add(values);
                store.sync();
            }
            win.close();
    	}else
	    	Ext.Msg.show({
                title: 'Erro.',
                msg:'Dados do local estão vazios, ou não foram preenchidos corretamente!',
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR,
                fn: function(button){}
            });
    },

    AddCheckpoint: function(){
    	Ext.create('Seic.view.Admin.viewCheckpoint').show();
    },

    SalvaEditaServico: function(button){
        var win = button.up('window');
        var form = win.down('form');
        var record = form.getRecord();
        var values = form.getValues(false, false, true, false);
        var store = Ext.getCmp('modadmin_tabservicos').down('#gridServico').getStore();
        store.getProxy().setExtraParam( 'id_evento', Ext.getCmp('modadmin_tabIdEvento').getValue());

        if(form.isValid()){
            if(record){
                record.set(values);
                store.sync();
            }else{
                store.add(values);
                store.sync();
            }
            store.load();
            win.close();
        }else
            Ext.Msg.show({
                title: 'Erro.',
                msg:'Dados do serviço estão vazios, ou não foram preenchidos corretamente!',
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR,
                fn: function(button){}
            });
    },

    ApagarServico: function(button){
        var record = Ext.getCmp('modadmin_tabservicos').down('grid').getSelectionModel().getSelection()[0];
        var store = Ext.getCmp('modadmin_tabservicos').down('grid').getStore();
        Ext.Msg.show({
            width: 500,
            title:'Confirmação',
            msg: 'Deseja excluir este serviço do evento atual?</br><b>'+record.data.descricao_servico+'</b></br>',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.QUESTION,
            fn: function(button){
                if(button=="yes"){
                    store.remove(record);
                    store.sync();
                    store.load();
                }
            }
        });
    },

    EditaServico: function(button){
        var record = button.up('panel').down('grid').getSelectionModel().getSelection()[0];
        var win = Ext.create('Seic.view.Admin.viewServico');
        win.setTitle('Editar serviço');
        win.down('#salvarServico').setText('Gravar');

        win.down('form').loadRecord(record);
        win.show();
    },

    AddEditServico: function(button){
        Ext.create('Seic.view.Admin.viewServico').show();
    },

    AtivabtnAddServ2: function(grid){
        grid.up('window').down('#editServico').setDisabled(false);
        grid.up('window').down('#apagarServico').setDisabled(false);
    },

    LoadGrid: function(grid){
        var store = grid.getStore();
        store.getProxy().extraParams = {};
    	store.load({
    		params: {id_evento: Ext.getCmp('modadmin_tabIdEvento').getValue()}
    	});
    },
    //////TAB_SERVICO

	definirEventos: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var win = new Ext.window.Window({
				title : 'Vincular eventos',
				layout: 'fit',
				autoShow: true,
				width: 450,
				height: 450,
				modal: true,
				items: [
					{	xtype: 'griddefinireventos'	}
				],
				fbar: [
					'->',
					{	iconCls: 'icon-cancel',
						text: 'Fechar',
						scope: this,
						handler: function(button){
							grid.getStore().load();
							button.up('window').close();
						}
					}
				],
				listeners: {
					render: function(){
						var row = grid.getSelectionModel().getSelection()[0];
						Ext.getCmp('gridDefinirEventos').getStore().load({
							params:{
								id_usuario: row.data.id_usuario
							}
						});
					}
				},
			});
			return win;
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um usuário vincular eventos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	uploadWallpaperEvento: function(button){
		var win = new Ext.window.Window({
			title : 'Plano de fundo',
			layout: 'fit',
			autoShow: true,
			width: 400,
			height: 120,
			modal: true,
			items: [
				{	xtype: 'form',
					border: false,
					bodyPadding: '10px',
					fileUpload: true,
					items: [
						{	xtype: 'fileuploadfield',
							emptyText: 'Arquivo...',
							labelWidth: 50,
							allowBlank: false,
							anchor: '100%',
							fieldLabel: 'Imagem',
							buttonText: 'Procurar...',
							name: 'wallpaper'
						}
					]
				}
			],
			fbar: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Enviar',
					handler: function(button){
						form = button.up('window').down('form');
						var grid = Ext.getCmp('gridEventos');
						var row = grid.getSelectionModel().getSelection()[0];
						var id_evento = row.data.id;
						form.submit({
							url: 'Server/admin/uploadWallpaperEvento.php',
							waitMsg: 'Enviando arquivo...',
							params: {	id_evento: id_evento	},
							success: function (form,action) {
								button.up('window').close();
								var data= Ext.decode(action.response.responseText);
								Ext.Msg.alert({
									title: 'Sucesso',
									msg: data.msg,
									buttons: Ext.Msg.OK,
									fn: function(button){
										var conteudoHtml = Ext.getCmp('modadmin_panelWallpaperEvento').getContentTarget();
										aleatoria = Math.random();
										conteudoHtml.update('<center><img width="400" src="resources/wallpapers/'+id_evento+'.jpg?'+aleatoria+'"></center>');
										Ext.getCmp('modadmin_btnApagarWallpaperEvento').enable();
									}
								});
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
	uploadImagemTipoCertificado: function(button){
		var win = new Ext.window.Window({
			title : 'Imagem',
			layout: 'fit',
			autoShow: true,
			width: 400,
			height: 120,
			modal: true,
			items: [
				{	xtype: 'form',
					border: false,
					bodyPadding: '10px',
					fileUpload: true,
					items: [
						{	xtype: 'fileuploadfield',
							emptyText: 'Arquivo...',
							labelWidth: 50,
							allowBlank: false,
							anchor: '100%',
							fieldLabel: 'Arquivo',
							buttonText: 'Procurar...',
							name: 'imagem'
						}
					]
				}
			],
			fbar: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Enviar',
					handler: function(button){
						form = button.up('window').down('form');
						var grid = Ext.getCmp('modadmin_gridCertificadosEvento');
						var row = grid.getSelectionModel().getSelection()[0];
						var id_tipo_certificado = row.data.id_tipo_certificado;
						form.submit({
							url: 'Server/admin/uploadImagemTipoCertificado.php',
							waitMsg: 'Enviando arquivo...',
							params: {	id: id_tipo_certificado	},
							success: function (form,action) {
								button.up('window').close();
								var data= Ext.decode(action.response.responseText);
								Ext.Msg.alert({
									title: 'Sucesso',
									msg: data.msg,
									buttons: Ext.Msg.OK,
									fn: function(button){
										var conteudoHtml = Ext.getCmp('modadmin_panelImagemCertificado').getContentTarget();
										aleatoria = Math.random();
										conteudoHtml.update('<center><img width="700" src="../img/certificados/tipos/'+id_tipo_certificado+'.jpg?'+aleatoria+'"></center>');
										Ext.getCmp('modadmin_btnApagarImagemCertificado').enable();
									}
								});
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
				{	iconCls: 'icon-cancel',
					text: 'Fechar',
					scope: this,
					handler: function(button){
						button.up('window').close();
						Ext.getCmp('modadmin_gridCertificadosEvento').getStore().load();
					}
				}
			]
		});
		return win;
	},
	uploadLogoEvento: function(button){
		var win = new Ext.window.Window({
			title : 'Logo',
			layout: 'fit',
			autoShow: true,
			width: 400,
			height: 120,
			modal: true,
			items: [
				{	xtype: 'form',
					border: false,
					bodyPadding: '10px',
					fileUpload: true,
					items: [
						{	xtype: 'fileuploadfield',
							emptyText: 'Arquivo...',
							labelWidth: 50,
							allowBlank: false,
							anchor: '100%',
							fieldLabel: 'Imagem',
							buttonText: 'Procurar...',
							name: 'logo'
						}
					]
				}
			],
			fbar: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Enviar',
					handler: function(button){
						form = button.up('window').down('form');
						var grid = Ext.getCmp('gridEventos');
						var row = grid.getSelectionModel().getSelection()[0];
						var id_evento = row.data.id;
						form.submit({
							url: 'Server/admin/uploadLogoEvento.php',
							waitMsg: 'Enviando arquivo...',
							params: {	id_evento: id_evento	},
							success: function (form,action) {
								button.up('window').close();
								var data= Ext.decode(action.response.responseText);
								Ext.Msg.alert({
									title: 'Sucesso',
									msg: data.msg,
									buttons: Ext.Msg.OK,
									fn: function(button){
										var conteudoHtml = Ext.getCmp('modadmin_panelLogoEvento').getContentTarget();
										aleatoria = Math.random();
										conteudoHtml.update('<center><img width="400" src="../img/intranet/eventos/logos/'+id_evento+'.jpg?'+aleatoria+'"></center>');
										Ext.getCmp('modadmin_btnApagarLogoEvento').enable();
									}
								});
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
	carregarGrupoPermissoes: function(grid, rowIndex){
		var row = grid.getSelectionModel().getSelection()[0];
		Ext.getCmp('gridGruposPermissoes').getStore().load({
			params:{
				id_modulo: row.data.id_modulo,
				id_grupo: row.data.id_grupo
			}
		});
	},
	renomearBtnLiberarUsuario: function(grid, rowIndex){
		var records = grid.getSelectionModel().getSelection()[0];
		var botao = Ext.getCmp('btnLiberarUsuario');
		if(records.data.bool_ativo == '1'){
			botao.setText('Desativar usuário');
			botao.setIconCls('icon-lock');
			// botao.setIcon('resources/images/icon_inativo.png'); //setIconCls não funcionou
		}
		else{
			botao.setText('Ativar usuário');
			botao.setIconCls('icon-unlock');
			// botao.setIcon('resources/images/icon_ativo.png'); //setIconCls não funcionou
		}
		if(records.data.fgk_grupo == '1'){
			Ext.getCmp('btnUsuarioEventos').disable();
		}
		else{
			Ext.getCmp('btnUsuarioEventos').enable();
		}
	},
	renomearBtnLiberarGrupo: function(grid, rowIndex){
		var records = grid.getSelectionModel().getSelection()[0];
		var botao = Ext.getCmp('btnLiberarGrupo');
		if(records.data.bool_ativo == '1'){
			botao.setText('Desativar grupo');
			botao.setIconCls('icon-lock');
			botao.setIcon('resources/css/icons/icon_inativo.png'); //setIconCls não funcionou
		}
		else{
			botao.setText('Ativar grupo');
			botao.setIconCls('icon-unlock');
			botao.setIcon('resources/css/icons/icon_ativo.png'); //setIconCls não funcionou
		}
	},
	renomearBtnLiberarModulo: function(grid, rowIndex){
		var records = grid.getSelectionModel().getSelection()[0];
		var botao = Ext.getCmp('btnLiberarModulo');
		if(records.data.bool_ativo == '1'){
			botao.setText('Desativar módulo');
			botao.setIconCls('icon-lock');
			botao.setIcon('resources/css/icons/icon_inativo.png'); //setIconCls não funcionou
		}
		else{
			botao.setText('Ativar módulo');
			botao.setIconCls('icon-unlock');
			botao.setIcon('resources/css/icons/icon_ativo.png'); //setIconCls não funcionou
		}
	},
	liberarGrupo: function(button) {
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			if(records.data.bool_ativo == '1')
				mensagem = 'Deseja bloquear o grupo: <b>'+records.data.grupo+'</b> ?<br>Todos os usuários deste grupo estarão impossibilitados de logar no sistema.';
			else
				mensagem = 'Deseja liberar o grupo: <b>'+records.data.grupo+'</b> ?<br>Todos os usuários deste grupo estarão liberados para logar no sistema.';
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     mensagem,
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/admin/liberarGrupos.php',
							params: {	id_grupo: records.data.id_grupo, bool_ativo: records.data.bool_ativo	},
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
			    msg: 'Selecione um grupo para liberar/bloquear.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	liberarModulo: function(button) {
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			if(records.data.bool_ativo == '1')
				mensagem = 'Deseja bloquear o módulo: <b>'+records.data.nome_modulo+'</b> ?<br>Esta ação afetará todos os usuários.';
			else
				mensagem = 'Deseja liberar o módulo: <b>'+records.data.nome_modulo+'</b> ?<br>Caso não esteja configurado corretamente o sistema poderá apresentar falhas. Esta ação afetará todos os usuários.';
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     mensagem,
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/admin/liberarModulos.php',
							params: {	id_modulo: records.data.id_modulo, bool_ativo: records.data.bool_ativo	},
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
			    msg: 'Selecione um módulo para liberar/bloquear.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	liberarUsuario: function(button) {
		var grid = button.up('grid');
		var store = grid.getStore();
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			if(records.data.bool_ativo == '1')
				mensagem = 'Deseja bloquear o usuário: <b>'+records.data.nome_usuario+'</b> ?';
			else
				mensagem = 'Deseja liberar o usuário: <b>'+records.data.nome_usuario+'</b> ?';
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     mensagem,
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							waitMsg: 'Aguarde...',
							url: 'Server/admin/liberarUsuarios.php',
							params: {	id_usuario: records.data.id_usuario, bool_ativo: records.data.bool_ativo	},
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
			    msg: 'Selecione um usuário para liberar/bloquear.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarUsuario: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o usuário: <b>'+records.data.login+'</b> ?',
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
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarEvento: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o evento: <b>'+records.data.sigla+' - '+records.data.titulo+'</b> ?',
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
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarGrupo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o grupo: <b>'+records.data.grupo+'</b> ?<br>Todos os usuários deste grupo estarão impossibilitados de logar no sistema até que sejam realocados para outro grupo.',
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
			    msg: 'Selecione um registro para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarModulo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o módulo: <b>'+records.data.nome_modulo+'</b> ?<br>Esta ação afetará todos os usuários.',
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
	apagarPermissao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir a permissão: <b>'+records.data.permissao+'</b> ?<br>Esta ação afetará todos os usuários.',
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
	editarPermissaoGrid: function(grid, record) {
        var edit = Ext.create('Seic.view.Admin.formCadPermissao').show();
		Ext.getCmp('comboModulosPermissao').getStore().load();
		edit.setTitle('Editar permissão');
        if(record)
        	edit.down('form').loadRecord(record);
    },
	editarUsuarioGrid: function(grid, record) {
        var edit = Ext.create('Seic.view.Admin.formCadUsuario').show();
		edit.setTitle('Editar usuário');
        if(record){
        	edit.down('form').loadRecord(record);
			Ext.getCmp('senhaUsuario').setValue('');
			Ext.getCmp('gridEventosUsuario').enable();
		}
    },
	editarEventosGrid: function(grid, record) {
        var edit = Ext.create('Seic.view.Admin.formCadEvento').show();
		edit.setTitle('Editar evento');
		Ext.getCmp('modadmin_gridUsuariosEvento').enable();
		Ext.getCmp('modadmin_gridServicosEvento').enable();
		Ext.getCmp('modadmin_gridCertificadosEvento').enable();


		edit.down('tabpanel').setActiveTab(2);
		var painel = Ext.getCmp('modadmin_panelLogoEvento');
		painel.enable();
		if(record.data.bool_logo == 1){
			conteudoHtml = painel.getContentTarget();
			aleatoria = Math.random();
			conteudoHtml.update('<center><img width="400" src="../img/intranet/eventos/logos/'+record.data.id+'.jpg?'+aleatoria+'"></center>');
			Ext.getCmp('modadmin_btnApagarLogoEvento').enable();
		}
		edit.down('tabpanel').setActiveTab(3);
		painel = Ext.getCmp('modadmin_panelWallpaperEvento');
		painel.enable();
		if(record.data.bool_wall != '0'){
			conteudoHtml = painel.getContentTarget();
			aleatoria = Math.random();
			conteudoHtml.update('<center><img width="420" src="resources/wallpapers/'+record.data.id+'.jpg?'+aleatoria+'"></center>');
			Ext.getCmp('modadmin_btnApagarWallpaperEvento').enable();
		}
		edit.down('tabpanel').setActiveTab(0);
		edit.down('form').loadRecord(record);
    },
	editarGrupoGrid: function(grid, record) {
        var edit = Ext.create('Seic.view.Admin.formCadGrupo').show();
		edit.setTitle('Editar grupo');
        if(record)
        	edit.down('form').loadRecord(record);
    },
	editarModuloGrid: function(grid, record) {
        var edit = Ext.create('Seic.view.Admin.formCadModulo').show();
		edit.setTitle('Editar módulo');
        if(record)
        	edit.down('form').loadRecord(record);
    },
	modulosGrupo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			if(records.data.id_grupo == '1'){
				Ext.Msg.show({
					title:   'Atenção',
					msg:     'O grupo <b>'+records.data.grupo+'</b> possui acesso irrestrito.<br>Suas permissões não podem ser revogadas.',
					buttons: Ext.Msg.OK,
					fn: function(button){
						this.close();
					},
					animEl: 'elId',
					icon:   Ext.MessageBox.WARNING
				});
			}
			else{
				var win = Ext.create('Seic.view.Admin.panelModulosPermissoes').show();
			}

		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um grupo para definir os módulos disponíveis.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarGruposModulos: function(button) {
		win    = button.up('window');
		store = Ext.getCmp('gridGruposModulos').getStore();
		win.close();
		store.sync();
		Ext.Msg.alert('Sucesso', 'Definição de permissões aplicadas com sucesso.');
    },
	editarEvento: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadEvento').show();
			edit.setTitle('Editar evento');
			Ext.getCmp('modadmin_gridUsuariosEvento').enable();
			Ext.getCmp('modadmin_gridServicosEvento').enable();
			Ext.getCmp('modadmin_gridCertificadosEvento').enable();
			edit.down('tabpanel').setActiveTab(2);
			var painel = Ext.getCmp('modadmin_panelLogoEvento');
			painel.enable();
			if(row.data.bool_logo == 1){
				conteudoHtml = painel.getContentTarget();
				aleatoria = Math.random();
				conteudoHtml.update('<center><img width="400" src="../img/intranet/eventos/logos/'+row.data.id+'.jpg?'+aleatoria+'"></center>');
				Ext.getCmp('modadmin_btnApagarLogoEvento').enable();
			}
			edit.down('tabpanel').setActiveTab(3);
			painel = Ext.getCmp('modadmin_panelWallpaperEvento');
			painel.enable();
			if(row.data.bool_wall != '0'){
				conteudoHtml = painel.getContentTarget();
				aleatoria = Math.random();
				conteudoHtml.update('<center><img width="420" src="resources/wallpapers/'+row.data.id+'.jpg?'+aleatoria+'"></center>');
				Ext.getCmp('modadmin_btnApagarWallpaperEvento').enable();
			}
			edit.down('tabpanel').setActiveTab(0);
			edit.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarGrupo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadGrupo').show();
			edit.setTitle('Editar grupo');
			edit.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarPermissao: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadPermissao').show();
			Ext.getCmp('comboModulosPermissao').getStore().load();
			edit.setTitle('Editar permissão');
			edit.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	definirGrupo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadUsuarioGrupo').show();
			Ext.getCmp('comboUsuariosGrupos').getStore().load();
			edit.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarUsuario: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadUsuario').show();
			edit.setTitle('Editar usuário');
			edit.down('form').loadRecord(row);
			Ext.getCmp('senhaUsuario').setValue('');
			Ext.getCmp('gridEventosUsuario').enable();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarModulo: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){ //verifica se tem uma linha selecionada no grid
			var row = grid.getSelectionModel().getSelection()[0];
			var edit = Ext.create('Seic.view.Admin.formCadModulo').show();
			edit.setTitle('Editar módulo');
			edit.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	adicionarTipoCertificado: function(button) {
		var win = Ext.create('Seic.view.Admin.formCadTipoCertificado').show();
		win.setTitle('Criar tipo certificado');
    },
	editarTipoCertificadoGrid: function(grid, record){

		var win = Ext.create('Seic.view.Admin.formCadTipoCertificado').show();
		win.setTitle('Editar tipo certificado');
		win.down('form').loadRecord(record);

		win.down('tabpanel').setActiveTab(1);
		var painel = Ext.getCmp('modadmin_panelImagemCertificado');
		painel.enable();
		conteudoHtml = painel.getContentTarget();
		aleatoria = Math.random();
		if(record.data.bool_imagem == 1){
			conteudoHtml.update('<center><img style="width:725px;max-height:600px;height: expression(this.height > 600 ? 600: true);" src="../img/certificados/tipos/'+record.data.id_tipo_certificado+'.jpg?'+aleatoria+'"></center>');
			Ext.getCmp('modadmin_btnApagarImagemCertificado').enable();
		}
		win.down('tabpanel').setActiveTab(0);



    },
	editarTipoCertificado: function(button){
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Admin.formCadTipoCertificado').show();
			win.setTitle('Editar tipo certificado');
			win.down('form').loadRecord(row);
			
			win.down('tabpanel').setActiveTab(1);
			var painel = Ext.getCmp('modadmin_panelImagemCertificado');
			painel.enable();
			conteudoHtml = painel.getContentTarget();
			aleatoria = Math.random();
			if(record.data.bool_imagem == 1){
				conteudoHtml.update('<center><img width="700" src="../img/certificados/tipos/'+record.data.id_tipo_certificado+'.jpg?'+aleatoria+'"></center>');
				Ext.getCmp('modadmin_btnApagarImagemCertificado').enable();
			}
			win.down('tabpanel').setActiveTab(0);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um registro para editar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarTipoCertificado: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var records = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja excluir o tipo de cerificado selecionado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						var store = grid.getStore();
						store.remove(records);
						store.sync();
						store.reload();
					}
					else { 	}
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
	adicionarPermissao: function(button) {
		var edit = Ext.create('Seic.view.Admin.formCadPermissao').show();
		edit.setTitle('Criar permissão');
		Ext.getCmp('comboModulosPermissao').getStore().load();
    },
	adicionarModulo: function(button) {
		var edit = Ext.create('Seic.view.Admin.formCadModulo').show();
		edit.setTitle('Criar módulo');
    },
	adicionarEvento: function(button) {
		var edit = Ext.create('Seic.view.Admin.formCadEvento').show();
		edit.setTitle('Criar evento');
    },
	adicionarGrupo: function(button) {
		var edit = Ext.create('Seic.view.Admin.formCadGrupo').show();
		edit.setTitle('Criar grupo');
    },
	adicionarUsuario: function(button) {
		var win = Ext.create('Seic.view.Admin.formCadUsuario').show();
		win.setTitle('Criar usuário');
    },
	salvarEvento: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues(false, false, false, true);
		var id_evento;
		var data;
		if(form.isValid()) {
			var grid = Ext.getCmp('gridEventos');
			var store = grid.getStore();
			if (record){
				var edicao = 1;
				record.setDirty(true);
				record.set(values);
			}
			else {
				var edicao = 0;
				store.add(values);
			}
			store.sync({
				async: false,
				success: function(response, options){
					id_evento = response.proxy.getReader().jsonData.id_evento;
					data = response.proxy.getReader().jsonData.resultado;
				}
			});
			if (edicao == 0){
				Ext.Msg.show({
					title:   'Sucesso',
					msg:   'Evento registrado com sucesso.<br>Deseja cadastrar uma logo ou plano de fundo agora?',
					icon:   Ext.MessageBox.QUESTION,
					buttons: Ext.Msg.YESNO,
					fn: function(button){
						if(button=="yes"){
							win.setTitle('Editar evento');
							Ext.getCmp('modadmin_panelLogoEvento').enable();
							Ext.getCmp('modadmin_panelWallpaperEvento').enable();
							var evento = Ext.create('Seic.model.Admin.Evento',{
								id_evento: data.id_evento,
								titulo						: data.titulo,
								sigla						: data.sigla,
								edicao						: data.edicao,
								data_evento_ini				: data.data_evento_ini,
								data_evento_fim				: data.data_evento_fim,
								data_inscricao_ini			: data.data_inscricao_ini,
								data_inscricao_fim			: data.data_inscricao_fim,
								data_avaliacao_ini			: data.data_avaliacao_ini,
								data_avaliacao_fim			: data.data_avaliacao_fim,
								data_reavaliacao_ini		: data.data_reavaliacao_ini,
								data_reavaliacao_fim		: data.data_reavaliacao_fim,
								data_submissao_ini			: data.data_submissao_ini,
								data_submissao_fim			: data.data_submissao_fim,
								data_submissao_adequacao_ini: data.data_submissao_adequacao_ini,
								data_submissao_adequacao_fim: data.data_submissao_adequacao_fim
							});
							form.loadRecord(evento);
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
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarTipoCertificado: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modadmin_gridCertificadosEvento');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				values = form.getValues(false,false,false,true);
				novoRegistro = Ext.create('Seic.model.Admin.CertificadosEvento',values);
				store.add(novoRegistro);
			}
			win.close();
			store.sync();
			store.reload();
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos obrigatórios.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarGrupo: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('gridGrupos');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				var grupo = Ext.create('Seic.model.Admin.Grupo',{
					grupo: values.grupo,
					descricao_grupo: values.descricao_grupo
				});
				store.add(grupo);
			}
			win.close();
			store.sync();
			// store.load();
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarModulo: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('gridModulos');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				var modulo = Ext.create('Seic.model.Admin.Modulo',{
					nome_modulo: values.nome_modulo,
					name: values.name,
					iconCls: values.iconCls,
					module: values.module
				});
				store.add(modulo);
			}
			win.close();
			store.sync();
			// store.load();
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarImagemTipoCertificado: function(button){
		var grid = Ext.getCmp('modadmin_gridCertificadosEvento');
		var row = grid.getSelectionModel().getSelection()[0];
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja realmente apagar a imagem deste tipo de certificado?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/admin/apagarImagemTipoCertificado.php',
						params: {	id: row.data.id_tipo_certificado	},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso','Imagem apagada com sucesso.');
								var conteudoHtml = Ext.getCmp('modadmin_panelImagemCertificado').getContentTarget();
								conteudoHtml.update('');
								Ext.getCmp('modadmin_btnApagarImagemCertificado').disable();
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
	},
	apagarLogoEvento: function(button){
		var grid = Ext.getCmp('gridEventos');
		var row = grid.getSelectionModel().getSelection()[0];
		var evento = row.data.sigla+' - '+row.data.titulo;
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja realmente apagar a logo do evento:<br><b>'+evento+'</b>?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/admin/apagarLogoEvento.php',
						params: {	id_evento: row.data.id	},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso','Logo apagada com sucesso.');
								var conteudoHtml = Ext.getCmp('modadmin_panelLogoEvento').getContentTarget();
								conteudoHtml.update('');
								Ext.getCmp('modadmin_btnApagarLogoEvento').disable();
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
	},
	apagarWallpaperEvento: function(button){
		var grid = Ext.getCmp('gridEventos');
		var row = grid.getSelectionModel().getSelection()[0];
		var evento = row.data.sigla+' - '+row.data.titulo;
		Ext.Msg.show({
			title:   'Atenção!',
			msg:     'Deseja realmente apagar o plano de fundo do evento:<br><b>'+evento+'</b>?',
			buttons: Ext.Msg.YESNO,
			fn: function(button){
				if(button=="yes"){
					Ext.Ajax.request({
						waitMsg: 'Aguarde...',
						url: 'Server/admin/apagarWallpaperEvento.php',
						params: {	id_evento: row.data.id	},
						disableCaching: false ,
						success: function (res) {
							if(Ext.JSON.decode(res.responseText).success){
								Ext.Msg.alert('Sucesso','Plano de fundo apagado com sucesso.');
								var conteudoHtml = Ext.getCmp('modadmin_panelWallpaperEvento').getContentTarget();
								conteudoHtml.update('');
								Ext.getCmp('modadmin_btnApagarWallpaperEvento').disable();
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
	},
	salvarPermissao: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('gridPermissoes');
			var store = grid.getStore();

			record.set(values);
			store.add(record);

			win.close();
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarUsuarioGrupo: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('gridUsuarios');
			var store = grid.getStore();

			Ext.Ajax.request({
				waitMsg: 'Aguarde...',
				url: 'Server/admin/criarUsuarioGrupo.php',
				params: {	id_usuario: values.id_usuario, id_grupo: values.fgk_grupo	},
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
			win.close();
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar o grupo.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	salvarUsuario: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();

		if(form.isValid()) {
			var grid = Ext.getCmp('gridUsuarios');
			var store = grid.getStore();
			if (record){
				//Editar usuario
				if (values.password != ''){
					if (values.password == values.confpassword) {
						values.password = hex_sha512(values.password);
						record.set(values);
					}
					else{
						Ext.getCmp('senhaUsuario').focus();
						Ext.Msg.alert({
							title: 'Falha',
							msg: 'Favor conferir a senha informada.',
							buttons: Ext.Msg.OK
						});
						return false;
					}
				}
				else{
					record.set(values);
				}
			}
			else {
				//Novo usuário
				if( (values.password != '')&&(values.password == values.confpassword) ){
					var usuario = Ext.create('Seic.model.Admin.Usuario',{
						nome_usuario: values.nome_usuario,
						email: values.email,
						login: values.login,
						password: hex_sha512(values.password)
					});
					store.add(usuario);
				}
				else{
					Ext.getCmp('senhaUsuario').focus();
					Ext.Msg.alert({
						title: 'Falha',
						msg: 'Favor conferir a senha informada.',
						buttons: Ext.Msg.OK
					});
					return false;
				}
			}
			store.sync({
				success: function(){
					win.close();
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
			    msg: 'Favor verificar todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    }
});
