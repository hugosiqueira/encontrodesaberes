Ext.define('Seic.model.Financeiro.Boletos',{
	extend: 'Ext.data.Model',
    fields: [{
    	name: 'id', 
    	type: 'int'
    },{
        name: 'id_boleto',
        type: 'int'
    },{
        name: 'bool_pago', 
        type: 'int'
    },{
        name: 'descricao_servico', 
        type: 'string'
    },{
        name: 'nome', 
        type: 'string'
    },{
        name: 'data_vencimento',
        type: 'date',
        dateFormat: 'c'
    },{
        name: 'valor_servico', 
        type: 'int'
    },{
        name: 'link', 
        type: 'string'
    },{
        name: 'valor_pago', 
        type: 'int'
    },{
        name: 'data_pagamento', 
        type: 'date',
        dateFormat: 'c'
    }]
});