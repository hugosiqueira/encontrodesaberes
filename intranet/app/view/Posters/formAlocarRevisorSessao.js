Ext.define('Seic.view.Posters.formAlocarRevisorSessao', {
    extend: 'Ext.window.Window',
    alias : 'widget.modposters_formAlocarRevisorSessao',
    id : 'modposters_formAlocarRevisorSessao',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.Panel'
	],
    layout: 'fit',
    autoShow: true,
    width: 950,
    autoHeight: true,
    modal: true,
    initComponent: function() {
        this.items = [
			{	xtype: 'form',
				padding: '5 5 5 5',
				border: false,
				items: [
					{	xtype: 'textareafield',
						height: 60,
						id: 'modposters_tituloAlocaRev',
						labelAlign: 'top',
						fieldLabel: 'Título trabalho',
						readOnly: true,
						anchor: '100%'
					}
				]
			},
            {   xtype: 'panel',
				layout: {
					type: 'hbox'
				},
                items: [					
					{	xtype: 'gridpanel',
						flex: 2,
						border: true,
						height: 570,
						tbar: [
							{	xtype: 'combobox',
								fieldLabel: 'Área específica',
								id: 'modposters_comboAreaEspecifica',
								disabled: true,
								queryMode: 'local',
								width: 450,
								editable: false,
								store: new Ext.data.JsonStore({
									proxy: {
										type: 'ajax',
										url: 'Server/posters/listarAreaEspecifica.php',
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
								typeAhead: false,
								valueField: 'id',
								displayField: 'descricao_area_especifica',
								triggerAction: 'all',
								listeners:{
									select: function(combo){
										row = Ext.getCmp('modposters_gridPostersTrabalhos').getSelectionModel().getSelection()[0];
										var gridAlocaRev = Ext.getCmp('modposters_gridAlocaRev');
										gridAlocaRev.getStore().getProxy().extraParams = {
											id_area: row.data.fgk_area,
											id_trabalho:  row.data.id,
											id_area_especifica:  combo.getValue()
										};
										gridAlocaRev.getStore().load();
									}
								}
							}
						],
						id: 'modposters_gridAlocaRev',
						store: 'AlocaRev',
						listeners: {
							itemclick: function(grid, record){
								var row = Ext.getCmp('modposters_gridPostersTrabalhos').getSelectionModel().getSelection()[0];
								var gridAlocaSessao = Ext.getCmp('modposters_gridAlocaSessao');
								gridAlocaSessao.getStore().getProxy().extraParams = {
									id_revisor: record.data.id,
									id_area: row.data.fgk_area
								};
								gridAlocaSessao.getStore().load();
							}
						},
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
								{ 	text: 'Revisor',
									dataIndex: 'nome',
									flex: 1.5
								},
								{ 	text: 'Área específica',
									dataIndex: 'descricao_area_especifica',
									flex: 1
								},
								{ 	text: 'Alocados',
									dataIndex: 'alocados',
									align: 'center',
									width: 80,
									renderer: function(value, metaData, record, rowIndex, colIndex, store){
										metaData.tdAttr = 'data-qtip="' + record.data.tooltip + '"';
										return value;
									}
								}
							]
						}
					},
					{	xtype: 'gridpanel',
						flex: 1.2,
						border: true,
						height: 650,
						id: 'modposters_gridAlocaSessao',
						store: 'AlocaSessao',
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
									dataIndex: 'id',
									hidden:true
								},
								{ 	text: 'Sessão',
									dataIndex: 'nome',
									flex: 1
								},
								{ 	text: 'Alocados',
									dataIndex: 'total',
									align: 'center',
									width: 80
								},
								{ 	text: 'Capacidade',
									dataIndex: 'capacidade',
									align: 'center',
									width: 90
								}
							]
						}
					}
				]
			}
        ];
        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            id:'buttons',
            ui: 'footer',
            items: [

				'->',
				{	iconCls: 'icon-save',
					text: 'Salvar',
					itemId: 'btnSalvarRevisorSessao'
				},
				{	iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
