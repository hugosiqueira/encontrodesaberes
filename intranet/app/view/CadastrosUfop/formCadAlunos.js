Ext.define('Seic.view.CadastrosUfop.formCadAlunos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadAlunos',
    id : 'modcadufop_formCadAlunos',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Ext.ux.UpperTextField',
		'Ext.form.field.ComboBox',
		'Ext.ux.CpfField',
	    'Ext.ux.textMask'
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
					{	xtype: 'hiddenfield', name: 'id_aluno'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'cpffield',
								fieldLabel: 'CPF',
								id: 'modcadufop_cpfAluno',
								name: 'cpf',
								allowBlank: false,
								plugins: [{
									ptype: 'ux.textMask',
									mask: '999.999.999-99',
									clearWhenInvalid: true
								}],
								flex: 1,
								padding: 1
							},
							{	xtype: 'textfield',
								id: 'modcadufop_matriculaAluno',
								fieldLabel: 'Matrícula',
								disabled: true,
								allowBlank: true,
								name: 'matricula',
								flex: 1,
								padding: 1,
								labelWidth: 65
							},
							{	xtype: 'checkboxgroup',
								id: 'modcadufop_posAluno',
								flex: 0.7,
								disabled: true,
								padding: 1,
								fieldLabel: 'Pós?',
								labelWidth: 40,
								labelSeparator: '',
								items: [
									{ boxLabel: 'Sim', name: 'bool_pos', inputValue: '1'}
								]
							}
						]
					},
					{	xtype: 'fieldcontainer',
						id: 'modcadufop_camposCadAluno',
						disabled: true,
						layout: {
							type: 'form'
						},
						items: [
							{	xtype: 'uppertextfield',
								fieldLabel: 'Nome',
								allowBlank: false,
								name: 'nome'
							},
							{	xtype: 'textfield',
								name: 'email',
								fieldLabel: 'Email',
								vtype: 'email',
								allowBlank: true
							},
							{	xtype: 'combobox',
								fieldLabel: 'Curso',
								id: 'modcadufop_comboCursoAluno',
								name: 'fgk_curso',
								queryMode: 'local',
								allowBlank: true,
								editable: true,
								store: "CursosAluno",
								typeAhead: true,
								valueField: 'codigo',
								displayField: 'rend_curso',
								triggerAction: 'all',
								minChars:1,
								forceSelection:true,
								padding: 1
							}
						]
					},
					{	xtype: 'checkbox',
						name: 'bool_monitoria',
						allowBlank: false,
						fieldLabel: 'Seminário de monitoria?',
						boxLabel: 'Sim',
						labelAlign: 'left',
						inputValue: '1',
						uncheckedValue: '0',
						checked: false,
						labelWidth: 150
					},
					{   xtype: 'fieldset',
						title: 'CAINT',
						fieldDefaults: {
							labelAlign: 'left',
							anchor: '100%'
						},
						items: [
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'checkboxgroup',
										flex: 1,
										fieldLabel: 'Mobilidade ano passado',
										labelWidth: 150,
										items: [
											{ boxLabel: 'Sim', name: 'mobilidade_ano_passado', inputValue: '1'}
										]
									},
									{	xtype: 'checkboxgroup',
										fieldLabel: 'Mobilidade este ano',
										flex: 0.8,
										labelWidth: 130,
										items: [
											{ boxLabel: 'Sim', name: 'mobilidade_ano_atual', inputValue: '1'}
										]
									}
								]
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
					itemId: 'brnSalvarAluno'
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
