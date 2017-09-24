Ext.define('Seic.model.Financeiro.Pagamentos',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'nome', 
        type: 'string'
    },{
        name: 'descricao_servico', 
        type: 'string'
    },{
        name: 'valor_boleto', 
        type: 'string'
    },{
        name: 'valor_pago', 
        type: 'int'
    },{
        name: 'datahora_pagamento', 
        type: 'date',
        dateFormat: 'c'
    },{
        name: 'fgk_tipo_pagamento',
        type: 'int'
    }]
});