Ext.define('Seic.view.Admin.gridModulos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridmodulos',
	title: 'Módulos',
	id: 'gridModulos',
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.Admin.formCadModulo',
		'Ext.ux.form.SearchField'
	],
    store: 'Modulos',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_modulo",
				dataIndex: 'id_modulo',
				hidden:true
			},
			{	header: "Módulo",
				width: 100,
				flex:1,
				dataIndex: 'nome_modulo'
			},
			{	header: "Ativo",
				width: 70,
				align: 'center',
				dataIndex: 'bool_ativo',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1)
						metaData.tdCls = 'icon-unlock';
					else
						metaData.tdCls = 'icon-lock';
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
					{	text: 'Ativar módulo',
						id: 'btnLiberarModulo',
						iconCls: 'icon-unlock',
						action: 'liberarModulo'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Modulos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Modulos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum módulo encontrado."
			}
		];
		this.callParent(arguments);
	}
});
