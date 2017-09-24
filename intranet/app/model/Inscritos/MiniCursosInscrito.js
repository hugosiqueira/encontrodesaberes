Ext.define('Seic.model.Inscritos.MiniCursosInscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 			type: 'int'},
		{name: 'max_alunos', 	type: 'int'},
		{name: 'apresentador', 	type: 'string'},
		{name: 'titulo', 		type: 'string'},
		{name: 'resumo', 		type: 'string'}
	]
});