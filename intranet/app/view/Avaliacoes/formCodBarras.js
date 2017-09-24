Ext.define('Seic.view.Avaliacoes.formCodBarras', {
    extend: 'Ext.window.Window',
    alias : 'widget.modaval_formCodBarras',
	id: 'modaval_formCodBarras',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text'
	],
    title : 'Informe o código de barras',
    layout: 'fit',
    autoShow: true,
    width: 300,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
            {   xtype: 'form',
                padding: '5 5 5 5',
                border: false,
                fieldDefaults: {
                    anchor: '100%',
					labelWidth: 85,
                    labelAlign: 'top',
					msgTarget: 'side'
                },
                items: [
					{	xtype: 'textfield',
						fieldLabel: 'Código de Barras',
						name: 'cod_barras',
						id: 'modaval_codBarras',
						anchor: '100%',
						allowBlank: false,
						listeners: {
							specialkey: function(text,e){
								if (e.getKey() == e.ENTER){
									Seic.app.getController('Avaliacoes').buscarCodBarras(text);
								}
							}
						}
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
				{
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
