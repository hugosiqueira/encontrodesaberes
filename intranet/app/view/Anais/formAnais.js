Ext.define('Seic.view.Anais.formAnais', {
    extend: 'Ext.window.Window',
    alias : 'widget.modanais_formAnais',
    id : 'modanais_formAnais',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox',
		'Seic.view.Anais.formAutorAnais'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 850,
	autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				autoScroll : true,
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id', id: 'modtrabalhos_id_trabalho'},
					{	layout: 'form',
						padding: '5 5 0 5',
						border: false,
						items: [
							{	xtype: 'textareafield',
								height: 60,
								fieldLabel: 'Título',
								allowBlank: false,
								padding: 1,
								flex: 3,
								name: 'titulo'
							},
							{	xtype: 'textareafield',
								height: 200,
								fieldLabel: 'Resumo',
								allowBlank: false,
								padding: 1,
								flex: 3,
								name: 'resumo'
							},
							{	xtype: 'textfield',
								fieldLabel: 'Palavras chave',
								labelAlign: 'left',
								allowBlank: true,
								labelWidth: 110,
								padding: 1,
								flex: 1,
								name: 'palavras_chave'
							},
							{	xtype: 'fieldcontainer',
								layout: {
									type: 'hbox'
								},
								items: [
									{	xtype: 'combobox',
										fieldLabel: 'Área específica',
										id: 'modanais_comboAreaEspecifica',
										name: 'fgk_area_especifica',
										queryMode: 'local',
										allowBlank: false,
										editable: true,
										labelAlign: 'left',
										labelWidth: 110,
										store: new Ext.data.JsonStore({
											proxy: {
												type: 'ajax',
												url: 'Server/anais/listarAreaEspecificaPA.php',
												reader: {
													type: 'json',
													root: 'resultado'
												}
											},
											fields: [
												{name:'id',	type: 'int'},
												{name:'descricao_area_especifica', type:'string'}
											]
										}),
										typeAhead: true,
										valueField: 'id',
										displayField: 'descricao_area_especifica',
										triggerAction: 'all',
										minChars:1,
										forceSelection:false,
										anchor: '100%',
										padding: 3,
										flex: 2
									},
									{	xtype      : 'fieldcontainer',
										padding: 3,
										fieldLabel : 'Trabaho premiado',
										labelAlign: 'left',
										defaultType: 'radiofield',
										labelWidth: 120,
										flex: 1,
										defaults: {
											flex: 1
										},
										layout: 'hbox',
										items: [
											{	boxLabel  : 'Sim',
												name      : 'bool_premiado',
												inputValue: '1'
											},
											{	boxLabel  : 'Não',
												name      : 'bool_premiado',
												inputValue: '0',
												checked: true
											}
										]
									}
								]
							},
							{	xtype: 'gridpanel',
								title: 'Autoria',
								padding: '0 0 0 0',
								border: true,
								height: 280,
								disabled: true,
								id: 'modanais_gridAutores',
								alias : 'widget.modanais_gridAutores',
								store: 'Seic.store.Anais.AutoresAnais',
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "id",
											dataIndex: 'id',
											hidden:true
										},
										{ 	text: '#',
											dataIndex: 'seq',
											width: 25
										},
										{ 	text: 'Nome',
											dataIndex: 'nome',
											flex: 1
										},	
										{ 	text: 'Citação',
											dataIndex: 'nome_citacao',
											flex: 1
										},										
										{ 	text: 'Email',
											dataIndex: 'email',
											width: 150
										},
										{ 	text: 'Tipo',
											dataIndex: 'descricao_tipo',
											width: 100
										},
										{ 	text: 'Instituição',
											dataIndex: 'instituicao',
											align: 'center',
											flex: 1
										}
									]
								},
								tbar:[
									{	text: 'Adicionar',
										iconCls: 'icon-add',
										itemId: 'btnAdicionarAutor'
									},
									{	text: 'Editar',
										iconCls: 'icon-edit',
										itemId: 'btnEditarAutor'
									},
									{	text: 'Remover',
										iconCls: 'icon-delete',
										itemId: 'btnApagarAutor'
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
					itemId: 'btnSalvarAnais'
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
