Ext.define('Seic.view.MiniProp.formStatus', {
    extend: 'Ext.window.Window',
    alias : 'widget.modminiprop_formStatus',
    id : 'modminiprop_formStatus',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
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
				autoScroll : true,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top',
					padding: '5 5 5 5'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id_minicurso_prop'},
					{	xtype: 'combobox',
						fieldLabel: 'Novo status',
						anchor: '30%',
						queryMode: 'local',
						allowBlank: true,
						editable: false,
						store:  new Ext.data.ArrayStore({
							fields: ['id','value'],
							data : [
								[1,'Em edição'],
								[2,'Submetido'],
								[3,'Aprovado'],
								[4,'Rejeitado']
							]
						}),
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						forceSelection: true,
						name: 'status'
					},
					{	xtype: 'fieldset',
						title: 'Minicurso proposto',
						layout: 'form',
						items: [
							{	xtype: 'textfield',
								fieldLabel: 'Responsável',
								readOnly: true,
								name: 'nome'
							},
							{	xtype: 'textfield',
								fieldLabel: 'Área específica',
								readOnly: true,
								name: 'descricao_area_especifica'
							},
							{	xtype: 'textareafield',
								height: 100,
								readOnly: true,
								fieldLabel: 'Assunto',
								name: 'assunto'
							}
						]
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
					itemId:'btnSalvarStatus'
				},
				{	iconCls: 'icon-cancel',
					text: 'Fechar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
