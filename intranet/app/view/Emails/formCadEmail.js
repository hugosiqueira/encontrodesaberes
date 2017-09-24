Ext.define('Seic.view.Emails.formCadEmail', {
    extend: 'Ext.window.Window',
    alias : 'widget.modemails_formCadEmail',
    id : 'modemails_formCadEmail',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
	title:  'Envio de email',
	autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id_email'},
					{	xtype: 'fieldcontainer',
						layout: 'hbox',
						items:[
							{	xtype: 'textfield',
								name: 'nome_destinatario',
								fieldLabel: 'Nome',
								labelWidth: 45,
								readOnly: true,
								flex: 1.5,
								padding: 1
							},
							{	xtype: 'textfield',
								name: 'email_destinatario',
								fieldLabel: 'Email',
								id: 'modemails_emailDestinatario',
								vtype: 'email',
								allowBlank: false,
								labelWidth: 40,
								padding: 1,
								flex: 1
							}
						]
					},

					{	xtype: 'fieldset',
						layout: 'form',
						title: 'Email',
						padding: '5 5 10 5',
						items:[
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'textfield',
										labelWidth: 50,
										name: 'assunto',
										allowBlank: false,
										fieldLabel: 'Título',
										flex: 3.5,
										padding: 1
									},
									{	xtype: 'textfield',
										labelWidth: 60,
										name: 'categoria',
										allowBlank: false,
										fieldLabel: 'Categoria',
										flex: 1.5,
										padding: 1
									}
								]
							},
							{	xtype: 'htmleditor',
								height: 400,
								name: 'corpo_email'
							}
						]
					}

				]
			}
        ];
        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Enviar novamente',
					itemId: 'btnEnviarEmail'
				},{
					iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
