Ext.define('Seic.view.Admin.viewServico',{
	extend: 'Ext.window.Window',
	alias: 'widget.modadmin_viewservico',
	title: 'Serviço',
	iconCls: 'financeiro-minishortcut',
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

    requires:[ 'Ext.ux.CurrencyField' ],

    items:[{
    	xtype: 'form',
    	border: false,
    	defaults: {
		    allowBlank: false,
		},
    	items:[{
    		xtype: 'hiddenfield',
    		name: 'id'
    	},{
    		xtype: 'textfield',
    		name: 'descricao_servico',
	        fieldLabel: 'Descrição',
	        labelWidth: 65,
	        anchor: '100%'
    	},{
    		xtype: 'currencyfield',
    		itemId: 'valor_servico',
    		name: 'valor_servico',
    		fieldLabel: 'Valor',
    		value: 0,
    		labelWidth: 65,
	        anchor: '50%'
    	}]
    }],

    dockedItems:[{
		xtype: 'toolbar',
		dock: 'bottom',
		border: false,
		items: ['->',{
			text: 'Salvar',
			itemId: 'salvarServico',
			iconCls: 'icon-save',
			width: 100
		}]
	}]
});