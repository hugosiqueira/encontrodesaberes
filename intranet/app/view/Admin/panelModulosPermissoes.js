Ext.define('Seic.view.Admin.panelModulosPermissoes', {
    extend: 'Ext.window.Window',
    alias : 'widget.panelmodulospermissoes',
	
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.Panel'
	],
    layout: 'fit',
    autoShow: true,
    width: 700,
    height: 500,
    modal: true,
    initComponent: function() {
        this.items = [
            {   xtype: 'panel',
				layout: {
					type: 'hbox',
					pack: 'start',
					align: 'stretch'
				},
                items: [
					{	xtype: 'gridgruposmodulos', flex: 1	},
					{	xtype: 'gridgrupospermissoes', flex: 1 }
				]
			}
        ];        
        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            id:'buttons',
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Salvar',
					action: 'salvarGruposModulos'
				},
				{	iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
