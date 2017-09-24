Ext.define('Seic.view.CadastroOrgaos.formCadOrgao', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadorgao_formCadOrgao',
    id : 'modcadorgao_formCadOrgao',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.UpperTextField'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 500,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				autoHeight: true,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 50
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'	},
					{	xtype: 'uppertextfield',
						fieldLabel: 'Sigla',
						allowBlank: false,
						name: 'sigla',
						anchor: '50%'
					},
					{	xtype: 'textfield',
						fieldLabel: 'Órgão',
						allowBlank: false,
						name: 'nome'
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
					itemId: 'btnSalvarOrgao'
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
