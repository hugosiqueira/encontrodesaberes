Ext.define('Seic.view.Posters.formCadSessao', {
    extend: 'Ext.window.Window',
    alias : 'widget.modposters_formCadSessao',
    id : 'modposters_formCadSessao',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox',
		// 'Seic.view.Trabalhos.formCadAutor'
	],
    layout: 'fit',
    autoShow: true,
	// jsonSubmit: true,
	border: false,
    width: 500,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				autoScroll : true,
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 65
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id', id: 'modposters_idSessao'},
					{	layout: 'form',
						padding: '5 5 0 5',
						border: false,
						items: [
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'textfield',
										fieldLabel: 'Nome',
										labelAlign: 'top',
										padding: 1,
										name: 'nome',
										allowBlank: false,
										flex: 3
									},
									{	xtype: 'textfield',
										labelAlign: 'top',
										fieldLabel: 'Sessão',
										padding: 1,
										name: 'sessao',
										allowBlank: false,
										flex: 1
									}
								]
							},
							{	xtype: 'fieldset',
								title: 'Horários',
								layout: 'hbox',
								padding: '5 5 5 5',
								items: [
									{	xtype: 'datefield',
										fieldLabel: 'Dia',
										name: 'dia',
										labelWidth: 30,
										submitFormat: 'Y-m-d',
										submitValue : true,
										allowBlank: false,
										flex: 1,
										padding: 2
									},
									{	xtype: 'textfield',
										name: 'hora_ini',
										labelWidth: 40,
										fieldLabel: 'Início',
										allowBlank: false,
										plugins: [{
											ptype: 'ux.textMask',
											mask: '99:99:99',
											clearWhenInvalid: true
										}],
										padding: 2,
										flex:1
									},
									{	xtype: 'textfield',
										name: 'hora_fim',
										labelWidth: 40,
										fieldLabel: 'Fim',
										allowBlank: false,
										plugins: [{
											ptype: 'ux.textMask',
											mask: '99:99:99',
											clearWhenInvalid: true
										}],
										padding: 2,
										flex:1
									}
								]
							},
							{	xtype: 'gridpanel',
								title: 'Capacidades',
								padding: '0 0 0 0',
								border: true,
								height: 280,
								disabled: true,
								id: 'modposters_gridCapacidades',
								store: 'CapacidadesSessao',
								listeners: {
									itemdblclick: function(grid, record){
										// Seic.app.getController('Posters').editarCapacidadeGrid(grid, record);
									}
								},
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "id",
											dataIndex: 'id_sessao_capacidade',
											hidden:true
										},
										{ 	text: 'Área',
											dataIndex: 'descricao_area',
											flex: 1
										},
										{ 	text: 'Capacidade',
											dataIndex: 'capacidade',
											align: 'center',
											width: 100
										}
									]
								},
								tbar:[
									{	text: 'Adicionar',
										iconCls: 'icon-add',
										itemId: 'btnAdicionarCapacidade'
									},
									{	text: 'Editar',
										iconCls: 'icon-edit',
										itemId: 'btnEditarCapacidade'
									},
									{	text: 'Remover',
										iconCls: 'icon-delete',
										itemId: 'btnApagarCapacidade'
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
					itemId: 'btnSalvarSessao'
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
