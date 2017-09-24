Ext.define('Seic.model.Monitoria.Monitoria', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 				type: 'int'},
		{name: 'fgk_evento',		type: 'int'},
		{name: 'fgk_status',		type: 'int'},
		{name: 'aluno_cpf',			type: 'string'},
		{name: 'aluno_nome',		type: 'string'},
		{name: 'aluno_email',		type: 'string'},
		{name: 'descricao_status',	type: 'string'},
		{name: 'descricao_area',	type: 'string'},
		{name: 'orientador_cpf',	type: 'string'},
		{name: 'orientador_nome',	type: 'string'},
		{name: 'orientador_email',	type: 'string'},
		{name: 'titulo',			type: 'string'},
		{name: 'resumo',			type: 'string'},
		{name: 'datahora_submissao',type: 'date', 	dateFormat: 'c'},
		{name: 'datahora_registro',	type: 'date', 	dateFormat: 'c'}
	]
});