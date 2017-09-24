Ext.define('Seic.view.CadastroIC.gridIC' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadic_gridIC',
	id: 'modcadic_gridIC',	
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.CadastroIC.formCadIC'
	],
    store: 'IC',
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
			{	header: "Programa",
				dataIndex: 'nome',
				flex: 1
			},
			{	header: "Apresentação",
				dataIndex: 'fgk_tipo_apresentacao',
				width: 110,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Apresentação em poster."';
						metaData.tdCls = 'icon-apresentacao_poster';
					}
					else if(value == 2){
						metaData.tdAttr = 'data-qtip="Apresentação oral."';
						metaData.tdCls = 'icon-apresentacao_oral';
					}
				}
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
						itemId: 'btnAdicionarIC'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarIC'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarIC'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'IC',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-'
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'IC',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
