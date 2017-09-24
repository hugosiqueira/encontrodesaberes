Ext.define('Seic.model.CadastrosUfop.ProfessoresTA', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_professor', 				type: 'int'},
		{name: 'cod_siape',					type: 'string'},
		{name: 'nome',						type: 'string'},
		{name: 'fgk_tipo',					type: 'int'},
		{name: 'fgk_departamento',			type: 'string'},
		{name: 'email',						type: 'string'},
		{name: 'cpf',						type: 'string'},
		{name: 'bool_avaliador',			type: 'int'},
		{name: 'cursos',					type: 'string'},
		{name: 'bool_coordenador',			type: 'int'},
		{name: 'bool_monitoria',			type: 'int'}
	]
});