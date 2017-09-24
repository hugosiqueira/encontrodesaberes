Ext.define('Seic.model.Credenciamento.Credenciamento', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'id', 
    	type: 'int'
    },{
        name: 'nome', 
        type: 'string'
    },{
        name: 'cpf', 
        type: 'string'
    },{
        name: 'fgk_tipo', 
        type: 'int'
    },{
        name: 'nome_instituicao',
        type: 'string'
    },{
        name: 'valor',
        type: 'int'
    },{
        name: 'bool_inscricao_paga',
        type: 'int'
    },{
        name: 'valor_pago',
        type: 'int'
    },{
        name: 'credenciado',
        type: 'int'
    }]
});