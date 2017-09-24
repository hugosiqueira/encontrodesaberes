Ext.define('Seic.model.Projetos.Orgao', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'id', 
    	type: 'int'
    },{
    	name: 'nome',
    	type: 'string'
    },{
    	name: 'sigla',
    	type: 'string'
    }]
});