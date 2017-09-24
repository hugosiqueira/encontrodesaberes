Ext.define('Seic.view.Admin.viewCheckpoint',{
	extend: 'Ext.window.Window',
	alias: 'widget.modadmin_viewcheckpoint',
	title: 'Adicionar checkpoint',
	iconCls: 'presenca-minishortcut',
	constrain: true,
	resizable: false,
	modal: true,
	width: 400,
	maxHeight: 300,
	padding: 4,
	border: false,
	layout: {
        type: 'anchor',
        align: 'stretch'
    },

    items:[{
    	xtype: 'form',
    	border: false,
    	defaults: {
		    allowBlank: false,
		},
    	items:[{
    		xtype: 'hiddenfield',
    		name: 'id_local_presenca'
    	},{
    		xtype: 'textfield',
    		name: 'descricao_local',
	        fieldLabel: 'Descrição',
	        labelWidth: 65,
	        anchor: '100%',
	        allowBlank: false
    	},{
    		xtype: 'textfield',
    		name: 'apelido_local',
	        fieldLabel: 'Apelido',
	        labelWidth: 65,
	        anchor: '80%',
	        allowBlank: false
    	}]
    }],

    dockedItems:[{
		xtype: 'toolbar',
		dock: 'bottom',
		border: false,
		items: ['->',{
			text: 'Salvar',
			itemId: 'okCheck',
			iconCls: 'icon-save',
			width: 100
		}]
	}]
});