Ext.define('Seic.view.Admin.formCadUsuarioGrupo', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadusuariogrupo',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
    title : 'Atribuir grupo',
    layout: 'fit',
    autoShow: true,
    width: 300,
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
					{	xtype: 'hiddenfield', name: 'id_usuario'},
					{	xtype: 'textfield',
						name: 'nome_usuario',
						fieldLabel: 'Nome',
						readOnly: true,
						anchor: '100%',
						padding: 3
					},
					{	xtype: 'textfield',
						name: 'login',
						fieldLabel: 'Usuário',
						readOnly: true,
						anchor: '100%',
						padding: 3
					},
					{	xtype: 'combobox',
						fieldLabel: 'Grupo',
						id: 'comboUsuariosGrupos',
						name: 'fgk_grupo',
						padding: 3,
						queryMode: 'local',
						allowBlank: false,
						editable: true,
						store: "Grupos",
						typeAhead: true,
						valueField: 'id_grupo',
						displayField: 'grupo',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true
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
					action: 'salvarUsuarioGrupo'
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
