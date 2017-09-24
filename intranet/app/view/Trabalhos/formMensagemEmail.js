Ext.define('Seic.view.Trabalhos.formMensagemEmail', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhos_formMensagemEmail',
    id : 'modtrabalhos_formMensagemEmail',
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
					{	xtype: 'hiddenfield', name: 'id_trabalho', id: 'modtrabalhos_id_trabalho_email'},
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
								id: 'modtrabalhos_radioTrabalhoSelecionado',
								name      : 'trabalho',
								inputValue: 'selecionado',
								id:'modtrabalhos_radioselecionado'
							},
							{	boxLabel  : 'Filtrados no grid',
								name      : 'trabalho',
								inputValue: 'filtrado',
								checked: true,
								id:'modtrabalhos_radiofiltrado'
							}
						]
					},
					{	xtype: 'checkboxgroup',
						labelWidth: 120,
						fieldLabel: 'Destinatário(s)',
						columns: 4,
						allowBlank: false,
						vertical: true,
						items: [
							{ boxLabel: 'Autor(es)', name: 'destinatario_autor', inputValue: '1', checked: true, id:'modtrabalhos_checkautor' },
							{ boxLabel: 'Orientador(es)', name: 'destinatario_orientador', inputValue: '1', id:'modtrabalhos_checkorientador' },
							{ boxLabel: 'Co-Autor(es)', name: 'destinataro_coautor', inputValue: '1', id:'modtrabalhos_checkcoautor' },
							{ boxLabel: 'Colaborador(es)', name: 'colaborador', inputValue: '1', id:'modtrabalhos_checkcolaborador' }
						],
						listeners:{
							change: function(check, newValue, oldValue, eOpts){
								if (check.isValid())
									return true
								else
									check.setValue(oldValue);
							}
						}
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
