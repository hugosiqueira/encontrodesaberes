Ext.define('Seic.AlterarSenha', {
    extend: 'Ext.window.Window',
	alias : 'widget.alterarsenha',
	requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text'
	],
    layout: 'fit',
    title: 'Alterar senha',
    modal: true,
    initComponent: function () {
		Ext.apply(Ext.form.field.VTypes, {
			password: function(val, field) {
				if (field.initialPassField) {
					var pwd = field.up('form').down('#' + field.initialPassField);
					return (val == pwd.getValue());
				}
				return true;
			},
			passwordText: 'As senhas não conferem.'
		});
		
        var me = this;      

        me.form = me.createForm();

        me.buttons = [{ 
        	text: 'Salvar', 
        	iconCls: 'icon-save', 
        	width: 90, 
        	handler: me.salvarSenha, 
        	scope: me 
        },{ 
        	text: 'Cancelar',
        	iconCls: 'icon-cancel', 
        	width: 90, 
        	handler: me.close, 
        	scope: me 
        }];

        me.items = [           
			me.form
        ];
        me.callParent();
    },

    createForm : function() {
        var me = this;
        var form = new Ext.form.Panel({
			width: 250,
            padding: '5 5 0 5',
			border: false,
			fieldDefaults: {
				anchor: '100%',
				labelAlign: 'top',
				msgTarget: 'side'
			},
			items: [
				{	xtype: 'textfield',
					name: 'senhaatual',
					inputType: 'password',
					fieldLabel: 'Senha atual',
					allowBlank: false,
					anchor: '100%',
					padding: 3
				},
				{	xtype: 'textfield',
					inputType: 'password',
					allowBlank: false,
					name: 'password',
					id: 'senhaUsuario',
					itemId : 'password',
					fieldLabel: 'Nova senha',
					anchor: '100%',
					padding: 3,
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
					name: 'confpassword',
					fieldLabel: 'Confirmar nova senha',
					anchor: '100%',
					padding: 3,
					vtype: 'password',
					initialPassField: 'password'
				}
			]
		});
        return form;
    },
    salvarSenha: function (button) {	
		win    = button.up('window'),
		form   = win.down('form'),
		record = form.getRecord(),
		values = form.getValues();
		
		if(form.isValid()) {
			Ext.Ajax.request({
				waitMsg: 'Aguarde...',
				url: 'Server/alterarSenha.php', 
				params: {	senha_atual: hex_sha512(values.senhaatual), nova_senha: hex_sha512(values.password)	},
				disableCaching: false ,
				success: function (res) {
					if(Ext.JSON.decode(res.responseText).success){
						Ext.Msg.alert('Sucesso', Ext.JSON.decode(res.responseText).msg);
						win.close();
					}
					else{
						Ext.Msg.alert('Falha', Ext.JSON.decode(res.responseText).msg);
					}
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
