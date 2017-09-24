Ext.define('Seic.model.Financeiro.gridPrincipal',{
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
        name: 'descricao_tipo', 
        type: 'string'
    },{
        name: 'nome_instituicao',
        type: 'string'
    },{
        name: 'sigla_instituicao',
        type: 'string'
    },{
        name: 'quite',
        type: 'int'
    },{
        name: 'credencial',
        type: 'int'
    },{
        name: 'telefone_celular',
        type: 'string'
    },{
        name: 'bool_cracha',
        type: 'int'
    }]
});