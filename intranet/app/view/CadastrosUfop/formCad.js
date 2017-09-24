Ext.define('Seic.view.CadastrosUfop.formCadDepartamentos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadDepartamentos',
    id : 'modcadufop_formCadDepartamentos',
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
					labelWidth: 40
				},
				items: [
					{	xtype: 'uppertextfield',
						name: 'id_departamento',
						id: 'modcadufop_textIdDepartamento',
						fieldLabel: 'Código',
						allowBlank: false,
						anchor: '50%',
						labelWidth: 50
					},
					{	xtype: 'combobox',
						labelWidth: 50,
						fieldLabel: 'Área',
						id: 'modcadufop_comboAreasDepartamento',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: false,
						editable: true,
						flex: 1,
						padding: 1,
						store: "AreasDepartamento",
						typeAhead: true,
						valueField: 'id_area',
						displayField: 'descricao_area',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true
					},
					{	xtype: 'uppertextfield',
						fieldLabel: 'Departamento',
						allowBlank: false,
						name: 'nome_departamento',
						labelWidth: 85
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
					itemId: 'btnSalvarDepartamento'
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
