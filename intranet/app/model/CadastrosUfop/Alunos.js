Ext.define('Seic.model.CadastrosUfop.Alunos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_aluno', 				type: 'int'},
		{name: 'matricula',				type: 'string'},
		{name: 'nome',					type: 'string'},
		{name: 'email',					type: 'string'},
		{name: 'cpf',					type: 'string'},
		{name: 'fgk_curso',				type: 'int'},
		{name: 'bool_pos',				type: 'int'},
		{name: 'bool_monitoria',		type: 'int'},
		{name: 'mobilidade_ano_passado',type: 'int'},
		{name: 'mobilidade_ano_atual',	type: 'int'},
		{name: 'descricao_curso',		type: 'string'}
	]
});