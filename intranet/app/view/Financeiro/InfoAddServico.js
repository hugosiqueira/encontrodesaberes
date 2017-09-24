Ext.define('Seic.view.Financeiro.InfoAddServico',{
	extend: 'Ext.window.Window',
	alias: 'widget.modfin_infoaddservico',
	title: 'Adicionar serviço',
	iconCls:'financeiro-minishortcut',
	constrain: true,
	resizable: false,
	modal: true,
	width: 500,
	height: 370,

	items:[{
		xtype: 'grid',
		itemId: 'gridAddServico',
		store: 'Seic.store.Admin.Servicos',
		border: false,
	    columns: {
	        defaults: {
	            menuDisabled: true,
	            resizable: false
	        },

	        items: [{
		    	text: 'Serviço',  
		    	dataIndex: 'descricao_servico',
		    	flex: 1
		    },{
		    	text: 'Valor',  
		    	dataIndex: 'valor_servico',
		    	flex: 0.3,
		    	renderer: function(value, metaData){
		        	Ext.apply(Ext.util.Format, {
	                    thousandSeparator : ".",
	                    decimalSeparator  : ","
	                });
		        	return "R$" + Ext.util.Format.number(value/100, '0.0,0');
		        }
		    }]
		}
	}],

	dockedItems: [{
		xtype: 'toolbar',
		dock: 'bottom',
		border: false,
		items: ['->',{
			text: 'Selecionar',
			itemId: 'addServico2Inscrito',
			iconCls: 'icon-check',
			disabled: true,
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