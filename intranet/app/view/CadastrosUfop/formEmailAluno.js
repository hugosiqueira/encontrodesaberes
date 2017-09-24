Ext.define('Seic.view.CadastrosUfop.formEmailAluno', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formEmailAluno',
    id : 'modcadufop_formEmailAluno',
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
					{	xtype: 'hiddenfield', name: 'id_aluno', id: 'modcadufop_id_aluno_email'},
					{	xtype      : 'fieldcontainer',
						fieldLabel : 'Aluno(s)',
						defaultType: 'radiofield',
						labelWidth: 120,
						defaults: {
							flex: 1
						},
						layout: 'hbox',
						items: [
							{	boxLabel  : 'Selecionado no grid',
								id: 'modcadufop_radioAlunoSelecionado',
								name      : 'aluno',
								inputValue: 'selecionado'
							},
							{	boxLabel  : 'Filtrados no grid',
								name      : 'aluno',
								inputValue: 'filtrado',
								checked: true,
								id:'modcadufop_radioFiltradoAluno'
							}
						]
					},
					/*
					{	xtype      : 'fieldcontainer',
						id: 'modcadufop_filtrosEmailAluno',
						layout: 'hbox',
						items: [
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'Seminário de monitoria',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não participa'],
										['1', 'Participa']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'bool_monitoria',
								padding: 1
							},
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'Mobilidade ano passado',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não'],
										['1', 'Sim']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'mobilidade_ano_passado',
								padding: 1
							},
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'Mobilidade este ano',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não'],
										['1', 'Sim']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'mobilidade_ano_atual',
								padding: 1
							}
						]
					},
					*/
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
