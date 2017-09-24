Ext.define('Seic.model.Projetos.Orientador', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'cpf', 
    	type: 'string'
    },{
    	name: 'nome',
    	type: 'string'
    },{
    	name: 'fgk_departamento',
    	type: 'string'
    }]
});