Ext.define('Seic.view.Revisores.gridRevisores' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modrevisores_gridRevisores',
	id: 'modrevisores_gridRevisores',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.Revisores.formCadRevisor',
		'Seic.view.Revisores.formMensagemEmail',
		'Seic.view.Revisores.formBuscaAvancada',
	],
    store: 'Revisores',
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
			{	header: "CPF",
				dataIndex: 'cpf',
				width: 110,
				align: 'center'
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex: 1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Área",
				dataIndex: 'codigo_area',
				width: 80,
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
			{	header: "Tipo",
				dataIndex: 'descricao_tipo',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Prograd",
				dataIndex: 'bool_avaliador_prograd',
				width: 70,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value){
						metaData.tdCls = 'icon-check';
					}else{
						metaData.tdCls = 'icon-none';
					}
				}
			},
			{	header: "Proex",
				dataIndex: 'bool_avaliador_proex',
				width: 60,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value){
						metaData.tdCls = 'icon-check';
					}else{
						metaData.tdCls = 'icon-none';
					}
				}
			},
			{	header: "CAINT",
				dataIndex: 'bool_avaliador_caint',
				width: 60,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value){
						metaData.tdCls = 'icon-check';
					}else{
						metaData.tdCls = 'icon-none';
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
						itemId: 'btnAdicionarRevisor'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarRevisor'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarRevisor'
					},
					{	xtype: 'splitbutton',
						text: 'Mensagem',
						itemId: 'btnMensagem',
						iconCls: 'icon-email',
						handler: function() {
							this.showMenu();
						},
						menu: new Ext.menu.Menu({
							items: [
								{	text: 'Email',
									itemId:'itemMensagemEmail'
								},
								{	text: 'SMS',
									iconCls: 'icon-sms',
									itemId:'itemMensagemSMS'
								}
							]
						})
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Revisores',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					}
				]
			},
			{	xtype: 'toolbar',
				id: 'modrevisores_toolbarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Revisores',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
