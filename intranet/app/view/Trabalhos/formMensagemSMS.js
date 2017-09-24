Ext.define('Seic.view.Trabalhos.formMensagemSMS', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhos_formMensagemSMS',
    id : 'modtrabalhos_formMensagemSMS',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 500,
    height: 500,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				padding: '5 5 0 5',
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top'
				},
				items: [
					
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
					text: 'Enviar',
					itemId: 'btnEnviarSMS'
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
