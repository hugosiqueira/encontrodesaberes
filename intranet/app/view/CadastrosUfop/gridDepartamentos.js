Ext.define('Seic.view.CadastrosUfop.gridDepartamentos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridDepartamentos',
	id: 'modcadufop_gridDepartamentos',
	title: 'Departamentos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Departamentos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "Código",
				dataIndex: 'id_departamento',
				width: 110,
				align: 'center'
			},
			{	header: "Departamento",
				dataIndex: 'nome_departamento',
				flex: 3
			},
			{	header: "Área",
				dataIndex: 'descricao_area',
				flex: 1.5
			}
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
						itemId: 'btnAdicionarDepartamento'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarDepartamento'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarDepartamento'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Departamentos',
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
				store: 'Departamentos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
