Ext.define('Seic.view.Monitoria.formCadMonitoria', {
    extend: 'Ext.window.Window',
    alias : 'widget.modmonitoria_formCadMonitoria',
    id : 'modmonitoria_formCadMonitoria',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
	title:  'Trabalho de monitoria',
	autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'},
					{	xtype: 'fieldcontainer',
						layout: 'hbox',
						items:[
							{	xtype: 'textfield',
								name: 'descricao_area',
								fieldLabel: 'Área',
								labelWidth: 45,
								readOnly: true,
								flex: 1,
								padding: 1
							},
							{	xtype: 'textfield',
								name: 'descricao_status',
								fieldLabel: 'Sitação',
								readOnly: true,
								labelWidth: 65,
								padding: 1,
								flex: 1
							}
						]
					},
					{	xtype: 'fieldcontainer',
						layout: 'hbox',
						items:[
							{	xtype: 'fieldset',
								layout: 'form',
								title: 'Aluno',
								flex: 1,
								padding: '5 5 5 5',
								items:[
									{	xtype: 'textfield',
										name: 'aluno_cpf',
										fieldLabel: 'CPF',
										labelWidth: 45,
										readOnly: true
									},
									{	xtype: 'textfield',
										name: 'aluno_nome',
										fieldLabel: 'Nome',
										labelWidth: 45,
										readOnly: true
									},
									{	xtype: 'textfield',
										name: 'aluno_email',
										fieldLabel: 'Email',
										labelWidth: 45,
										readOnly: true
									},
								]
							},
							{	xtype: 'fieldset',
								layout: 'form',
								title: 'Orientador',
								flex: 1,
								padding: '5 5 5 5',
								items:[
									{	xtype: 'textfield',
										name: 'orientador_cpf',
										fieldLabel: 'CPF',
										labelWidth: 45,
										readOnly: true
									},
									{	xtype: 'textfield',
										name: 'orientador_nome',
										fieldLabel: 'Nome',
										labelWidth: 45,
										readOnly: true
									},
									{	xtype: 'textfield',
										name: 'orientador_email',
										fieldLabel: 'Email',
										labelWidth: 45,
										readOnly: true
									},
								]
							}
						]
					},
					{	xtype: 'panel',
						layout: 'form',
						title: 'Trabalho',
						border: false,
						// padding: '5 5 10 5',
						items:[
							{	xtype: 'textareafield',
								height: 60,
								labelAlign: 'top',
								fieldLabel: 'Título',
								readOnly: true,
								name: 'titulo'
							},
							{	xtype: 'textareafield',
								height: 250,labelAlign: 'top',
								fieldLabel: 'Resumo',
								readOnly: true,
								name: 'resumo'
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
					text: 'Enviar novamente',
					itemId: 'btnEnviarEmail'
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
