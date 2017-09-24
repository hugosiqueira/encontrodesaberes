Ext.define('Seic.view.TrabalhosSeinter.formMensagemEmail', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhesseinter_formMensagemEmail',
    id : 'modtrabalhesseinter_formMensagemEmail',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
	title:  'Envio de email',
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
					{	xtype: 'hiddenfield', name: 'id', id: 'modtrabalhosseinter_id_trabalho_email'},
					{	xtype      : 'fieldcontainer',
						fieldLabel : 'Trabalho(s)',
						defaultType: 'radiofield',
						labelWidth: 120,
						defaults: {
							flex: 1
						},
						layout: 'hbox',
						items: [
							{	boxLabel  : 'Selecionado no grid',
								id: 'modtrabalhosseinter_radioTrabalhoSelecionado',
								name      : 'trabalho',
								inputValue: 'selecionado'
							},
							{	boxLabel  : 'Filtrados no grid',
								name      : 'trabalho',
								inputValue: 'filtrado',
								checked: true,
								id:'modtrabalhosseinter_radioTrabalhoFiltrado'
							}
						]
					},
					{	xtype: 'fieldset',
						layout: 'form',
						title: 'Email',
						padding: '5 5 10 5',
						items:[
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'textfield',
										labelWidth: 50,
										name: 'titulo',
										allowBlank: false,
										fieldLabel: 'Título',
										flex: 3.5,
										padding: 1
									},
									{	xtype: 'textfield',
										labelWidth: 60,
										name: 'categoria',
										allowBlank: false,
										fieldLabel: 'Categoria',
										flex: 1.5,
										padding: 1
									}
								]
							},							
							{	xtype: 'htmleditor',
								height: 400,
								allowBlank: false,
								name: 'email'
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
					text: 'Enviar',
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
