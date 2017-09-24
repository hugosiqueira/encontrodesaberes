Ext.define('Seic.view.Financeiro.pgSelection',{
	extend: 'Ext.window.Window',
	alias: 'widget.modfin_pgselection',
	title: 'Pagamento',
	iconCls:'financeiro-minishortcut',
	constrain: true,
	resizable: false,
	modal: true,
	width: 350,
	autoHeight: true,
	layout: 'anchor',
	bodyPadding: 8,
	bodyBorder: false,
	border: false,

	items:[{
		xtype: 'form',
		border: false,
		items: [{
	        xtype: 'combobox',
	        itemId: 'comboPg',
	        fieldLabel: 'Forma de pagamento',
	        labelAlign: 'top',
	        valueField: 'id_tipo_pagamento',
	        displayField: 'descricao_pagamento', 
	        store: 'Seic.store.Financeiro.PgTipos',
	        queryMode: 'remote',
	        queryParam: 'filtro',
	        forceSelection: true,
	        allowBlank: false,
	        anchor: '100%'
	    },{
	        xtype: 'datefield',
	        itemId: 'dataVencimento',
	        name: 'dataVencimento',
	        fieldLabel: 'Data de vencimento',
	        labelWidth: 200,
	        format: 'd/m/Y',
	        submitFormat: 'Y-m-d',
	        anchor: '100%',
	        value: new Date(+new Date + 12096e5),
	        minValue: new Date(),
	        hidden: true,
	        disabled: true
	    }]
	}],

	dockedItems: [{
		xtype: 'toolbar',
		dock: 'bottom',
		items: ['->',{
			text: 'Confirmar',
			itemId: 'pgOk',
			iconCls: 'icon-check',
			width: 100
		},{
			text: 'Cancelar',
			iconCls: 'icon-cancel',
			width: 100,
			listeners: {
		        click: {
		            fn: function(button){ button.up('window').close(); }
		        }
		    }
		}]
	}]
});