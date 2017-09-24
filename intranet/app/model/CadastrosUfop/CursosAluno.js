Ext.define('Seic.model.CadastrosUfop.CursosAluno', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_curso', 			type: 'int'},
		{name: 'fgk_departamento',	type: 'string'},
		{name: 'codigo', 			type: 'string'},
		{name: 'descricao_curso', 	type: 'string'},
		{name: 'modalidade', 		type: 'string'},
		{name: 'rend_curso', 		type: 'string'},
	]
});