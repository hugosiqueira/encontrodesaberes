Ext.define('Seic.model.Financeiro.TipoPagamentos',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'id_tipo_pagamento', 
        type: 'int'
    },{
        name: 'descricao_pagamento',
        type: 'string'
    }]
});