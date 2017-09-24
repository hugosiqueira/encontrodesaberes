Ext.define('Seic.model.Financeiro.InscServicos',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'id_inscrito_servico',
        type: 'int'
    },{
    	name: 'id_servico', 
    	type: 'int'
    },{
        name: 'valor_servico', 
        type: 'int'
    },{
        name: 'descricao_servico', 
        type: 'string'
    },{
        name: 'bool_pago', 
        type: 'int'
    }]
});