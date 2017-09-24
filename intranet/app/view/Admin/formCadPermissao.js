Ext.define('Seic.view.Admin.formCadPermissao', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadpermissao',

    requires: ['Ext.form.Panel','Ext.form.field.Text'],

    title : 'Criar permissão',
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
					{	xtype: 'hiddenfield', name: 'id_permissao',id:'id_permissao'},
					{	xtype: 'combobox',
						labelAlign: 'top',
						fieldLabel: 'Módulo',
						id: 'comboModulosPermissao',
						name: 'fgk_modulo',
						padding: 3,
						queryMode: 'local',
						allowBlank: false,
						editable: false,
						store: "Modulos",
						anchor: '60%',
						valueField: 'id_modulo',
						displayField: 'nome_modulo',
						triggerAction: 'all',
						forceSelection:true
					},
					{	xtype: 'textfield',
						name: 'permissao',
						fieldLabel: 'Permissão',
						allowBlank: false,
						anchor: '60%',
						padding: 3
					},
					{	xtype: 'textfield',
						name: 'descricao_permissao',
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
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Salvar',
					action: 'salvarPermissao'
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
