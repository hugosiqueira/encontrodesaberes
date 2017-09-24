Ext.define('Seic.view.CadastrosUfop.formBuscaAvancadaAluno', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadufop_formBuscaAvancadaAluno',
	id: 'modcadufop_formBuscaAvancadaAluno',
    requires: [
		'Ext.form.Panel',
		'Ext.ux.CpfFieldBlank',
		'Ext.form.field.ComboBox'
	],
    title : 'Buscar por...',
    layout: 'fit',
    autoShow: true,
    width: 500,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
            {   xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'left',
					msgTarget: 'side'
				},
				items:[
					{	xtype: 'combobox',
						fieldLabel: 'Curso',
						labelAlign: 'left',
						id: 'modcadufop_comboCursoAluno-PA',
						name: 'fgk_curso',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						labelWidth: 55,
						store: "CursosAluno",
						typeAhead: true,
						valueField: 'codigo',
						displayField: 'rend_curso',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						padding: 1
					},
					// {	xtype: 'combobox',
						// labelAlign: 'left',
						// fieldLabel: 'Pós graduação',
						// queryMode: 'local',
						// editable: false,
						// store:  new Ext.data.ArrayStore({
							// fields: ['id', 'value'],
							// data : [
								// ['-1', ' - '],
								// ['0', 'Não'],
								// ['1', 'Sim']
							// ]
						// }),
						// value: '-1',
						// labelWidth: 160,
						// anchor: "55%",
						// typeAhead: false,
						// valueField: 'id',
						// displayField: 'value',
						// triggerAction: 'all',
						// name: 'bool_pos',
						// padding: 1
					// },
					{	xtype: 'combobox',
						labelAlign: 'left',
						fieldLabel: 'Seminário de monitoria?',
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
						anchor: '55%',
						labelWidth: 160,
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						name: 'bool_monitoria',
						padding: 1
					},
					{	xtype: 'combobox',
						labelAlign: 'left',
						labelWidth: 160,
						fieldLabel: 'Mobilidade ano passsado?',
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
						anchor: '55%',
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						name: 'mobilidade_ano_passado',
						padding: 1
					},
					{	xtype: 'combobox',
						labelAlign: 'left',
						labelWidth: 160,
						fieldLabel: 'Mobilidade este ano?',
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
						anchor: '55%',
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						name: 'mobilidade_ano_atual',
						padding: 1
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
				{	iconCls: 'icon-search-white',
					text: 'Buscar',
					itemId: 'btnBuscarAluno',
				},{
					iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.hide
				}
			]
        }];
        this.callParent(arguments);
    }
});
