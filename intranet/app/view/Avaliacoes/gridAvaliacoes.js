Ext.define('Seic.view.Avaliacoes.gridAvaliacoes' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modaval_gridAvaliacoes',
	id: 'modaval_gridAvaliacoes',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.Avaliacoes.formBuscaAvancada',
		'Ext.ux.form.SearchField'
	],
    store: 'Seic.store.Avaliacoes.Avaliacoes',
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
				align: 'center'
			},
			{	header: "Cód. Poster",
				dataIndex: 'cod_poster',
				width: 90,
				align: 'center'
			},
			{	header: "Sessão",
				dataIndex: 'nome_sessao',
				width: 150,
				align: 'center'
			},
			{	header: "Trabalho",
				dataIndex: 'titulo_enviado',
				flex: 2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Avaliador",
				dataIndex: 'nome_avaliador',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Status",
				dataIndex: 'status',
				width: 70,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Avaliado."';
						metaData.tdCls = 'icon-aprovado';
					}
					else if(value == 0){
						metaData.tdAttr = 'data-qtip="Aguardando avaliação."';
						metaData.tdCls = 'icon-aguardando_submissao';
					}
					else if(value == 2){
						metaData.tdAttr = 'data-qtip="Apresentador ausente."';
						metaData.tdCls = 'icon-reprovado';
					}
				}
			}
		]
	},
	listeners: {
		afterrender: function(){
			this.getStore().clearFilter();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Avaliar trabalho',
						iconCls: 'icon-edit',
						itemId: 'btnAvaliarTrabalho'
					},
					{	text: 'Cód. Barras',
						iconCls: 'icon-barcode',
						itemId: 'btnCodBarras'
					},
					{	xtype: 'splitbutton',
						text: 'Imprimir',
						iconCls: 'icon-print',
						handler: function() {
							this.showMenu();
						},
						menu: new Ext.menu.Menu({
							items: [
								{	text: 'Fichas de avaliação',
									itemId:'itemImprimirFicha'
								},
								{	text: 'Resumos',
									itemId:'itemImprimirResumo'
								}
							]
						})
					},
					{	text: 'Classificação geral',
						iconCls: 'icon-rank',
						itemId: 'btnRank'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Seic.store.Avaliacoes.Avaliacoes',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					}
				]
			},{	xtype: 'toolbar',
				id: 'modaval_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Seic.store.Avaliacoes.Avaliacoes',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhuma avaliação encontrada."
			}
		];
		this.callParent(arguments);
	}
});
