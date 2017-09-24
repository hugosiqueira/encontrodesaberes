Ext.define('Seic.model.MiniProp.MiniCursosPropostos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_minicurso_prop', 	type: 'int'},
		{name: 'fgk_inscrito', 			type: 'int'},
		{name: 'fgk_area_especifica', 	type: 'int'},
		{name: 'descricao_area_especifica',	type: 'string'},
		{name: 'rend_status', 				type: 'string'},
		{name: 'assunto', 				type: 'string'},
		{name: 'resumo', 				type: 'string'},
		{name: 'status', 				type: 'int'},
		{name: 'fgk_evento', 			type: 'int'},
		{name: 'nome', 					type: 'string'},
		{name: 'cpf',					type: 'string'}
	]
});