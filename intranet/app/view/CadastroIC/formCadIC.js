Ext.define('Seic.view.CadastroIC.formCadIC', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadic_formCadIC',
    id : 'modcadic_formCadIC',
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
					labelWidth: 65
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'	},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'uppertextfield',
								fieldLabel: 'Sigla',
								allowBlank: false,
								name: 'sigla',
								flex: 1,
								padding: 1
							},
							{	xtype: 'combobox',
								fieldLabel: 'Apresentação',
								queryMode: 'local',
								labelWidth: 85,
								flex: 1,
								padding: 1,
								allowBlank: false,
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id','value'],
									data : [
										[1,'Poster'],
										[2,'Oral']
									]
								}),
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								forceSelection:true,
								name: 'fgk_tipo_apresentacao'
							}
						]
					},
					{	xtype: 'textfield',
						fieldLabel: 'Programa',
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
					itemId: 'btnSalvarIC'
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
