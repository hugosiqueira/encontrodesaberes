Ext.define('Seic.view.Admin.gridEventos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.grideventos',
	title: 'Eventos',
	id: 'gridEventos',
    requires: [
		'Ext.toolbar.Paging'
		,'Seic.view.Admin.formCadEvento'
	],
    store: 'Eventos',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_evento",
				dataIndex: 'id_evento',
				hidden:true
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y',
				header: "Data início",
				width: 90,
				dataIndex: 'data_evento_ini',
				align: 'center'
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y',
				header: "Data fim",
				width: 90,
				dataIndex: 'data_evento_fim',
				align: 'center'
			},
			{	header: "Sigla",
				width: 100,
				dataIndex: 'sigla'
			},
			{	header: "Título",
				flex: 1,
				dataIndex: 'titulo'
			},
			{	header: "Usuários",
				width: 80,
				dataIndex: 'usuarios',
				align: 'center'
			}
		]
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
			// this.getStore().load();
		}
	},
	initComponent: function(a) {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						action: 'adicionarEvento',
						id: 'btnAdicionarEvento'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						action: 'editarEvento',
						id: 'btnEditarEvento'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						action: 'apagarEvento',
						id: 'btnApagarEvento'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Eventos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Eventos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum evento encontrado."
			}
		];
		this.callParent(arguments);
	}
});
