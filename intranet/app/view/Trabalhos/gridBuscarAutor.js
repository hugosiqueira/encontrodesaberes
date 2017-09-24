Ext.define('Seic.view.Trabalhos.gridBuscarAutor' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modtrabalhos_gridBuscarAutor',
	id: 'modtrabalhos_gridBuscarAutor',
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'BuscarAutores',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "CPF",
				width: 110,
				dataIndex: 'cpf'
			},
			{	header: "Nome",
				flex: 1.5,
				dataIndex: 'nome'
			},
			{	header: "Matrícula/Siape",
				width: 120,
				align: 'center',
				dataIndex: 'matricula_siape'				
			},
			{	header: "Tipo",
				flex: 1,
				dataIndex: 'tipo'
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
					{	text: 'Selecionar autor',
						iconCls: 'icon-add',
						itemId: 'btnSelecionarAutor'
					},'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'BuscarAutores',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'BuscarAutores',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
