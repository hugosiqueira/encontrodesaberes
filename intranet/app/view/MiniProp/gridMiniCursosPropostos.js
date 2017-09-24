Ext.define('Seic.view.MiniProp.gridMiniCursosPropostos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modminiprop_gridMiniCursosPropostos',
	id: 'modminiprop_gridMiniCursosPropostos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
	title: 'Propostos',
    store: 'MiniCursosPropostos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_minicurso_prop",
				dataIndex: 'id_minicurso_prop',
				hidden:true
			},
			{	header: "Assunto",
				dataIndex: 'assunto',
				flex: 2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Responsável",
				dataIndex: 'nome',
				flex: 1.2,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Área específica",
				dataIndex: 'descricao_area_especifica',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Status",
				dataIndex: 'status',
				align: 'center',
				width: 75,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1){
						metaData.tdAttr = 'data-qtip="Em edição."';
						metaData.tdCls = 'icon-aguardando_submissao';
					}
					else if(value == 2){
						metaData.tdAttr = 'data-qtip="Submetido."';
						metaData.tdCls = 'icon-submetido';
					}
					else if(value == 3){
						metaData.tdAttr = 'data-qtip="Aprovado."';
						metaData.tdCls = 'icon-aprovado';
					}
					else if(value == 4){
						metaData.tdAttr = 'data-qtip="Rejeitado."';
						metaData.tdCls = 'icon-reprovado';
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
					{	text: 'Verificar',
						iconCls: 'icon-eye',
						itemId: 'btnVisualizarMiniProp'
					},
					{	text: 'Aprovar',
						iconCls: 'icon-check',
						itemId: 'btnAprovar'
					},
					{	text: 'Reprovar',
						iconCls: 'icon-delete',
						itemId: 'btnReprovar'
					},
					// {	text: 'Alterar status',
						// iconCls: 'icon-edit',
						// itemId: 'btnAlterarStatus'
					// },
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'MiniCursosPropostos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'MiniCursosPropostos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
