Ext.define('Seic.view.CadastrosUfop.formCadCursos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formCadCursos',
    id : 'modcadufop_formCadCursos',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Ext.ux.UpperTextField',
		'Ext.ux.CpfField',
	    'Ext.ux.textMask'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 550,
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
					{	xtype: 'hiddenfield', name: 'id_curso'},
					{	xtype: 'uppertextfield',
						fieldLabel: 'Curso',
						allowBlank: false,
						name: 'descricao_curso',
						labelWidth: 75
					},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'uppertextfield',
								fieldLabel: 'Código',
								allowBlank: false,
								name: 'codigo',
								labelWidth: 75,
								flex: 1,
								padding: 1
							},
							{	xtype: 'combobox',
								fieldLabel: 'Modalidade',
								queryMode: 'local',
								labelWidth: 75,
								allowBlank: true,
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['value'],
									data : [
										['BACHARELADO'],
										['LICENCIATURA'],
										['MESTRADO'],
										['DOUTORADO']
									]
								}),
								typeAhead: false,
								valueField: 'value',
								displayField: 'value',
								triggerAction: 'all',
								forceSelection:true,
								flex: 1,
								padding: 1,
								name: 'modalidade'
							}
						]
					},
					{	xtype: 'combobox',
						labelWidth: 105,
						fieldLabel: 'Departamento',
						id: 'modcadufop_comboDepartamentosCurso',
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
						forceSelection:true
					},
					{	xtype: 'combobox',
						labelWidth: 105,
						fieldLabel: 'Área Específica',
						id: 'modcadufop_comboAreasEspecificasCurso',
						name: 'fgk_area_especifica',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						flex: 1,
						padding: 1,
						store: "AreasEspecificasCursos",
						typeAhead: true,
						valueField: 'id',
						displayField: 'descricao_area_especifica',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true
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
					itemId: 'btnSalvarCurso'
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
