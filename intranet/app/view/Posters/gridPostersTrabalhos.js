Ext.define('Seic.view.Posters.gridPostersTrabalhos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modposters_gridPostersTrabalhos',
	id: 'modposters_gridPostersTrabalhos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.Posters.formAlocarRevisorSessao',
		'Seic.view.Posters.formBuscaAvancada',
		'Seic.view.Posters.formEmailAvaliadores',
		'Seic.view.Posters.formEmailAutores',
	],
	title: 'Trabalhos',
    store: 'PostersTrabalhos',
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
			{	header: "Área",
				dataIndex: 'codigo_area',
				width: 70,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_area + '"';
					return value;
				}
			},
			{	header: "Título",
				dataIndex: 'titulo_enviado',
				flex: 2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Órgão",
				dataIndex: 'sigla_orgao',
				align: 'center',
				width: 100,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.nome_orgao + '"';
					return value;
				}
			},
			{	header: "Cód. Poster",
				dataIndex: 'cod_poster',
				align: 'center',
				width: 100
			},
			{	header: "Sessão",
				dataIndex: 'nome_sessao',
				flex: 1
			},
			{	header: "Avaliador",
				dataIndex: 'avaliador',
				flex: 1
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
					{	text: 'Alocar',
						iconCls: 'icon-add',
						itemId: 'btnAlocarRevisorSessao'
					},
					// {	text: 'Editar',
						// iconCls: 'icon-edit'
					// },
					{	text: 'Desalocar',
						iconCls: 'icon-delete',
						itemId: 'btnDesalocarRevisorSessao'
					},
					{	xtype: 'splitbutton',
						text: 'Mensagem',
						itemId: 'btnEmail',
						iconCls: 'icon-email',
						handler: function() {
							this.showMenu();
						},
						menu: new Ext.menu.Menu({
							items: [
								{	text: 'Email para avaliadores',
									itemId:'itemEmailAvaliadores'
								},
								{	text: 'Email para autores',
									itemId:'itemEmailAutores'
								}
							]
						})
					},
					'-',
					{	xtype: 'searchfield',
						width: 250,
						store: 'PostersTrabalhos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					},'->',
					{   text: 'Exportar',
			            itemId: 'btnExport',
			            iconCls: 'icon-excel'
			        },
				]
			},{	xtype: 'toolbar',
				id: 'modposters_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'PostersTrabalhos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
