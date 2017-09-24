Ext.define('Seic.view.MiniProp.formCadMiniCursosAprovados', {
    extend: 'Ext.window.Window',
    alias : 'widget.modminiprop_formCadMiniCursosAprovados',
    id : 'modminiprop_formCadMiniCursosAprovados',
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
					padding: '5 5 5 5'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items:[
							{	xtype: 'textfield',
								fieldLabel: 'Apresentador',
								readOnly: false,
								allowBlank: false,
								flex: 4,
								padding: 1,
								name: 'apresentador'
							},
							{	xtype: 'textfield',
								readOnly: false,
								allowBlank: true,
								fieldLabel: 'Classificação',
								flex: 1,
								padding: 1,
								name: 'classificacao'
							}
						]
					},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items:[
							{	xtype: 'textfield',
								fieldLabel: 'Local',
								readOnly: false,
								allowBlank: true,
								flex: 4,
								padding: 1,
								name: 'local'
							},
							{	xtype: 'textfield',
								readOnly: false,
								allowBlank: true,
								fieldLabel: 'Max. Alunos',
								flex: 1,
								padding: 1,
								name: 'max_alunos'
							}
						]
					},
					{	xtype: 'fieldset',
						title: 'Horário',
						items: [
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items:[
									{	xtype: 'datefield',
										fieldLabel: 'Data',
										submitFormat: 'Y-m-d',
										name: 'data',
										readOnly: false,
										allowBlank: true,
										padding: 1,
										flex: 1
									},
									{	xtype: 'timefield',
										allowBlank: true,
										name: 'hora_ini',
										editable: true,
										forceSelection: false,
										fieldLabel: 'Início',
										increment: 30,
										labelWidth: 35,
										format: 'H:i:s',
										hideTrigger: true,
										padding: 1,
										flex: 1
									},
									{	xtype: 'timefield',
										allowBlank: true,
										name: 'hora_fim',
										editable: true,
										forceSelection: false,
										fieldLabel: 'Fim',
										increment: 30,
										labelWidth: 35,
										format: 'H:i:s',
										hideTrigger: true,
										padding: 1,
										flex: 1
									}
								]
							}
						]
					},
					{	xtype: 'textareafield',
						height: 100,
						readOnly: false,
						allowBlank: false,
						fieldLabel: 'Título',
						name: 'titulo'
					},
					{	xtype: 'textareafield',
						height: 230,
						readOnly: false,
						allowBlank: false,
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
				{	iconCls: 'icon-add',
					text: 'Salvar',
					itemId: 'btnSalvarMiniCursoAprovado'
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
