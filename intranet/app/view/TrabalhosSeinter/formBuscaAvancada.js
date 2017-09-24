Ext.define('Seic.view.TrabalhosSeinter.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhosseinter_formbuscaavancada',
	id: 'modtrabalhosseinter_formBuscaAvancada',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CpfFieldBlank',
		'Ext.form.field.ComboBox'
	],
    title : 'Busca avançada',
    layout: 'fit',
    autoShow: true,
    width: 400,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
            {   xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 80,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'cpffieldblank',
						fieldLabel: 'CPF',
						name: 'cpf',
						flex: 1,
						anchor: '50%',
						allowBlank: true,
						plugins: [{
							ptype: 'ux.textMask',
							mask: '999.999.999-99',
							clearWhenInvalid: true
						}]
					},
					{	xtype: 'textfield',
						name: 'nome_aluno',
						fieldLabel: 'Aluno'
					},
					{	xtype: 'textfield',
						fieldLabel: 'Curso',
						allowBlank: true,
						name: 'curso_aluno'
					},
					{	xtype: 'textfield',
						fieldLabel: 'Universidade',
						flex: 1,
						allowBlank: true,
						name: 'universidade_destino',
						padding: 1
					},
					{	xtype: 'numberfield',
						fieldLabel: 'Meses afastado',
						allowBlank: true,
						name: 'tempo_afastamento',
						maxValue: 99,
						labelWidth: 110,
						anchor: '60%',
						minValue: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Situação',
						id: 'modtrabalhosseinter_comboStatus-PA',
						name: 'fgk_status',
						queryMode: 'local',
						allowBlank: true,
						anchor: '100%',
						editable: true,
						store: "Status",
						typeAhead: true,
						valueField: 'id_status',
						displayField: 'descricao_status',
						triggerAction: 'all',
						minChars:1,
						forceSelection:false
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
					itemId: 'btnBuscaAvancada'
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
