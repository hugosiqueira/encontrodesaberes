Ext.define('Seic.view.Trabalhos.formCadAutor', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhos_formcadautor',
    id : 'modtrabalhos_formCadAutor',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
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
				padding: '5 5 0 5',
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 65
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'},
					{	xtype: 'hiddenfield', name: 'fgk_trabalho', id: 'modtrabalhos_fgk_trabalho'},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'cpffield',
								fieldLabel: 'CPF',
								id: 'modtrabalhos_cpfAutor',
								name: 'cpf',
								width: 200,
								allowBlank: false,
								labelWidth: 65,
								plugins: [{
									ptype: 'ux.textMask',
									mask: '999.999.999-99',
									clearWhenInvalid: true
								}]
							},
							{	xtype: 'button',
								iconCls: 'icon-search-white',
								id: 'modtrabalhos_btnLupa',
								itemId: 'btnBuscarAutor'
							}
						]
					},
					
					{	xtype: 'fieldcontainer',
						id: 'modtrabalhos_camposAutorTrabalho',
						disabled: true,
						layout: {
							type: 'form'
						},
						items: [
							{	xtype: 'textfield',
								id: 'modtrabalhos_nomeAutor',
								fieldLabel: 'Nome',
								allowBlank: false,
								name: 'nome'
							},
							{	xtype: 'textfield',
								labelWidth: 65,
								name: 'email',
								id: 'modtrabalhos_emailAutor',
								fieldLabel: 'Email',
								vtype: 'email',
								allowBlank: false,
								padding: 1,
								flex: 1
							},
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'combobox',
										fieldLabel: 'Instituição',
										id: 'modtrabalhos_comboInstituicaoAutor',
										name: 'fgk_instituicao',
										queryMode: 'local',
										allowBlank: false,
										editable: true,
										labelWidth: 65,
										store: "InstituicaoAutor",
										typeAhead: true,
										valueField: 'id',
										displayField: 'sigla',
										triggerAction: 'all',
										minChars:1,
										forceSelection:true,
										anchor: '100%',
										flex: 1,
										padding: 1
									},
									{	xtype: 'combobox',
										fieldLabel: 'Tipo autor',
										id: 'modtrabalhos_comboTipoAutor',
										name: 'fgk_tipo_autor',
										queryMode: 'local',
										allowBlank: false,
										editable: true,
										labelWidth: 65,
										store: "TipoAutor",
										typeAhead: true,
										valueField: 'id_tipo_autor',
										displayField: 'descricao_tipo',
										triggerAction: 'all',
										minChars:1,
										forceSelection:true,
										anchor: '100%',
										flex: 1,
										padding: 1
									}
								]
							}
						]
					},
					{	xtype: 'checkbox',
						name: 'bool_apresentador',
						allowBlank: false,
						fieldLabel: 'Apresentador',
						boxLabel: 'Sim',
						labelAlign: 'left',
						flex: 1,
						padding: 1,
						inputValue: '1',
						uncheckedValue: '0',
						checked: false,
						labelWidth: 100
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
					itemId: 'btnSalvarAutor'
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
