Ext.define('Seic.view.CadastroOrgaos.gridOrgaos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadorgao_gridOrgaos',
	id: 'modcadorgao_gridOrgaos',	
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.CadastroOrgaos.formCadOrgao'
	],
    store: 'Orgaos',
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
			{	header: "Sigla",
				dataIndex: 'sigla',
				width: 110,
				align: 'center'
			},			
			{	header: "Órgão de Fomento",
				dataIndex: 'nome',
				flex: 1
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
						itemId: 'btnAdicionarOrgao'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarOrgao'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarOrgao'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Orgaos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-'
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Orgaos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
