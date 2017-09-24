Ext.define('Seic.view.CadastrosUfop.formCadAreasEspecificas', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadAreasEspecificas',
    id : 'modcadufop_formCadAreasEspecificas',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
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
					labelWidth: 40
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'	},
					{	xtype: 'combobox',
						labelWidth: 100,
						fieldLabel: 'Área',
						id: 'modcadufop_comboAreasAreaEspecifica',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: false,
						editable: true,
						store: "AreasDepartamento",
						typeAhead: true,
						valueField: 'id_area',
						displayField: 'descricao_area',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true
					},
					{	xtype: 'textfield',
						fieldLabel: 'Área específica',
						allowBlank: false,
						name: 'descricao_area_especifica',
						labelWidth: 100
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
					itemId: 'btnSalvarAreaEspecifica'
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
