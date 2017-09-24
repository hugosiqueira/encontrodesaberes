Ext.define('Seic.view.MiniProp.formCadMiniCursosInscritos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modminiprop_formCadMiniCursosInscritos',
    id : 'modminiprop_formCadMiniCursosInscritos',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Ext.form.field.ComboBox'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 450,
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
					padding: '5 0 5 5'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'},
					{	xtype: 'hiddenfield', name: 'id_minicurso', id: 'modminiprop_idMinicurso'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'cpffield',
								labelWidth: 55,
								fieldLabel: 'CPF',
								id: 'modminiprop_cpfInscrito',
								name: 'cpf',
								allowBlank: false,
								plugins: [{
									ptype: 'ux.textMask',
									mask: '999.999.999-99',
									clearWhenInvalid: true
								}],
								width: 200,
								padding: 1
							}
							// ,{	xtype: 'button',
								// iconCls: 'icon-search-white',
								// id: 'modminiprop_btnLupa',
								// itemId: 'btnBuscarInscrito'
							// }
						]
					},
					{	xtype: 'fieldcontainer',
						layout: 'form',
						id: 'modminiprop_camposInscrito',
						disabled: true,
						fieldDefaults: {
							anchor: '100%',
							labelWidth: 55,
						},
						items: [
							{	xtype: 'textfield',
								fieldLabel: 'Nome',
								allowBlank: false,
								readOnly: true,
								name: 'nome'
							},
							{	xtype: 'textfield',
								name: 'email',
								readOnly: true,
								fieldLabel: 'Email'
							},
							{	xtype: 'textfield',
								fieldLabel: 'Depart.',
								id: 'modminiprop_textDepartamento',
								name: 'rend_departamento',
								readOnly: true,
								anchor: '100%'
							},
							{	xtype: 'combobox',
								fieldLabel: 'Serviço',
								id: 'modminiprop_comboServico',
								name: 'fgk_servico',
								queryMode: 'local',
								allowBlank: false,
								editable: true,
								labelWidth: 55,
								store: "Servicos",
								typeAhead: true,
								valueField: 'id_servico',
								displayField: 'descricao_servico',
								triggerAction: 'all',
								minChars:1,
								forceSelection:true,
								padding: 1,
								flex: 1,
								anchor: '100%'
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
					itemId: 'btnSalvarMiniCursoInscrito'
				},
				{	iconCls: 'icon-cancel',
					text: 'Fechar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
