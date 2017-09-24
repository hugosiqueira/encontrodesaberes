Ext.define('Seic.view.MiniProp.formCadMiniCursosPropostos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modminiprop_formCadMiniCursosPropostos',
    id : 'modminiprop_formCadMiniCursosPropostos',
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
    width: 750,
    height: 630,
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
					padding: '5 0 5 5'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items:[
							{	xtype: 'textfield',
								fieldLabel: 'Responsável',
								readOnly: true,
								flex: 4,
								padding: 1,
								name: 'nome'
							},
							{	xtype: 'textfield',
								readOnly: true,
								fieldLabel: 'Status',
								flex: 1,
								padding: 1,
								name: 'rend_status'
							}
						]
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
					},
					{	xtype: 'textareafield',
						height: 300,
						readOnly: true,
						fieldLabel: 'Resumo',
						name: 'resumo'
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
