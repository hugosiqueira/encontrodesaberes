Ext.define('Seic.view.Posters.gridSessoes' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modposters_gridSessoes',
	id: 'modposters_gridSessoes',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
	title: 'Sessões',
    store: 'Sessoes',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_sessao",
				dataIndex: 'id',
				hidden:true
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y',
				header: "Data",
				width: 90,
				dataIndex: 'dia',
				align: 'center'
			},
			{	header: "Início",
				dataIndex: 'hora_ini',
				width: 75,
				align: 'center'
			},
			{	header: "Fim",
				dataIndex: 'hora_fim',
				width: 75,
				align: 'center'
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex: 2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Sessão",
				dataIndex: 'sessao',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			}
		]
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						itemId: 'btnAdicionarSessao'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarSessao'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarSessao'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Sessoes',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Sessoes',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhuma sessão encontrada."
			}
		];
		this.callParent(arguments);
	}
});
