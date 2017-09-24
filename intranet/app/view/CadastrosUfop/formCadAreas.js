Ext.define('Seic.view.CadastrosUfop.formCadAreas', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadAreas',
    id : 'modcadufop_formCadAreas',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.UpperTextField',
		'Ext.form.field.ComboBox'
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
					{	xtype: 'hiddenfield', name: 'id_area'	},
					{	xtype: 'textfield',
						id: 'modcadufop_textCodigoArea',
						fieldLabel: 'Código',
						allowBlank: false,
						name: 'codigo_area',
						anchor: '50%'
					},
					{	xtype: 'uppertextfield',
						name: 'descricao_area',
						fieldLabel: 'Área',
						allowBlank: false
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
					itemId: 'btnSalvarArea'
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
