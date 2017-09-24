Ext.define('Seic.view.Admin.tabServicos',{
	extend: 'Ext.panel.Panel',
	id: 'modadmin_tabservicos',
	alias: 'widget.modadmin_tabservicos',
	resizable: false,
    border: false,

	items:[{
		xtype: 'grid',
		itemId: 'gridServico',
		store: 'Seic.store.Admin.Servicos',
		autoScroll: true,
		border: false,
	    columns: {
	        defaults: {
	            menuDisabled: true,
	            resizable: false
	        },

	        items: [{
		    	text: 'Serviço',  
		    	dataIndex: 'descricao_servico',
		    	flex: 0.7
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
		dock: 'top',
		items: [{
			text: 'Adicionar',
			itemId: 'addServico',
			iconCls: 'icon-add',
			width: 100
		},{
			text: 'Editar',
			itemId: 'editServico',
			iconCls: 'icon-edit',
			width: 100,
			disabled: true
		},{
			text: 'Apagar',
			itemId: 'apagarServico',
			iconCls: 'icon-delete',
			width: 100,
			disabled: true
		}]
	}]
});