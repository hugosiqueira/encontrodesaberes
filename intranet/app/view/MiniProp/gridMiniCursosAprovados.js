Ext.define('Seic.view.MiniProp.gridMiniCursosAprovados' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modminiprop_gridMiniCursosAprovados',
	id: 'modminiprop_gridMiniCursosAprovados',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
	title: 'Aprovados',
    store: 'MiniCursosAprovados',
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
			{	header: "Título",
				dataIndex: 'titulo',
				flex: 2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Apresentador",
				dataIndex: 'apresentador',
				flex: 1.2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Publicado",
				dataIndex: 'bool_publicado',
				align: 'center',
				width: 75,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Sim"';
						metaData.tdCls = 'icon-check';
					}
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
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnVisualizarMiniCursoAprovado'
					},
					// {	text: 'Alterar status',
						// iconCls: 'icon-edit',
						// itemId: 'btnAlterarStatus'
					// },
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'MiniCursosAprovados',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'MiniCursosAprovados',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
