Ext.define('Seic.model.Financeiro.Detalhamento',{
	extend: 'Ext.data.Model',
    fields: [{
    	name: 'cpf', 
    	type: 'string'
    },{
        name: 'StatusBoleto',
        type: 'string'
    },{
        name: 'Valor', 
        type: 'int'
    },{
        name: 'ValorPago', 
        type: 'int'
    },{
    	name: 'Desconto',
    	type: 'int'
    },{
        name: 'Emissao',
        type: 'string'
    },{
        name: 'Vencimento',
        type: 'string'
    },{
        name: 'Pagamento',
        type: 'string'
    },{
    	name: 'Chave',
    	type: 'string'
    }]
});