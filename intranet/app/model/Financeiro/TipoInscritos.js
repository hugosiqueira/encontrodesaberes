Ext.define('Seic.model.Financeiro.TipoInscritos',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'id_tipo_inscrito', 
        type: 'int'
    },{
        name: 'descricao_tipo',
        type: 'string'
    }]
});