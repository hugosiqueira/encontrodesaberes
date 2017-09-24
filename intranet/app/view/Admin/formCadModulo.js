Ext.define('Seic.view.Admin.formCadModulo', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadmodulo',

    requires: ['Ext.form.Panel','Ext.form.field.Text'],

    title : 'Criar módulo',
    layout: 'fit',
    autoShow: true,
    width: 450,
    autoHeight: true,
    modal: true,
    initComponent: function() {
        this.items = [
            {   xtype: 'form',
                padding: '5 5 0 5',
                border: false,
                fieldDefaults: {
                    anchor: '100%',
                    labelAlign: 'top',
					msgTarget: 'side'
                },
                items: [
					{	xtype: 'hiddenfield', name: 'id_modulo',id:'id_modulo'},
					{	xtype: 'textfield',
						name: 'nome_modulo',
						fieldLabel: 'Nome módulo',
						allowBlank: false,
						padding: 3
					}
					// ,{	xtype: 'textfield',
						// name: 'name',
						// fieldLabel: 'Pasta',
						// allowBlank: false,
						// padding: 3,
						// anchor: '60%'
					// },
					// {	xtype: 'textfield',
						// name: 'iconCls',
						// fieldLabel: 'Ícone',
						// allowBlank: false,
						// padding: 3,
						// anchor: '60%'
					// },
					// {	xtype: 'textfield',
						// name: 'module',
						// fieldLabel: 'Atalho',
						// allowBlank: false,
						// padding: 3,
						// anchor: '60%'
					// }
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
					action: 'salvarModulo'
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
