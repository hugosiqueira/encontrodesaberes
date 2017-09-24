Ext.define('Seic.view.Revisores.gridBuscarRevisor' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modrevisores_gridBuscarRevisor',
	id: 'modrevisores_gridBuscarRevisor',
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'BuscarRevisores',
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
					{	text: 'Selecionar revisor',
						iconCls: 'icon-add',
						itemId: 'btnSelecionarRevisor'
					},'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'BuscarRevisores',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'BuscarRevisores',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
