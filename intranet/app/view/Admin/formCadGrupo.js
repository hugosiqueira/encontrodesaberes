Ext.define('Seic.view.Admin.formCadGrupo', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadgrupo',
    requires: ['Ext.form.Panel','Ext.form.field.Text'],
    title : 'Criar grupo',
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
					{	xtype: 'hiddenfield', name: 'id_grupo',id:'id_grupo'},					
					{	xtype: 'textfield',
						name: 'grupo',
						fieldLabel: 'Grupo',
						allowBlank: false,
						anchor: '60%',
						padding: 3
					},
					{	xtype: 'textfield',
						name: 'descricao_grupo',
						fieldLabel: 'Descrição',
						allowBlank: false,
						padding: 3
					}

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
					action: 'salvarGrupo'
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
