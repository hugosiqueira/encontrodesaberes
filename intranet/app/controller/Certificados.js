Ext.define('Seic.controller.Certificados', {
    extend: 'Ext.app.Controller',
    stores: [
		'Certificados.Certificados',
		'Certificados.TipoCertificado',
	],
    views: [
		'Certificados.gridCertificados',
		'Certificados.formCadCertificados'
	],

    init: function() {
		Ext.create('Seic.store.Certificados.Certificados');
		Ext.create('Seic.store.Certificados.TipoCertificado');
		this.control({
			'modcertificados_formCadCertificados textfield#modcertificados_cpf':{
				validitychange: this.buscarCpf
			},
			'modcertificados_gridCertificados button#btnAdicionarCertificado': {
                click: this.adicionarCertificado
            },
			'modcertificados_formCadCertificados button#btnSalvarCertificado': {
                click: this.salvarCertificado
            },
			'modcertificados_gridCertificados dataview': {
                itemdblclick: this.editarCertificadoGrid
            },
			'modcertificados_gridCertificados button#btnEditarCertificado': {
                click: this.editarCertificado
            },
			'modcertificados_gridCertificados button#btnEnviarEmail': {
                click: this.enviarEmail
            },
			'modcertificados_gridCertificados button#btnApagarCertificado': {
                click: this.apagarCertificado
            },
			'modcertificados_gridCertificados button#btnVisualizarCertificado': {
                click: this.visualizarCertificado
            },
		});
    },
	buscarCpf: function(cpffield, isValid){
		if(isValid){
			form = Ext.getCmp('modcertificados_formCadCertificados').down('form');
    		var myMask = new Ext.LoadMask({
			    msg: 'Aguarde, buscando cpf...',
			    target: Ext.getCmp('modcertificados_camposCertificado')
			});
			myMask.show();
    		Ext.Ajax.request({
			    url: 'Server/certificados/buscarCpf.php',
			    params: {
			        cpf: cpffield.getValue()
			    },
			    success: function(conn, response, options, eOpts){
			        var result = Ext.JSON.decode(conn.responseText, true);
			        myMask.hide();
			        if(result.success){
						form.getForm().findField('nome').setValue(result.nome);
						form.getForm().findField('email').setValue(result.email);
			        }
					else{
						Ext.Msg.show({
							title:'Atenção',
							msg: 'Nenhuma pessoa foi encontrada para o CPF: <b>'+cpffield.getValue()+'</b>',
							icon: Ext.Msg.WARNING,
							buttons: Ext.Msg.OK,
							fn: function(button){

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
	enviarEmail: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente reenviar o certificado selecionado por email?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						Ext.Ajax.request({
							url: 'Server/certificados/enviarEmail.php',
							params: {
								id_certificado: row.data.id_certificado
							},
							success: function(conn, response, options, eOpts){
								var result = Ext.JSON.decode(conn.responseText, true);
								if(result.success){
									Ext.Msg.alert({
										title: 'Sucesso',
										msg: 'Email enviado corretamente.',
										buttons: Ext.Msg.OK
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
					else {

					}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.QUESTION
			});
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um certificado.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	apagarCertificado: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja realmente apagar o certificado do CPF: <b>'+row.data.cpf+'</b>?<br>Esta ação não pode ser revertida.',
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
			    msg: 'Selecione um certificado para apagar.',
			    buttons: Ext.Msg.OK
			});
		}
    },
	editarCertificadoGrid: function(grid, row) {
		var win = Ext.create('Seic.view.Certificados.formCadCertificados').show();
		win.setTitle('Editar certificado');
		Ext.getCmp('modcertificados_comboTipoCertificado').getStore().load();
		win.down('form').loadRecord(row);
	},
	visualizarCertificado: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja aplicar máscara de fundo neste certificado?',
				buttons: Ext.Msg.YESNOCANCEL,
				fn: function(button){
					if(button=="yes"){
						var row = grid.getSelectionModel().getSelection()[0];
						url = 'http://www.encontrodesaberes.com.br/gerar_certificado.php?c='+row.data.chave_autenticidade+'&f=1';
						window.open(url,'_blank');

					}
					else if(button=="no"){
						var row = grid.getSelectionModel().getSelection()[0];
						url = 'http://www.encontrodesaberes.com.br/gerar_certificado.php?c='+row.data.chave_autenticidade+'&f=2';;
						window.open(url,'_blank');
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
			    msg: 'Selecione um certificado para visualizar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	editarCertificado: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Certificados.formCadCertificados').show();
			win.setTitle('Editar certificado');
			Ext.getCmp('modcertificados_comboTipoCertificado').getStore().load();
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um certificado para editar.',
			    buttons: Ext.Msg.OK
			});
		}
	},
	adicionarCertificado: function(button) {
		var win = Ext.create('Seic.view.Certificados.formCadCertificados').show();
		Ext.getCmp('modcertificados_comboTipoCertificado').getStore().load();
		win.setTitle('Novo certificado');
	},
	salvarCertificado: function(button) {
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		if(form.isValid()) {
			var grid = Ext.getCmp('modcertificados_gridCertificados');
			var store = grid.getStore();
			if (record){
				record.set(values);
			}
			else {
				valuesCertificado = form.getValues(false,false,false,true);
				var certificado = Ext.create('Seic.model.Certificados.Certificados',valuesCertificado);
				store.add(certificado);
			}
			win.close();
			Ext.Msg.show({
				title:   'Atenção!',
				msg:     'Deseja enviar um email com o link do certificado?',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						store.getProxy().extraParams = {
							envia_email	: 1
						};
						store.sync();
					}
					else {
						
						store.getProxy().extraParams = {
							envia_email	: 0
						};
						store.sync();
					}
				},
				animEl: 'elId',
				icon:   Ext.MessageBox.QUESTION
			});
        }
        else{
			Ext.Msg.alert({
			    title: 'Falha',
			    msg: 'Favor informar todos os campos.',
			    buttons: Ext.Msg.OK
			});
		}
    },
});
