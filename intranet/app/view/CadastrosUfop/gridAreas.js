Ext.define('Seic.view.CadastrosUfop.gridAreas' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridAreas',
	id: 'modcadufop_gridAreas',
	title: 'Áreas',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Areas',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id_area',
				hidden:true
			},
			{	header: "Código",
				dataIndex: 'codigo_area',
				flex: 1
			},			
			{	header: "Área",
				dataIndex: 'descricao_area',
				flex: 3
			},
		]
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
			// this.getStore().load();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						itemId: 'btnAdicionarArea'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarArea'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarArea'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Areas',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					// {   text: 'Busca avançada',
						// iconCls: 'icon-search',
						// itemId: 'btnPesquisaAvancada'
					// }
				]
			},
			// {	xtype: 'toolbar',
				// id: 'modcadufop_toolBarAlunos',
				// region: 'top',
				// hidden: true,
				// frame: true,
				// height: 40,
				// style:"background:IndianRed;",
				// collapsible: true
			// },
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Areas',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
