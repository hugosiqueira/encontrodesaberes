Ext.define('Seic.controller.Emails', {
    extend: 'Ext.app.Controller',
    stores: [
		'Emails.Emails'
	],
    views: [
		'Emails.gridEmails'
	],

    init: function() {
		Ext.create('Seic.store.Emails.Emails');
		this.control({
			'modemails_gridEmails button#btnVerificarEmail': {
				click: this.verificarEmail
            },
			'modemails_gridEmails dataview': {
                itemdblclick: this.verificarEmailGrid
            },
			'modemails_formCadEmail button#btnEnviarEmail': {
				click: this.enviarEmail
            },
		});
    },
	enviarEmail: function(button){
		win    = button.up('window');
		form   = win.down('form');
		if(form.isValid()) {
			email = Ext.getCmp('modemails_emailDestinatario').getValue();
			Ext.Msg.show({
				title:   'Confirmação',
				msg:     'Deseja enviar este email para o destinatário: <b>'+email+' ?</b>',
				buttons: Ext.Msg.YESNO,
				fn: function(button){
					if(button=="yes"){
						form.submit({
							url: 'Server/emails/enviarEmail.php',
							waitMsg: 'Enviando email...',
							success: function (form,action) {
								var data= Ext.decode(action.response.responseText);
								if(data.success){
									win.close();
									Ext.getCmp('modemails_gridEmails').getStore().load();
									Ext.Msg.show({
										title:'Sucesso',
										msg: 'Email enviado com sucesso.',
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
	verificarEmailGrid: function(grid, record) {
		var win = Ext.create('Seic.view.Emails.formCadEmail').show();
		win.setTitle('Verificar email');
		win.down('form').loadRecord(record);
	},
	verificarEmail: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Emails.formCadEmail').show();
			win.setTitle('Verificar email');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um email para verificar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
});
