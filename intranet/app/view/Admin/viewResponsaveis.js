Ext.define('Seic.view.Admin.viewResponsaveis',{
	extend: 'Ext.window.Window',
	alias: 'widget.modadmin_viewresponsaveis',
	id: 'modadmin_viewresponsaveis',
	title: 'Adicionar responsável por checkpoint',
	iconCls: 'presenca-minishortcut',
	constrain: true,
	resizable: false,
	modal: true,
	width: 300,
	height: 300,
	bodyBorder: false,

    items:[{
		xtype: 'grid',
		store: 'Seic.store.Admin.Responsaveis',
		itemId: 'gridResponsaveis',
		id: 'modadmin_gridResponsaveis',
		autoScroll: true,
		resizable: false,
		border: false,
		columns: [{
			text: 'Usuário',
			dataIndex: 'nome_usuario',
			menuDisabled: true,
			resizable: false,
			flex: 1
		}]
	}],

    dockedItems:[{
		xtype: 'toolbar',
		dock: 'bottom',
		layout:{
            pack: 'center'
        },
		items: [{
			text: 'Adicionar',
			itemId: 'addResp',
			iconCls: 'icon-add',
			width: 100
		},{
			text: 'Apagar',
			itemId: 'apagarResp',
			iconCls: 'icon-delete',
			width: 100,
			disabled: true
		}]
	}]
});