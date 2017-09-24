Ext.define('Seic.view.Monitoria.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modmonitoria_formBuscaAvancada',
	id: 'modmonitoria_formBuscaAvancada',
    requires: [
		'Ext.form.Panel',
		'Ext.ux.CpfFieldBlank',
		'Ext.form.field.Text',
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
					labelWidth: 100,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'textfield',
						name: 'aluno_nome',
						fieldLabel: 'Aluno'
					},
					{	xtype: 'cpffieldblank',
						fieldLabel: 'CPF Aluno',
						name: 'aluno_cpf',
						anchor: '65%',
						allowBlank: true,
						plugins: [{
							ptype: 'ux.textMask',
							mask: '999.999.999-99',
							clearWhenInvalid: true
						}]
					},
					{	xtype: 'textfield',
						name: 'orientador_nome',
						fieldLabel: 'Orientador'
					},
					{	xtype: 'cpffieldblank',
						fieldLabel: 'CPF Orientador',
						name: 'orientador_cpf',
						anchor: '65%',
						allowBlank: true,
						plugins: [{
							ptype: 'ux.textMask',
							mask: '999.999.999-99',
							clearWhenInvalid: true
						}]
					},
					{	xtype: 'combobox',
						fieldLabel: 'Situação',
						id: 'modmonitoria_comboStatus-PA',
						name: 'fgk_status',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "Status",
						typeAhead: true,
						valueField: 'id_status',
						displayField: 'descricao_status',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
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
