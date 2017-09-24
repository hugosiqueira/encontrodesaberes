Ext.define('Seic.model.Projetos.Projetos', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'id', 
    	type: 'int'
    },{
    	name: 'fgk_area',
    	type: 'int'
    },{
        name: 'fgk_area_especifica',
        type: 'int'
    },{
    	name: 'fgk_instituicao',
    	type: 'int'
    },{
    	name: 'fgk_curso',
    	type: 'int'
    },{
    	name: 'fgk_orgao_fomento',
    	type: 'int'
    },{
    	name: 'fgk_programa_ic',
    	type: 'int'
    },{
    	name: 'fgk_departamento',
    	type: 'string'
    },{
        name: 'fgk_categoria',
        type: 'int'
    },{
        name: 'fgk_status',
        type: 'int'
    },{
    	name: 'aluno',
    	type: 'string'
    },{
    	name: 'aluno_cpf',
    	type: 'string'
    },{
        name: 'aluno_email',
        type: 'string'
    },{
    	name: 'apresentacao_obrigatoria',	
    	type: 'int'
    },{
    	name: 'codigo_area',
    	type: 'string'
    },{
        name: 'sigla_orgao',
        type: 'string'
    },{
    	name: 'orientador',
    	type: 'string'
    },{
    	name: 'orientador_cpf',
    	type: 'string'
    },{
        name: 'orientador_email',
        type: 'string'
    },{
        name: 'sigla_categoria',
        type: 'string'
    },{
        name: 'sigla_programa',
        type: 'string'
    },{
    	name: 'titulo',
    	type: 'string'
    },{
        name: 'nome_programa_ic',
        type: 'string'
    },{
        name: 'bool_trabalho',
        type: 'int'
    }]
});