Ext.define('Seic.view.CadastroInstituicoes.gridInstituicoes' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadinstituicao_gridInstituicoes',
	id: 'modcadinstituicao_gridInstituicoes',	
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.CadastroInstituicoes.formCadInstituicao',
	],
    store: 'Instituicoes',
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
			{	header: "Instituição",
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
						itemId: 'btnAdicionarInstituicao'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarInstituicao'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarInstituicao'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Instituicoes',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-'
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Instituicoes',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
