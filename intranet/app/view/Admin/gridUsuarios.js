Ext.define('Seic.view.Admin.gridUsuarios' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridusuarios',
	title: 'Usuários',
	id: 'gridUsuarios',
    requires: [
		'Ext.toolbar.Paging',
		'Seic.store.Admin.Usuarios',
		'Seic.view.Admin.formCadUsuario',
		'Seic.view.Admin.formCadUsuarioGrupo',
		'Ext.ux.form.SearchField'
	],
    store: 'Usuarios',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_usuario",
				dataIndex: 'id_usuario',
				hidden:true
			},
			{	header: "Nome",
				flex: 1,
				dataIndex: 'nome_usuario'
			},
			{	header: "Login",
				width: 150,
				dataIndex: 'login'
			},
			{	header: "Grupo",
				width: 150,
				dataIndex: 'grupo'
			},
			{	header: "Eventos vinculados",
				width: 150,
				align: 'center',
				dataIndex: 'eventos_vinculados'
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
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						id: 'btnAdicionarUsuario',
						iconCls: 'icon-add',
						action: 'adicionarUsuario'
					},
					{	text: 'Editar',
						id: 'btnEditarUsuario',
						iconCls: 'icon-edit',
						action: 'editarUsuario'
					},
					{	text: 'Apagar',
						id: 'btnApagarUsuario',
						iconCls: 'icon-delete',
						action: 'apagarUsuario'
					},
					{	text: 'Definir grupo',
						id: 'btnUsuarioGrupo',
						iconCls: 'icon-groups',
						action: 'definirGrupo'
					},
					{	text: 'Definir eventos',
						id: 'btnUsuarioEventos',
						iconCls: 'icon-events',
						action: 'definirEventos'
					},
					{	text: 'Ativar usuário',
						id: 'btnLiberarUsuario',
						iconCls: 'icon-unlock',
						action: 'liberarUsuario'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Usuarios',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Usuarios',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum usuário encontrado."
			}
		];
		this.callParent(arguments);
	}
});
