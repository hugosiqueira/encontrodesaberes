Ext.define('Seic.view.Admin.gridPermissoes' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridpermissoes',
	title: 'Permissões',
	id: 'gridPermissoes',
    requires: [
		'Ext.toolbar.Paging'
		,'Seic.store.Admin.Permissoes'
		,'Seic.view.Admin.formCadPermissao'
	],
    store: 'Permissoes',
    hidden: true,
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_permissao",
				dataIndex: 'id_permissao',
				hidden:true
			},
			{	header: "Módulo",
				width: 120,
				dataIndex: 'nome_modulo'
			},
			{	header: "Permissão",
				width: 150,
				dataIndex: 'permissao'
			},
			{	header: "Descrição",
				width: 100,
				dataIndex: 'descricao_permissao',
				flex:1
			}
			// {	header: "Ativo",
				// width: 70,
				// align: 'center',
				// dataIndex: 'bool_ativo',
				// renderer: function(value, metaData, record, rowIndex, colIndex, store){
					// if(value == 1)
						// return '<center><img src="resources/images/icon_ativo.png" ></center>';
					// else
						// return '<center><img src="resources/images/icon_inativo.png" ></center>';
				// }
			// }
		]		
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
			// this.getStore().load();
		}
	},	
	initComponent: function(a) {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						id: 'btnAdicionarPermissao',
						iconCls: 'icon-add',
						action: 'adicionarPermissao'
					},
					{	text: 'Editar',
						id: 'btnEditarPermissao',
						iconCls: 'icon-edit',
						action: 'editarPermissao'
					},
					{	text: 'Apagar',
						id: 'btnApagarPermissao',
						iconCls: 'icon-delete',
						action: 'apagarPermissao'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Permissoes',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Permissoes',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum módulo encontrado."
			}
		];
		this.callParent(arguments);
	}
});
