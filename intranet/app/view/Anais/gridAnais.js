Ext.define('Seic.view.Anais.gridAnais' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modanais_gridAnais',
	id: 'modanais_gridAnais',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.Anais.formBuscaAvancada',
		'Seic.view.Anais.formAnais',
		'Ext.ux.form.SearchField'
	],
    store: 'Seic.store.Anais.Anais',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false,
			sortable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id',
				hidden:true
			},
			{	header: "Trabalho",
				dataIndex: 'titulo',
				flex: 2
			},
			{	header: "Área específica",
				dataIndex: 'descricao_area_especifica',
				flex: 1
			},
			{	header: "Premiado",
				dataIndex: 'bool_premiado',
				width: 90,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Premiado"';
						metaData.tdCls = 'icon-check';
					}
				}
			}
		]
	},
	listeners: {
		afterrender: function(){
			this.getStore().clearFilter();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						itemId: 'btnAdicionarAnais'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarAnais'
					},
					// {	text: 'Premiar',
						// iconCls: 'icon-check',
						// disabled: false,
						// id: 'btnPremiarAnais'
					// },
					'-',
					{	xtype: 'searchfield',
						width: 250,
						store: 'Seic.store.Anais.Anais',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					}
				]
			},{	xtype: 'toolbar',
				id: 'modanais_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Seic.store.Anais.Anais',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
