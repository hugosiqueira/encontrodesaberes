Ext.define('Seic.view.CadastrosUfop.formCadProfessoresTA', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadProfessoresTA',
    id : 'modcadufop_formCadProfessoresTA',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Ext.form.field.ComboBox',
		'Ext.ux.UpperTextField',
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
				autoScroll : true,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					padding: '5 0 5 5',
					labelWidth: 50
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id_professor'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'cpffield',
								fieldLabel: 'CPF',
								id: 'modcadufop_cpfProfessorTA',
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
								id: 'modcadufop_siapeProfessorTA',
								fieldLabel: 'Cód. Siape',
								disabled: true,
								allowBlank: false,
								name: 'cod_siape',
								flex: 1,
								padding: 1,
								labelWidth: 75
							}
						]
					},
					{	xtype: 'fieldcontainer',
						id: 'modcadufop_camposCadProfessoresTA',
						disabled: true,
						layout: {
							type: 'form'
						},
						items: [
							{	xtype: 'uppertextfield',
								id: 'modcadufop_nomeProfessorTA',
								fieldLabel: 'Nome',
								allowBlank: false,
								name: 'nome'
							},
							{	xtype: 'textfield',
								name: 'email',
								id: 'modcadufop_emailProfessorTA',
								fieldLabel: 'Email',
								vtype: 'email',
								allowBlank: false
							},
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'combobox',
										fieldLabel: 'Tipo',
										queryMode: 'local',
										allowBlank: false,
										id: 'modcadufop_comboTipoProfessorTA',
										editable: false,
										store:  new Ext.data.ArrayStore({
											fields: ['fgk_tipo', 'tipo'],
											data : [
												['1', 'Professor'],
												['2', 'Técnico administrativo']
											]
										}),
										flex: 1,
										padding: 1,
										typeAhead: false,
										valueField: 'fgk_tipo',
										displayField: 'tipo',
										triggerAction: 'all',
										forceSelection:true,
										name: 'fgk_tipo'
									},
									{	xtype: 'combobox',
										labelWidth: 85,
										fieldLabel: 'Departamento',
										id: 'modcadufop_comboDepartamentoProfessorTA',
										name: 'fgk_departamento',
										queryMode: 'local',
										allowBlank: false,
										editable: true,
										store: "DepartamentosProfessoresTA",
										typeAhead: true,
										valueField: 'id_departamento',
										displayField: 'id_departamento',
										triggerAction: 'all',
										minChars:1,
										forceSelection:true,
										flex: 1,
										padding: 1
									}
								]
							},
							// {	xtype: 'textfield',
								// id: 'modcadufop_cursosProfessorTA',
								// fieldLabel: 'Cursos',
								// allowBlank: true,
								// name: 'cursos'
							// },
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'checkbox',
										name: 'bool_avaliador',
										allowBlank: false,
										fieldLabel: 'Avaliador?',
										boxLabel: 'Sim',
										labelAlign: 'top',
										inputValue: '1',
										flex: 1,
										uncheckedValue: '0',
										checked: false,
										labelWidth: 80
									},
									{	xtype: 'checkbox',
										name: 'bool_coordenador',
										allowBlank: false,
										fieldLabel: 'Coordenador?',
										boxLabel: 'Sim',
										labelAlign: 'top',
										inputValue: '1',
										flex: 1,
										uncheckedValue: '0',
										checked: false,
										labelWidth: 80
									},
									{	xtype: 'checkbox',
										name: 'bool_monitoria',
										allowBlank: false,
										fieldLabel: 'Seminário de monitoria?',
										boxLabel: 'Sim',
										labelAlign: 'top',
										inputValue: '1',
										flex: 2,
										uncheckedValue: '0',
										checked: false,
										labelWidth: 150
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
					itemId: 'btnSalvarProfessorTA'
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
