Ext.define('Seic.model.MiniProp.MiniCursosAprovados', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 			type: 'int'},
		{name: 'fgk_evento', 	type: 'int'},
		{name: 'apresentador', 	type: 'string'},
		{name: 'classificacao',	type: 'int'},
		{name: 'data', 			type: 'date', 	dateFormat: 'c'},
		{name: 'hora_ini', 		type: 'string'},
		{name: 'hora_fim', 		type: 'string'},
		{name: 'local', 		type: 'string'},
		{name: 'max_alunos', 	type: 'int'},
		{name: 'resumo', 		type: 'string'},
		{name: 'titulo',		type: 'string'},
		{name: 'bool_publicado',type: 'int'},
		{name: 'datahora_registro',	type: 'date', 	dateFormat: 'c'}
	]
});