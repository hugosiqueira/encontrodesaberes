Ext.define('Seic.view.Posters.formEmailAutores', {
    extend: 'Ext.window.Window',
    alias : 'widget.modposters_formEmailAutores',
    id : 'modposters_formEmailAutores',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
	title:  'Envio de email para autores',
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
					{	xtype: 'hiddenfield', name: 'id_trabalho', id: 'modposters_id_trabalho_email_autor'},
					{	xtype      : 'fieldcontainer',
						fieldLabel : 'Avaliador(es)',
						defaultType: 'radiofield',
						labelWidth: 120,
						defaults: {
							flex: 1
						},
						layout: 'hbox',
						items: [
							{	boxLabel  : 'Trabalho selecionado',
								id: 'modposters_radioSelecionadoAutor',
								name      : 'trabalho',
								inputValue: 'selecionado'
							},
							{	boxLabel  : 'Trabalhos filtrados',
								name      : 'trabalho',
								inputValue: 'filtrado',
								checked: true,
								id:'modposters_radioFiltradoAutor'
							}
						]
					},
					{	xtype: 'checkboxgroup',
						labelWidth: 120,
						fieldLabel: 'Autor(es)',
						columns: 4,
						allowBlank: false,
						vertical: true,
						items: [
							{ boxLabel: 'Autor(es)', name: 'destinatario_autor', inputValue: '1', checked: true, id:'modposters_checkautor' },
							// { boxLabel: 'Orientador(es)', name: 'destinatario_orientador', inputValue: '1', id:'modposters_checkorientador' },
							{ boxLabel: 'Co-Autor(es)', name: 'destinataro_coautor', inputValue: '1', id:'modposters_checkcoautor' },
							{ boxLabel: 'Colaborador(es)', name: 'colaborador', inputValue: '1', id:'modposters_checkcolaborador' }
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
								id: 'modposters_textoEmailAutores',
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
					itemId: 'btnEnviarEmailAutores'
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
