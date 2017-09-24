Ext.define('Seic.view.Financeiro.tabPagamentos',{
	extend: 'Ext.panel.Panel',
	alias: 'widget.modfin_tabpagamentos',
	id: 'modfin_tabpagamentos',
	resizable: false,
    border: false,

	items:[{
		xtype: 'grid',
		itemId: 'gridPagamentos',
		store: 'Seic.store.Financeiro.Pagamentos',
		border: false,
	    columns: {
	        defaults: {
	            menuDisabled: true,
	            resizable: false
	        },

	        items: [{
		    	text: 'Data pagamento', 
		    	dataIndex: 'datahora_pagamento',
		    	flex: 0.12,
		    	xtype: 'datecolumn',
		    	format:'d/m/Y',
		    	align: 'center'
		    },{
		    	text: 'Nome inscrito',  
		    	dataIndex: 'nome',
		    	flex: 0.35
		    },{
		    	text: 'Serviço',  
		    	dataIndex: 'descricao_servico',
		    	flex: 0.33
		    },{ 
		    	text: 'Valor serviço', 
		    	dataIndex: 'valor_boleto',
		    	flex: 0.1,
		    	renderer: function(value, metaData){
		    		if(!value){
		    			metaData.tdCls = 'bold-green';
		    			if(metaData.record.data.fgk_tipo_pagamento = 6)
		    				return "Insc. Rápida"
		    			else
				    		return "Dinheiro"
		    		}else{
			        	Ext.apply(Ext.util.Format, {
		                    thousandSeparator : ".",
		                    decimalSeparator  : ","
		                });
			        	return "R$ " + Ext.util.Format.number(value/100, '0.0,0');
			        }
		        }
		    },{
		    	text: 'Valor pago', 
		    	dataIndex: 'valor_pago',
		    	flex: 0.1,
		    	renderer: function(value, metaData){
		        	Ext.apply(Ext.util.Format, {
	                    thousandSeparator : ".",
	                    decimalSeparator  : ","
	                });
		        	return "R$ " + Ext.util.Format.number(value/100, '0.0,0');
		        }
		    }]
		}
	}],

	dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        defaults: {
        	width: 140
        },

        items: [{
	        xtype: 'displayfield',
	        id: 'modfin_receitaEventoTotal',
	        labelStyle: 'color: #66AB16; font-weight: bold;',
	        fieldLabel: 'Receita total:',
	        labelWidth: 85,
	        value: 0,
	        width: 220
	    },{
	        xtype: 'displayfield',
	        id: 'modfin_receitaEventoFiltro',
	        labelStyle: 'color: #66AB16; font-weight: bold;',
	        fieldLabel: 'Receita filtro:',
	        labelWidth: 85,
	        value: 0,
	        width: 220,
	        hidden: true
	    },'->',{
            xtype: 'searchfield',
            store: 'Seic.store.Financeiro.Pagamentos',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },{
        	text: 'Busca avançada',
        	itemId: 'BA_pagamentos'
        },{   
			text: 'Exportar',
			iconCls: 'icon-excel',
			itemId: 'btnExportarExcel',
			width: 100
		}]
    },{
        xtype: 'toolbar',
        id: 'modcfin_barraBuscaPagamentos',
        dock: 'top',
        hidden: true,
        style: {
            background: '#FF6666'
        }
    },{  
        xtype: 'pagingtoolbar',
        dock: 'bottom',
        store: 'Seic.store.Financeiro.Pagamentos',
        displayInfo: true,
        displayMsg: 'Exibindo {0} - {1} de {2} pagamentos',
        emptyMsg: "Nenhum pagamento encontrado."
    }]
});