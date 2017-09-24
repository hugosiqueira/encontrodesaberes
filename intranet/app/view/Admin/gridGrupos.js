Ext.define('Seic.view.Admin.gridGrupos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridgrupos',
	title: 'Grupos',
	id: 'gridGrupos',
    requires: [
		'Ext.toolbar.Paging'
		,'Seic.store.Admin.Grupos'
		,'Seic.view.Admin.formCadGrupo'
		,'Seic.view.Admin.panelModulosPermissoes'
		,'Seic.view.Admin.gridGruposModulos'
		,'Seic.view.Admin.gridGruposPermissoes'
	],
    store: 'Grupos',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_grupo",
				dataIndex: 'id_grupo',
				hidden:true
			},
			{	header: "Grupo",
				width: 150,
				dataIndex: 'grupo'
			},
			{	header: "Descrição",
				width: 150,
				dataIndex: 'descricao_grupo',
				flex:1
			},
			{	header: "Usuários",
				width: 80,
				dataIndex: 'usuarios',
				align: 'center'
			},
			{	header: "Ativo",
				width: 60,
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
	initComponent: function(a) {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						id: 'btnAdicionarGrupo',
						iconCls: 'icon-add',
						action: 'adicionarGrupo'
					},
					{	text: 'Editar',
						id: 'btnEditarGrupo',
						iconCls: 'icon-edit',
						action: 'editarGrupo'
					},
					{	text: 'Apagar',
						id: 'btnApagarGrupo',
						iconCls: 'icon-delete',
						action: 'apagarGrupo'
					},
					{	text: 'Definir módulos',
						id: 'btnModulosGrupo',
						iconCls: 'icon-access',
						action: 'acessosGrupo'
					},
					{	text: 'Ativar grupo',
						id: 'btnLiberarGrupo',
						iconCls: 'icon-unlock',
						action: 'liberarGrupo'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Grupos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}				
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Grupos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum grupo encontrado."
			}
		];
		this.callParent(arguments);
	}
});
