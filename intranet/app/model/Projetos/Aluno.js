Ext.define('Seic.model.Projetos.Aluno', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'cpf', 
    	type: 'string'
    },{
    	name: 'nome',
    	type: 'string'
    },{
    	name: 'descricao_curso',
    	type: 'string'
    }]
});