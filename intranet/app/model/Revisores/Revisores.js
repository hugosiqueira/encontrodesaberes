Ext.define('Seic.model.Revisores.Revisores', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 						type: 'int'},
		{name: 'tipo_revisor', 				type: 'int'},
		{name: 'fgk_inscrito', 				type: 'int'},
		{name: 'fgk_area', 					type: 'int'},
		{name: 'fgk_area_especifica', 		type: 'int'},
		{name: 'bool_revisor', 				type: 'bool'},
		{name: 'bool_avaliador_prograd', 	type: 'bool'},
		{name: 'bool_avaliador_proex', 		type: 'bool'},
		{name: 'bool_avaliador_caint', 		type: 'bool'},
		{name: 'rend_departamento',			type: 'string'},
		{name: 'codigo_area', 				type: 'string'},
		{name: 'descricao_area_especifica', type: 'string'},
		{name: 'descricao_tipo', 			type: 'string'},
		{name: 'cpf', 						type: 'string'},
		{name: 'email', 					type: 'string'},
		{name: 'nome', 						type: 'string'}
	]
});