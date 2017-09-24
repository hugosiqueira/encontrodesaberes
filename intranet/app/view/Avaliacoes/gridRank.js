Ext.define('Seic.view.Avaliacoes.gridRank' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modaval_gridRank',
	id: 'modaval_gridRank',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Seic.store.Avaliacoes.RankGeral',
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
			{	header: "Área",
				dataIndex: 'codigo_area',
				width: 75,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_area + '"';
					return value;
				}
			},
			{	header: "Instituição",
				dataIndex: 'sigla_instituicao',
				width: 90,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.nome_instituicao + '"';
					return value;
				}
			},
			{	header: "Trabalho",
				dataIndex: 'titulo_enviado',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Nota",
				dataIndex: 'nota_geral',
				width: 80,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.tooltip + '"';
					return Ext.util.Format.number(value, '0.0,0');
				}
			}
		]
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					// {	text: 'Avaliar trabalho',
						// iconCls: 'icon-edit',
						// itemId: 'btnAvaliarTrabalho'
					// },
					// {	text: 'Cód. Barras',
						// iconCls: 'icon-barcode',
						// itemId: 'btnCodBarras'
					// },
					// {	xtype: 'splitbutton',
						// text: 'Imprimir',
						// iconCls: 'icon-print',
						// handler: function() {
							// this.showMenu();
						// },
						// menu: new Ext.menu.Menu({
							// items: [
								// {	text: 'Fichas de avaliação',
									// itemId:'itemImprimirFicha'
								// },
								// {	text: 'Resumos',
									// itemId:'itemImprimirResumo'
								// }
							// ]
						// })
					// },
					// {	text: 'Classificação geral',
						// iconCls: 'icon-rank',
						// itemId: 'btnRank'
					// },
					// '-',
					{	xtype: 'searchfield',
						width: 300,
						store: 'Seic.store.Avaliacoes.RankGeral',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},'-',
					// {   text: 'Busca avançada',
						// iconCls: 'icon-search',
						// itemId: 'btnPesquisaAvancada'
					// }
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Seic.store.Avaliacoes.RankGeral',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhuma registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
