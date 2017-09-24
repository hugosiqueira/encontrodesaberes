Ext.define('Seic.view.Admin.tabCheckpoints',{
	extend: 'Ext.panel.Panel',
	id: 'modadmin_tabcheckpoints',
	alias: 'widget.modadmin_tabcheckpoints',
	resizable: false,
    border: false,

	items:[{
		xtype: 'grid',
		store: 'Seic.store.Admin.Checkpoint',
		itemId: 'gridCheckpoints',
		id: 'gridCheckpoints',
		autoScroll: true,
		resizable: false,
		border: false,
		columns: [{
			text: 'Descrição do local',
			dataIndex: 'descricao_local',
			flex: 0.6,
			menuDisabled: true,
			resizable: false
		},{
			text: 'Apelido',
			dataIndex: 'apelido_local',
			flex: 0.2,
			menuDisabled: true,
			resizable: false
		},{
			text: 'Responsáveis',
			dataIndex: 'num_resp',
			flex: 0.2,
			menuDisabled: true,
			resizable: false
		}]
	}],

	dockedItems: [{
		xtype: 'toolbar',
		dock: 'top',
		items: [{
			text: 'Adicionar',
			itemId: 'addLocal',
			iconCls: 'icon-add',
			width: 100
		},{
			text: 'Editar',
			itemId: 'editLocal',
			iconCls: 'icon-edit',
			width: 100,
			disabled: true
		},{
			text: 'Apagar',
			itemId: 'apagarLocal',
			iconCls: 'icon-delete',
			width: 100,
			disabled: true
		},{
			text: 'Responsáveis',
			itemId: 'respLocal',
			iconCls: 'icon-chain',
			width: 110,
			disabled: true
		}]
	}]
});