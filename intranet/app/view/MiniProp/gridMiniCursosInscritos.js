Ext.define('Seic.view.MiniProp.gridMiniCursosInscritos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modminiprop_gridMiniCursosInscritos',
	id: 'modminiprop_gridMiniCursosInscritos',
	// emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.MiniProp.formCadMiniCursosInscritos',
		'Ext.ux.form.SearchField'
	],
	title: 'Inscritos',
    store: 'MiniCursosInscritos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id',
				hidden:true
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex: 1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Email",
				dataIndex: 'email',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Serviço",
				dataIndex: 'descricao_servico',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Confirmado",
				dataIndex: 'bool_pago',
				align: 'center',
				width: 100,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Sim"';
						metaData.tdCls = 'icon-check';
					}
					else{
						metaData.tdAttr = 'data-qtip="Não"';
						metaData.tdCls = 'icon-inactive';
					}
				}
			}
		]
	},
	listeners: {
		render: function(){
			// this.getStore().clearFilter();
			Ext.getCmp('modminiprop_comboMiniCurso').getStore().load();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						disabled: true,
						id: 'modminiprop_btnAdicionarInscrito'
					},
					{	text: 'Lista de presença',
						iconCls: 'icon-print',
						itemId: 'btnImprimirLista'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'MiniCursosInscritos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},'->',
					{	xtype: 'combobox',
						fieldLabel: 'Minicurso',
						labelWidth: 60,
						flex: 3,
						id: 'modminiprop_comboMiniCurso',
						queryMode: 'local',
						allowBlank: false,
						editable: false,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/miniprop/listarMiniCursos.php',
								reader: {
									type: 'json',
									root: 'resultado'
								}
							},
							fields: [
								{name:'id', type: 'int'},
								{name:'titulo', type:'string'}
							]
						}),
						typeAhead: false,
						valueField: 'id',
						displayField: 'titulo',
						triggerAction: 'all',
						forceSelection:true,
						listeners: {
							select: function(combo, records) {
								storeGrid = combo.up('grid').getStore();
								storeGrid.getProxy().extraParams = {
									id_minicurso: combo.getValue()
								};
								storeGrid.load();
								Ext.getCmp('modminiprop_btnAdicionarInscrito').enable();
							}
						}
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'MiniCursosInscritos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
