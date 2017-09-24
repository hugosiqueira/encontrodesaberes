Ext.define('Seic.view.CadastrosUfop.gridAreasEspecificas' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridAreasEspecificas',
	id: 'modcadufop_gridAreasEspecificas',
	title: 'Áreas Específicas',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'AreasEspecificas',
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
			{	header: "Área",
				dataIndex: 'descricao_area',
				flex: 1.5
			},			
			{	header: "Área específica",
				dataIndex: 'descricao_area_especifica',
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
						itemId: 'btnAdicionarAreaEspecifica'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarAreaEspecifica'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarAreaEspecifica'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'AreasEspecificas',
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
				store: 'AreasEspecificas',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
