Ext.define('Seic.model.Admin.Servicos',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'id', 
        type: 'int'
    },{
        name: 'valor_servico',
        type: 'int'
    },{
        name: 'descricao_servico', 
        type: 'string'
    }]
});