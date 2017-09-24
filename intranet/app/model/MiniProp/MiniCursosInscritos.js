Ext.define('Seic.model.MiniProp.MiniCursosInscritos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 					type: 'int'},
		{name: 'fgk_minicurso', 		type: 'int'},
		{name: 'fgk_inscrito', 			type: 'int'},
		{name: 'fgk_inscrito_servico',	type: 'int'},
		{name: 'status', 				type: 'int'},
		{name: 'nome',	 				type: 'string'},
		{name: 'descricao_servico',	 				type: 'string'},
		{name: 'email',	 				type: 'string'},
		{name: 'bool_pago',				type: 'int'},

	]
});