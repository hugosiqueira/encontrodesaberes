Ext.define('Seic.model.Anais.AutoresAnais', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'fgk_trabalho_anais', 		type: 'int'},
		{name: 'email', 		type: 'string'},
		{name: 'instituicao', 		type: 'string'},
		{name: 'nome', 		type: 'string'},
		{name: 'nome_citacao', 		type: 'string'},
		{name: 'seq', 		type: 'int'},
		{name: 'fgk_tipo', 		type: 'int'},
		{name: 'descricao_tipo', 		type: 'string'}
	]
});